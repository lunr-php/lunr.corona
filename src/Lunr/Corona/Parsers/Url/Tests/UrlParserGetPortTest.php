<?php

/**
 * This file contains the UrlParserGetPortTest class.
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
class UrlParserGetPortTest extends UrlParserTestCase
{

    /**
     * Test getting a parsed port.
     *
     * @covers Lunr\Corona\Parsers\Url\UrlParser::get
     */
    public function testGetParsedPort(): void
    {
        $port = '443';

        $this->setReflectionPropertyValue('port', $port);
        $this->setReflectionPropertyValue('portInitialized', TRUE);

        $value = $this->class->get(UrlValue::Port);

        $this->assertEquals($port, $value);
    }

    /**
     * Test getting a parsed port.
     *
     * @covers Lunr\Corona\Parsers\Url\UrlParser::get
     */
    public function testGetParsedNullPort(): void
    {
        $this->setReflectionPropertyValue('port', NULL);
        $this->setReflectionPropertyValue('portInitialized', TRUE);

        $value = $this->class->get(UrlValue::Port);

        $this->assertNull($value);
    }

    /**
     * Test getting a port when it's missing in $_SERVER.
     *
     * @covers Lunr\Corona\Parsers\Url\UrlParser::get
     */
    public function testGetUrlWithMissingServerKey(): void
    {
        $value = $this->class->get(UrlValue::Port);

        $this->assertNull($value);
    }

    /**
     * Test getting a parsed port.
     *
     * @covers Lunr\Corona\Parsers\Url\UrlParser::get
     */
    public function testGetPort(): void
    {
        $port = '443';

        $_SERVER['SERVER_PORT'] = $port;

        $value = $this->class->get(UrlValue::Port);

        $this->assertEquals($port, $value);
        $this->assertPropertySame('port', $port);
        $this->assertPropertySame('portInitialized', TRUE);
    }

}

?>
