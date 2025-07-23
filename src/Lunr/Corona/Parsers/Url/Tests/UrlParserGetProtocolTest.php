<?php

/**
 * This file contains the UrlParserGetProtocolTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2025 Framna Netherlands B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Corona\Parsers\Url\Tests;

use Lunr\Corona\Parsers\Url\UrlValue;

/**
 * This class contains test methods for the UrlParser class.
 *
 * @backupGlobals enabled
 * @covers        Lunr\Corona\Parsers\Url\UrlParser
 */
class UrlParserGetProtocolTest extends UrlParserTestCase
{

    /**
     * Test getting a parsed protocol.
     *
     * @covers Lunr\Corona\Parsers\Url\UrlParser::get
     */
    public function testGetParsedProtocol(): void
    {
        $protocol = '443';

        $this->setReflectionPropertyValue('protocol', $protocol);
        $this->setReflectionPropertyValue('protocolInitialized', TRUE);

        $value = $this->class->get(UrlValue::Protocol);

        $this->assertEquals($protocol, $value);
    }

    /**
     * Test getting a parsed protocol.
     *
     * @covers Lunr\Corona\Parsers\Url\UrlParser::get
     */
    public function testGetParsedNullProtocol(): void
    {
        $this->setReflectionPropertyValue('protocol', NULL);
        $this->setReflectionPropertyValue('protocolInitialized', TRUE);

        $value = $this->class->get(UrlValue::Protocol);

        $this->assertNull($value);
    }

    /**
     * Test getting a parsed protocol.
     *
     * @covers Lunr\Corona\Parsers\Url\UrlParser::get
     */
    public function testGetProtocolHttp(): void
    {
        $protocol = 'http';

        $value = $this->class->get(UrlValue::Protocol);

        $this->assertEquals($protocol, $value);
        $this->assertPropertySame('protocol', $protocol);
        $this->assertPropertySame('protocolInitialized', TRUE);
    }

    /**
     * Test getting a parsed protocol.
     *
     * @covers Lunr\Corona\Parsers\Url\UrlParser::get
     */
    public function testGetProtocolHttpWhenHttpsOff(): void
    {
        $protocol = 'http';

        $_SERVER['HTTPS'] = 'off';

        $value = $this->class->get(UrlValue::Protocol);

        $this->assertEquals($protocol, $value);
        $this->assertPropertySame('protocol', $protocol);
        $this->assertPropertySame('protocolInitialized', TRUE);
    }

    /**
     * Test getting a parsed protocol.
     *
     * @covers Lunr\Corona\Parsers\Url\UrlParser::get
     */
    public function testGetProtocolHttps(): void
    {
        $protocol = 'https';

        $_SERVER['HTTPS'] = 'on';

        $value = $this->class->get(UrlValue::Protocol);

        $this->assertEquals($protocol, $value);
        $this->assertPropertySame('protocol', $protocol);
        $this->assertPropertySame('protocolInitialized', TRUE);
    }

    /**
     * Test getting a parsed protocol.
     *
     * @covers Lunr\Corona\Parsers\Url\UrlParser::get
     */
    public function testGetForwardedProtocol(): void
    {
        $protocol = 'https';

        $_SERVER['HTTP_X_FORWARDED_PROTO'] = $protocol;

        $value = $this->class->get(UrlValue::Protocol);

        $this->assertEquals($protocol, $value);
        $this->assertPropertySame('protocol', $protocol);
        $this->assertPropertySame('protocolInitialized', TRUE);
    }

}

?>
