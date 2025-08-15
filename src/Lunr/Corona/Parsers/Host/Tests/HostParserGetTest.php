<?php

/**
 * This file contains the HostParserGetTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2025 Framna Netherlands B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Corona\Parsers\Host\Tests;

use Lunr\Corona\Parsers\Host\HostValue;
use Lunr\Corona\Tests\Helpers\MockRequestValue;
use RuntimeException;

/**
 * This class contains test methods for the HostParser class.
 *
 * @backupGlobals enabled
 * @covers        Lunr\Corona\Parsers\Host\HostParser
 */
class HostParserGetTest extends HostParserTestCase
{

    /**
     * Test that getRequestValueType() returns the correct type.
     *
     * @covers Lunr\Corona\Parsers\Host\HostParser::getRequestValueType
     */
    public function testGetRequestValueType(): void
    {
        $this->assertEquals(HostValue::class, $this->class->getRequestValueType());
    }

    /**
     * Test getting an unsupported value.
     *
     * @covers Lunr\Corona\Parsers\Host\HostParser::get
     */
    public function testGetUnsupportedValue(): void
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Unsupported request value type "Lunr\Corona\Tests\Helpers\MockRequestValue"');

        $this->class->get(MockRequestValue::Foo);
    }

    /**
     * Test getting a parsed host.
     *
     * @covers Lunr\Corona\Parsers\Host\HostParser::get
     */
    public function testGetParsedHost(): void
    {
        $host = 'foo.example.com';

        $this->setReflectionPropertyValue('host', $host);
        $this->setReflectionPropertyValue('hostInitialized', TRUE);

        $value = $this->class->get(HostValue::Host);

        $this->assertEquals($host, $value);
    }

    /**
     * Test getting a parsed host.
     *
     * @covers Lunr\Corona\Parsers\Host\HostParser::get
     */
    public function testGetParsedNullHost(): void
    {
        $this->setReflectionPropertyValue('host', NULL);
        $this->setReflectionPropertyValue('hostInitialized', TRUE);

        $value = $this->class->get(HostValue::Host);

        $this->assertNull($value);
    }

    /**
     * Test getting a host when it's missing in the header.
     *
     * @covers Lunr\Corona\Parsers\Host\HostParser::get
     */
    public function testGetHostFromEnvironment(): void
    {
        $host = 'foo.example.com';

        $_ENV['HOSTNAME'] = $host;

        $value = $this->class->get(HostValue::Host);

        $this->assertSame($value, $host);
        $this->assertPropertySame('host', $host);
    }

    /**
     * Test getting a parsed host.
     *
     * @covers Lunr\Corona\Parsers\Host\HostParser::get
     */
    public function testGetHost(): void
    {
        $host = 'bar.example.com';

        unset($_ENV['HOSTNAME']);

        $this->mockFunction('gethostname', fn() => $host);

        $value = $this->class->get(HostValue::Host);

        $this->assertEquals($host, $value);
        $this->assertPropertySame('host', $host);

        $this->unmockFunction('gethostname');
    }

    /**
     * Test getting a parsed host.
     *
     * @covers Lunr\Corona\Parsers\Host\HostParser::get
     */
    public function testGetHostWhenNotAvailable(): void
    {
        unset($_ENV['HOSTNAME']);

        $this->mockFunction('gethostname', fn() => FALSE);

        $value = $this->class->get(HostValue::Host);

        $this->assertNull($value);
        $this->assertPropertySame('host', NULL);

        $this->unmockFunction('gethostname');
    }

}

?>
