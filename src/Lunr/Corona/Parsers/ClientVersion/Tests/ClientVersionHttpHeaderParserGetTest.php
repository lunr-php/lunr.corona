<?php

/**
 * This file contains the ClientVersionHttpHeaderParserGetTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2025 Framna Netherlands B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Corona\Parsers\ClientVersion\Tests;

use Lunr\Corona\Parsers\ClientVersion\ClientVersionHttpHeaderParser;
use Lunr\Corona\Parsers\ClientVersion\ClientVersionValue;
use Lunr\Corona\Tests\Helpers\MockRequestValue;
use RuntimeException;

/**
 * This class contains test methods for the ClientVersionHttpHeaderParser class.
 *
 * @backupGlobals enabled
 * @covers        Lunr\Corona\Parsers\ClientVersion\ClientVersionHttpHeaderParser
 */
class ClientVersionHttpHeaderParserGetTest extends ClientVersionHttpHeaderParserTestCase
{

    /**
     * Test that getRequestValueType() returns the correct type.
     *
     * @covers Lunr\Corona\Parsers\ClientVersion\ClientVersionHttpHeaderParser::getRequestValueType
     */
    public function testGetRequestValueType()
    {
        $this->assertEquals(ClientVersionValue::class, $this->class->getRequestValueType());
    }

    /**
     * Test getting an unsupported value.
     *
     * @covers Lunr\Corona\Parsers\ClientVersion\ClientVersionHttpHeaderParser::get
     */
    public function testGetUnsupportedValue()
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Unsupported request value type "Lunr\Corona\Tests\Helpers\MockRequestValue"');

        $this->class->get(MockRequestValue::Foo);
    }

    /**
     * Test getting a parsed client version.
     *
     * @covers Lunr\Corona\Parsers\ClientVersion\ClientVersionHttpHeaderParser::get
     */
    public function testGetParsedClientVersion()
    {
        $version = 'Client 1.2.3/beta 1';

        $this->setReflectionPropertyValue('clientVersion', $version);
        $this->setReflectionPropertyValue('clientVersionInitialized', TRUE);

        $value = $this->class->get(ClientVersionValue::ClientVersion);

        $this->assertEquals($version, $value);
    }

    /**
     * Test getting a parsed client version.
     *
     * @covers Lunr\Corona\Parsers\ClientVersion\ClientVersionHttpHeaderParser::get
     */
    public function testGetParsedNullClientVersion()
    {
        $this->setReflectionPropertyValue('clientVersion', NULL);
        $this->setReflectionPropertyValue('clientVersionInitialized', TRUE);

        $value = $this->class->get(ClientVersionValue::ClientVersion);

        $this->assertNull($value);
    }

    /**
     * Test getting a client version when it's missing in the header.
     *
     * @covers Lunr\Corona\Parsers\ClientVersion\ClientVersionHttpHeaderParser::get
     */
    public function testGetClientVersionWithMissingHeader()
    {
        $value = $this->class->get(ClientVersionValue::ClientVersion);

        $this->assertNull($value);
        $this->assertPropertySame('clientVersion', NULL);
    }

    /**
     * Test getting a parsed client version.
     *
     * @covers Lunr\Corona\Parsers\ClientVersion\ClientVersionHttpHeaderParser::get
     */
    public function testGetClientVersion()
    {
        $version = 'Client 1.2.3/beta 1';

        $_SERVER['HTTP_CLIENT_VERSION'] = $version;

        $value = $this->class->get(ClientVersionValue::ClientVersion);

        $this->assertEquals($version, $value);
        $this->assertPropertySame('clientVersion', $version);
    }

    /**
     * Test getting a parsed client version.
     *
     * @covers Lunr\Corona\Parsers\ClientVersion\ClientVersionHttpHeaderParser::get
     */
    public function testGetClientVersionFromCustomHeader()
    {
        $version = 'Client 1.2.3/beta 1';

        $_SERVER['HTTP_X_CLIENT_VERSION'] = $version;

        $class = new ClientVersionHttpHeaderParser('X-Client-Version');

        $value = $class->get(ClientVersionValue::ClientVersion);

        $this->assertEquals($version, $value);
    }

}

?>
