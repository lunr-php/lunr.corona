<?php

/**
 * This file contains the UrlParserGetDomainTest class.
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
class UrlParserGetDomainTest extends UrlParserTestCase
{

    /**
     * Test getting a parsed domain.
     *
     * @covers Lunr\Corona\Parsers\Url\UrlParser::get
     */
    public function testGetParsedDomain(): void
    {
        $domain = 'www.example.com';

        $this->setReflectionPropertyValue('domain', $domain);
        $this->setReflectionPropertyValue('domainInitialized', TRUE);

        $value = $this->class->get(UrlValue::Domain);

        $this->assertEquals($domain, $value);
    }

    /**
     * Test getting a parsed domain.
     *
     * @covers Lunr\Corona\Parsers\Url\UrlParser::get
     */
    public function testGetParsedNullDomain(): void
    {
        $this->setReflectionPropertyValue('domain', NULL);
        $this->setReflectionPropertyValue('domainInitialized', TRUE);

        $value = $this->class->get(UrlValue::Domain);

        $this->assertNull($value);
    }

    /**
     * Test getting a parsed domain.
     *
     * @covers Lunr\Corona\Parsers\Url\UrlParser::get
     */
    public function testGetDomainFromHttpHost(): void
    {
        $domain = 'www.example.com';

        $_SERVER['HTTP_HOST']   = $domain;
        $_SERVER['SERVER_NAME'] = 'www.foo.org';

        $value = $this->class->get(UrlValue::Domain);

        $this->assertEquals($domain, $value);
        $this->assertPropertySame('domain', $domain);
        $this->assertPropertySame('domainInitialized', TRUE);
    }

    /**
     * Test getting a parsed domain.
     *
     * @covers Lunr\Corona\Parsers\Url\UrlParser::get
     */
    public function testGetDomainFromServerName(): void
    {
        $domain = 'www.example.com';

        $_SERVER['SERVER_NAME'] = $domain;

        $value = $this->class->get(UrlValue::Domain);

        $this->assertEquals($domain, $value);
        $this->assertPropertySame('domain', $domain);
        $this->assertPropertySame('domainInitialized', TRUE);
    }

    /**
     * Test getting a parsed domain.
     *
     * @covers Lunr\Corona\Parsers\Url\UrlParser::get
     */
    public function testGetDomainWhenInfoMissing(): void
    {
        $value = $this->class->get(UrlValue::Domain);

        $this->assertNull($value);
        $this->assertPropertySame('domain', NULL);
        $this->assertPropertySame('domainInitialized', TRUE);
    }

}

?>
