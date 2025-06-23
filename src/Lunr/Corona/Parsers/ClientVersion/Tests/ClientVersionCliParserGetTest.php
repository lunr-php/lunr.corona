<?php

/**
 * This file contains the ClientVersionCliParserGetTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2025 Framna Netherlands B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Corona\Parsers\ClientVersion\Tests;

use Lunr\Corona\Parsers\ClientVersion\ClientVersionCliParser;
use Lunr\Corona\Parsers\ClientVersion\ClientVersionValue;
use Lunr\Corona\Tests\Helpers\MockRequestValue;
use RuntimeException;

/**
 * This class contains test methods for the ClientVersionCliParser class.
 *
 * @covers Lunr\Corona\Parsers\ClientVersion\ClientVersionCliParser
 */
class ClientVersionCliParserGetTest extends ClientVersionCliParserTestCase
{

    /**
     * Test that getRequestValueType() returns the correct type.
     *
     * @covers Lunr\Corona\Parsers\ClientVersion\ClientVersionCliParser::getRequestValueType
     */
    public function testGetRequestValueType()
    {
        $this->assertEquals(ClientVersionValue::class, $this->class->getRequestValueType());
    }

    /**
     * Test getting an unsupported value.
     *
     * @covers Lunr\Corona\Parsers\ClientVersion\ClientVersionCliParser::get
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
     * @covers Lunr\Corona\Parsers\ClientVersion\ClientVersionCliParser::get
     */
    public function testGetParsedClientVersion()
    {
        $token = '123456789';

        $this->setReflectionPropertyValue('clientVersion', $token);
        $this->setReflectionPropertyValue('clientVersionInitialized', TRUE);

        $value = $this->class->get(ClientVersionValue::ClientVersion);

        $this->assertEquals($token, $value);
    }

    /**
     * Test getting a parsed client version.
     *
     * @covers Lunr\Corona\Parsers\ClientVersion\ClientVersionCliParser::get
     */
    public function testGetParsedNullClientVersion()
    {
        $this->setReflectionPropertyValue('clientVersion', NULL);
        $this->setReflectionPropertyValue('clientVersionInitialized', TRUE);

        $value = $this->class->get(ClientVersionValue::ClientVersion);

        $this->assertNull($value);
    }

    /**
     * Test getting a client version when it's not in the authorization header.
     *
     * @covers Lunr\Corona\Parsers\ClientVersion\ClientVersionCliParser::get
     */
    public function testGetClientVersionWithMissingCliArgument()
    {
        $class = new ClientVersionCliParser([]);

        $value = $class->get(ClientVersionValue::ClientVersion);

        $this->assertNull($value);

        $property = $this->getReflectionProperty('clientVersion');

        $this->assertNull($property->getValue($class));
    }

    /**
     * Test getting a parsed client version.
     *
     * @covers Lunr\Corona\Parsers\ClientVersion\ClientVersionCliParser::get
     */
    public function testGetClientVersion()
    {
        $version = 'Client 1.2.3/beta 1';

        $value = $this->class->get(ClientVersionValue::ClientVersion);

        $this->assertEquals($version, $value);
        $this->assertPropertySame('clientVersion', $version);
    }

}

?>
