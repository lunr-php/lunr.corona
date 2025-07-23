<?php

/**
 * This file contains the UrlParserGetBasePathTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2025 Framna Netherlands B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Corona\Parsers\Url\Tests;

use Lunr\Corona\Parsers\Url\UrlParser;
use Lunr\Corona\Parsers\Url\UrlValue;

/**
 * This class contains test methods for the UrlParser class.
 *
 * @backupGlobals enabled
 * @covers        Lunr\Corona\Parsers\Url\UrlParser
 */
class UrlParserGetBasePathTest extends UrlParserTestCase
{

    /**
     * Test getting a parsed basePath.
     *
     * @covers Lunr\Corona\Parsers\Url\UrlParser::get
     */
    public function testGetParsedBasePath(): void
    {
        $basePath = '/app/';

        $this->setReflectionPropertyValue('basePath', $basePath);
        $this->setReflectionPropertyValue('basePathInitialized', TRUE);

        $value = $this->class->get(UrlValue::BasePath);

        $this->assertEquals($basePath, $value);
    }

    /**
     * Test getting a parsed basePath.
     *
     * @covers Lunr\Corona\Parsers\Url\UrlParser::get
     */
    public function testGetParsedNullBasePath(): void
    {
        $this->setReflectionPropertyValue('basePath', NULL);
        $this->setReflectionPropertyValue('basePathInitialized', TRUE);

        $value = $this->class->get(UrlValue::BasePath);

        $this->assertNull($value);
    }

    /**
     * Test getting a parsed basePath.
     *
     * @covers Lunr\Corona\Parsers\Url\UrlParser::get
     */
    public function testGetBasePathWithDefaultEntryPoint(): void
    {
        $basePath = '/app/';

        $_SERVER['SCRIPT_NAME'] = '/app/index.php';

        $value = $this->class->get(UrlValue::BasePath);

        $this->assertEquals($basePath, $value);
        $this->assertPropertySame('basePath', $basePath);
        $this->assertPropertySame('basePathInitialized', TRUE);
    }

    /**
     * Test getting a parsed basePath.
     *
     * @covers Lunr\Corona\Parsers\Url\UrlParser::get
     */
    public function testGetBasePathWithCustomEntryPoint(): void
    {
        $basePath = '/app/';

        $_SERVER['SCRIPT_NAME'] = '/app/main.php';

        $class = new UrlParser('main.php');

        $value = $class->get(UrlValue::BasePath);

        $this->assertEquals($basePath, $value);
        $this->assertSame($this->reflection->getProperty('basePath')->getValue($class), $basePath);
        $this->assertSame($this->reflection->getProperty('basePathInitialized')->getValue($class), TRUE);
    }

    /**
     * Test getting a parsed basePath.
     *
     * @covers Lunr\Corona\Parsers\Url\UrlParser::get
     */
    public function testGetBasePathWhenInfoMissing(): void
    {
        unset($_SERVER['SCRIPT_NAME']);

        $value = $this->class->get(UrlValue::BasePath);

        $this->assertNull($value);
        $this->assertPropertySame('basePath', NULL);
        $this->assertPropertySame('basePathInitialized', TRUE);
    }

}

?>
