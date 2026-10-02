<?php

/**
 * This file contains the ContainerTypeParserGetTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2025 Framna Netherlands B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Corona\Parsers\ContainerType\Tests;

use Lunr\Corona\Parsers\ContainerType\ContainerTypeParser;
use Lunr\Corona\Parsers\ContainerType\ContainerTypeValue;
use Lunr\Corona\Tests\Helpers\MockRequestValue;
use RuntimeException;

/**
 * This class contains test methods for the ContainerTypeParser class.
 *
 * @backupGlobals enabled
 * @covers        Lunr\Corona\Parsers\ContainerType\ContainerTypeParser
 */
class ContainerTypeParserGetTest extends ContainerTypeParserTestCase
{

    /**
     * Test that getRequestValueType() returns the correct type.
     *
     * @covers Lunr\Corona\Parsers\ContainerType\ContainerTypeParser::getRequestValueType
     */
    public function testGetRequestValueType(): void
    {
        $this->assertEquals(ContainerTypeValue::class, $this->class->getRequestValueType());
    }

    /**
     * Test getting an unsupported value.
     *
     * @covers Lunr\Corona\Parsers\ContainerType\ContainerTypeParser::get
     */
    public function testGetUnsupportedValue(): void
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Unsupported request value type "Lunr\Corona\Tests\Helpers\MockRequestValue"');

        $this->class->get(MockRequestValue::Foo);
    }

    /**
     * Test getting an already parsed container type.
     *
     * @covers Lunr\Corona\Parsers\ContainerType\ContainerTypeParser::get
     */
    public function testGetParsedContainerType(): void
    {
        $containerType = 'api';

        $this->setReflectionPropertyValue('containerType', $containerType);
        $this->setReflectionPropertyValue('containerTypeInitialized', TRUE);

        $value = $this->class->get(ContainerTypeValue::ContainerType);

        $this->assertEquals($containerType, $value);
    }

    /**
     * Test getting the container type from the environment.
     *
     * @covers Lunr\Corona\Parsers\ContainerType\ContainerTypeParser::get
     * @covers Lunr\Corona\Parsers\ContainerType\ContainerTypeParser::parse
     */
    public function testGetContainerTypeFromEnvironment(): void
    {
        $containerType = 'cron';

        $_ENV['CONTAINER_TYPE'] = $containerType;

        $value = $this->class->get(ContainerTypeValue::ContainerType);

        $this->assertSame($containerType, $value);
        $this->assertPropertySame('containerType', $containerType);
    }

    /**
     * Test getting the default container type when the environment variable is unset.
     *
     * @covers Lunr\Corona\Parsers\ContainerType\ContainerTypeParser::get
     * @covers Lunr\Corona\Parsers\ContainerType\ContainerTypeParser::parse
     */
    public function testGetContainerTypeWhenEnvironmentVariableUnset(): void
    {
        unset($_ENV['CONTAINER_TYPE']);

        $value = $this->class->get(ContainerTypeValue::ContainerType);

        $this->assertSame('unknown', $value);
        $this->assertPropertySame('containerType', 'unknown');
    }

    /**
     * Test getting the default container type when the environment variable is empty.
     *
     * @covers Lunr\Corona\Parsers\ContainerType\ContainerTypeParser::get
     * @covers Lunr\Corona\Parsers\ContainerType\ContainerTypeParser::parse
     */
    public function testGetContainerTypeWhenEnvironmentVariableEmpty(): void
    {
        $_ENV['CONTAINER_TYPE'] = '';

        $value = $this->class->get(ContainerTypeValue::ContainerType);

        $this->assertSame('unknown', $value);
        $this->assertPropertySame('containerType', 'unknown');
    }

    /**
     * Test getting a custom default container type when the environment variable is unset.
     *
     * @covers Lunr\Corona\Parsers\ContainerType\ContainerTypeParser::get
     * @covers Lunr\Corona\Parsers\ContainerType\ContainerTypeParser::parse
     */
    public function testGetCustomDefaultContainerType(): void
    {
        unset($_ENV['CONTAINER_TYPE']);

        $class = new ContainerTypeParser('fallback');

        parent::baseSetUp($class);

        $value = $class->get(ContainerTypeValue::ContainerType);

        $this->assertSame('fallback', $value);
        $this->assertPropertySame('containerType', 'fallback');
    }

    /**
     * Test getting the container type from a custom environment variable.
     *
     * @covers Lunr\Corona\Parsers\ContainerType\ContainerTypeParser::get
     * @covers Lunr\Corona\Parsers\ContainerType\ContainerTypeParser::parse
     */
    public function testGetContainerTypeFromCustomEnvironmentVariable(): void
    {
        $containerType = 'contentful-import-worker';

        unset($_ENV['CONTAINER_TYPE']);
        $_ENV['MY_CONTAINER_TYPE'] = $containerType;

        $class = new ContainerTypeParser('unknown', 'MY_CONTAINER_TYPE');

        parent::baseSetUp($class);

        $value = $class->get(ContainerTypeValue::ContainerType);

        $this->assertSame($containerType, $value);
        $this->assertPropertySame('containerType', $containerType);
    }

    /**
     * Test that the parsed container type is cached.
     *
     * @covers Lunr\Corona\Parsers\ContainerType\ContainerTypeParser::get
     * @covers Lunr\Corona\Parsers\ContainerType\ContainerTypeParser::parse
     */
    public function testGetContainerTypeIsCached(): void
    {
        $containerType = 'api';

        $_ENV['CONTAINER_TYPE'] = $containerType;

        $first = $this->class->get(ContainerTypeValue::ContainerType);

        $_ENV['CONTAINER_TYPE'] = 'cron';

        $second = $this->class->get(ContainerTypeValue::ContainerType);

        $this->assertSame($containerType, $first);
        $this->assertSame($containerType, $second);
    }

}

?>
