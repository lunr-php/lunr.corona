<?php

/**
 * This file contains the UrlParserGetBaseUrlTest class.
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
class UrlParserGetBaseUrlTest extends UrlParserTestCase
{

    /**
     * Test getting a parsed baseUrl.
     *
     * @covers Lunr\Corona\Parsers\Url\UrlParser::get
     */
    public function testGetParsedBaseUrl(): void
    {
        $baseUrl = 'https://www.example.com/app/';

        $this->setReflectionPropertyValue('baseUrl', $baseUrl);
        $this->setReflectionPropertyValue('baseUrlInitialized', TRUE);

        $value = $this->class->get(UrlValue::BaseUrl);

        $this->assertEquals($baseUrl, $value);
    }

    /**
     * Test getting a parsed baseUrl.
     *
     * @covers Lunr\Corona\Parsers\Url\UrlParser::get
     */
    public function testGetParsedNullBaseUrl(): void
    {
        $this->setReflectionPropertyValue('baseUrl', NULL);
        $this->setReflectionPropertyValue('baseUrlInitialized', TRUE);

        $value = $this->class->get(UrlValue::BaseUrl);

        $this->assertNull($value);
    }

    /**
     * Test getting a parsed baseUrl.
     *
     * @covers Lunr\Corona\Parsers\Url\UrlParser::get
     */
    public function testGetBaseUrl(): void
    {
        $baseUrl = 'https://www.example.com:8088/app/';

        $this->setReflectionPropertyValue('protocol', 'https');
        $this->setReflectionPropertyValue('protocolInitialized', TRUE);
        $this->setReflectionPropertyValue('domain', 'www.example.com');
        $this->setReflectionPropertyValue('domainInitialized', TRUE);
        $this->setReflectionPropertyValue('port', '8088');
        $this->setReflectionPropertyValue('portInitialized', TRUE);
        $this->setReflectionPropertyValue('basePath', '/app/');
        $this->setReflectionPropertyValue('basePathInitialized', TRUE);

        $value = $this->class->get(UrlValue::BaseUrl);

        $this->assertEquals($baseUrl, $value);
        $this->assertPropertySame('baseUrl', $baseUrl);
        $this->assertPropertySame('baseUrlInitialized', TRUE);
    }

    /**
     * Test getting a parsed baseUrl.
     *
     * @covers Lunr\Corona\Parsers\Url\UrlParser::get
     */
    public function testGetBaseUrlWithoutProtocol(): void
    {
        $baseUrl = 'www.example.com:8088/app/';

        $this->setReflectionPropertyValue('protocol', NULL);
        $this->setReflectionPropertyValue('protocolInitialized', TRUE);
        $this->setReflectionPropertyValue('domain', 'www.example.com');
        $this->setReflectionPropertyValue('domainInitialized', TRUE);
        $this->setReflectionPropertyValue('port', '8088');
        $this->setReflectionPropertyValue('portInitialized', TRUE);
        $this->setReflectionPropertyValue('basePath', '/app/');
        $this->setReflectionPropertyValue('basePathInitialized', TRUE);

        $value = $this->class->get(UrlValue::BaseUrl);

        $this->assertEquals($baseUrl, $value);
        $this->assertPropertySame('baseUrl', $baseUrl);
        $this->assertPropertySame('baseUrlInitialized', TRUE);
    }

    /**
     * Test getting a parsed baseUrl.
     *
     * @covers Lunr\Corona\Parsers\Url\UrlParser::get
     */
    public function testGetBaseUrlWithoutDomain(): void
    {
        $baseUrl = '/app/';

        $this->setReflectionPropertyValue('protocol', 'https');
        $this->setReflectionPropertyValue('protocolInitialized', TRUE);
        $this->setReflectionPropertyValue('domain', NULL);
        $this->setReflectionPropertyValue('domainInitialized', TRUE);
        $this->setReflectionPropertyValue('port', '8088');
        $this->setReflectionPropertyValue('portInitialized', TRUE);
        $this->setReflectionPropertyValue('basePath', '/app/');
        $this->setReflectionPropertyValue('basePathInitialized', TRUE);

        $value = $this->class->get(UrlValue::BaseUrl);

        $this->assertEquals($baseUrl, $value);
        $this->assertPropertySame('baseUrl', $baseUrl);
        $this->assertPropertySame('baseUrlInitialized', TRUE);
    }

    /**
     * Test getting a parsed baseUrl.
     *
     * @covers Lunr\Corona\Parsers\Url\UrlParser::get
     */
    public function testGetBaseUrlWithoutPort(): void
    {
        $baseUrl = 'https://www.example.com/app/';

        $this->setReflectionPropertyValue('protocol', 'https');
        $this->setReflectionPropertyValue('protocolInitialized', TRUE);
        $this->setReflectionPropertyValue('domain', 'www.example.com');
        $this->setReflectionPropertyValue('domainInitialized', TRUE);
        $this->setReflectionPropertyValue('port', NULL);
        $this->setReflectionPropertyValue('portInitialized', TRUE);
        $this->setReflectionPropertyValue('basePath', '/app/');
        $this->setReflectionPropertyValue('basePathInitialized', TRUE);

        $value = $this->class->get(UrlValue::BaseUrl);

        $this->assertEquals($baseUrl, $value);
        $this->assertPropertySame('baseUrl', $baseUrl);
        $this->assertPropertySame('baseUrlInitialized', TRUE);
    }

    /**
     * Test getting a parsed baseUrl.
     *
     * @covers Lunr\Corona\Parsers\Url\UrlParser::get
     */
    public function testGetBaseUrlWithoutProtocolAndPort(): void
    {
        $baseUrl = 'www.example.com/app/';

        $this->setReflectionPropertyValue('protocol', NULL);
        $this->setReflectionPropertyValue('protocolInitialized', TRUE);
        $this->setReflectionPropertyValue('domain', 'www.example.com');
        $this->setReflectionPropertyValue('domainInitialized', TRUE);
        $this->setReflectionPropertyValue('port', NULL);
        $this->setReflectionPropertyValue('portInitialized', TRUE);
        $this->setReflectionPropertyValue('basePath', '/app/');
        $this->setReflectionPropertyValue('basePathInitialized', TRUE);

        $value = $this->class->get(UrlValue::BaseUrl);

        $this->assertEquals($baseUrl, $value);
        $this->assertPropertySame('baseUrl', $baseUrl);
        $this->assertPropertySame('baseUrlInitialized', TRUE);
    }

    /**
     * Test getting a parsed baseUrl.
     *
     * @covers Lunr\Corona\Parsers\Url\UrlParser::get
     */
    public function testGetBaseUrlWithoutBasePath(): void
    {
        $baseUrl = 'https://www.example.com:8088/';

        $this->setReflectionPropertyValue('protocol', 'https');
        $this->setReflectionPropertyValue('protocolInitialized', TRUE);
        $this->setReflectionPropertyValue('domain', 'www.example.com');
        $this->setReflectionPropertyValue('domainInitialized', TRUE);
        $this->setReflectionPropertyValue('port', '8088');
        $this->setReflectionPropertyValue('portInitialized', TRUE);
        $this->setReflectionPropertyValue('basePath', NULL);
        $this->setReflectionPropertyValue('basePathInitialized', TRUE);

        $value = $this->class->get(UrlValue::BaseUrl);

        $this->assertEquals($baseUrl, $value);
        $this->assertPropertySame('baseUrl', $baseUrl);
        $this->assertPropertySame('baseUrlInitialized', TRUE);
    }

    /**
     * Test getting a parsed baseUrl.
     *
     * @covers Lunr\Corona\Parsers\Url\UrlParser::get
     */
    public function testGetHttpBaseUrlWithDefaultPort(): void
    {
        $baseUrl = 'http://www.example.com/app/';

        $this->setReflectionPropertyValue('protocol', 'http');
        $this->setReflectionPropertyValue('protocolInitialized', TRUE);
        $this->setReflectionPropertyValue('domain', 'www.example.com');
        $this->setReflectionPropertyValue('domainInitialized', TRUE);
        $this->setReflectionPropertyValue('port', '80');
        $this->setReflectionPropertyValue('portInitialized', TRUE);
        $this->setReflectionPropertyValue('basePath', '/app/');
        $this->setReflectionPropertyValue('basePathInitialized', TRUE);

        $value = $this->class->get(UrlValue::BaseUrl);

        $this->assertEquals($baseUrl, $value);
        $this->assertPropertySame('baseUrl', $baseUrl);
        $this->assertPropertySame('baseUrlInitialized', TRUE);
    }

    /**
     * Test getting a parsed baseUrl.
     *
     * @covers Lunr\Corona\Parsers\Url\UrlParser::get
     */
    public function testGetHttpBaseUrlWithNonDefaultPort(): void
    {
        $baseUrl = 'http://www.example.com:8088/app/';

        $this->setReflectionPropertyValue('protocol', 'http');
        $this->setReflectionPropertyValue('protocolInitialized', TRUE);
        $this->setReflectionPropertyValue('domain', 'www.example.com');
        $this->setReflectionPropertyValue('domainInitialized', TRUE);
        $this->setReflectionPropertyValue('port', '8088');
        $this->setReflectionPropertyValue('portInitialized', TRUE);
        $this->setReflectionPropertyValue('basePath', '/app/');
        $this->setReflectionPropertyValue('basePathInitialized', TRUE);

        $value = $this->class->get(UrlValue::BaseUrl);

        $this->assertEquals($baseUrl, $value);
        $this->assertPropertySame('baseUrl', $baseUrl);
        $this->assertPropertySame('baseUrlInitialized', TRUE);
    }

    /**
     * Test getting a parsed baseUrl.
     *
     * @covers Lunr\Corona\Parsers\Url\UrlParser::get
     */
    public function testGetHttpsBaseUrlWithDefaultPort(): void
    {
        $baseUrl = 'https://www.example.com/app/';

        $this->setReflectionPropertyValue('protocol', 'https');
        $this->setReflectionPropertyValue('protocolInitialized', TRUE);
        $this->setReflectionPropertyValue('domain', 'www.example.com');
        $this->setReflectionPropertyValue('domainInitialized', TRUE);
        $this->setReflectionPropertyValue('port', '443');
        $this->setReflectionPropertyValue('portInitialized', TRUE);
        $this->setReflectionPropertyValue('basePath', '/app/');
        $this->setReflectionPropertyValue('basePathInitialized', TRUE);

        $value = $this->class->get(UrlValue::BaseUrl);

        $this->assertEquals($baseUrl, $value);
        $this->assertPropertySame('baseUrl', $baseUrl);
        $this->assertPropertySame('baseUrlInitialized', TRUE);
    }

    /**
     * Test getting a parsed baseUrl.
     *
     * @covers Lunr\Corona\Parsers\Url\UrlParser::get
     */
    public function testGetHttpsBaseUrlWithNonDefaultPort(): void
    {
        $baseUrl = 'https://www.example.com:8088/app/';

        $this->setReflectionPropertyValue('protocol', 'https');
        $this->setReflectionPropertyValue('protocolInitialized', TRUE);
        $this->setReflectionPropertyValue('domain', 'www.example.com');
        $this->setReflectionPropertyValue('domainInitialized', TRUE);
        $this->setReflectionPropertyValue('port', '8088');
        $this->setReflectionPropertyValue('portInitialized', TRUE);
        $this->setReflectionPropertyValue('basePath', '/app/');
        $this->setReflectionPropertyValue('basePathInitialized', TRUE);

        $value = $this->class->get(UrlValue::BaseUrl);

        $this->assertEquals($baseUrl, $value);
        $this->assertPropertySame('baseUrl', $baseUrl);
        $this->assertPropertySame('baseUrlInitialized', TRUE);
    }

}

?>
