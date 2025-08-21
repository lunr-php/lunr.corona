<?php

/**
 * This file contains the EnvironmentParserGetTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2025 Framna Netherlands B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Corona\Parsers\Environment\Tests;

use Lunr\Corona\Parsers\Environment\EnvironmentParser;
use Lunr\Corona\Parsers\Environment\EnvironmentValue;
use Lunr\Corona\Parsers\Environment\Tests\Helpers\MockEnvironmentEnum;
use Lunr\Corona\Tests\Helpers\MockRequestValue;
use RuntimeException;

/**
 * This class contains test methods for the EnvironmentParser class.
 *
 * @backupGlobals enabled
 * @covers        Lunr\Corona\Parsers\Environment\EnvironmentParser
 */
class EnvironmentParserGetTest extends EnvironmentParserTestCase
{

    /**
     * Test that getRequestValueType() returns the correct type.
     *
     * @covers Lunr\Corona\Parsers\Environment\EnvironmentParser::getRequestValueType
     */
    public function testGetRequestValueType(): void
    {
        $this->assertEquals(EnvironmentValue::class, $this->class->getRequestValueType());
    }

    /**
     * Test getting an unsupported value.
     *
     * @covers Lunr\Corona\Parsers\Environment\EnvironmentParser::get
     */
    public function testGetUnsupportedValue(): void
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Unsupported request value type "Lunr\Corona\Tests\Helpers\MockRequestValue"');

        $this->class->get(MockRequestValue::Foo);
    }

    /**
     * Test getting a parsed environment.
     *
     * @covers Lunr\Corona\Parsers\Environment\EnvironmentParser::get
     */
    public function testGetParsedEnvironment(): void
    {
        $environment = MockEnvironmentEnum::Production;

        $this->setReflectionPropertyValue('environment', $environment);
        $this->setReflectionPropertyValue('environmentInitialized', TRUE);

        $value = $this->class->get(EnvironmentValue::Environment);

        $this->assertEquals($environment->value, $value);
    }

    /**
     * Test getting a environment when it's missing in the environment.
     *
     * @covers Lunr\Corona\Parsers\Environment\EnvironmentParser::get
     */
    public function testGetEnvironmentWithMissingEnvironmentVariable(): void
    {
        unset($_ENV['ENVIRONMENT']);

        $environment = MockEnvironmentEnum::Production;

        $value = $this->class->get(EnvironmentValue::Environment);

        $this->assertEquals($environment->value, $value);
        $this->assertPropertySame('environment', $environment);
    }

    /**
     * Test getting a parsed environment.
     *
     * @covers Lunr\Corona\Parsers\Environment\EnvironmentParser::get
     */
    public function testGetEnvironment(): void
    {
        $environment = MockEnvironmentEnum::Test;

        $_ENV['ENVIRONMENT'] = 'test';

        $value = $this->class->get(EnvironmentValue::Environment);

        $this->assertEquals($environment->value, $value);
        $this->assertPropertySame('environment', $environment);
    }

    /**
     * Test getting a parsed environment.
     *
     * @covers Lunr\Corona\Parsers\Environment\EnvironmentParser::get
     */
    public function testGetEnvironmentFromCustomEnvironmentVariable(): void
    {
        $environment = MockEnvironmentEnum::Test;

        $_ENV['THE_ENVIRONMENT'] = 'test';

        $class = new EnvironmentParser(MockEnvironmentEnum::class, 'production', 'THE_ENVIRONMENT');

        $value = $class->get(EnvironmentValue::Environment);

        $this->assertEquals($environment->value, $value);
    }

    /**
     * Test getting a parsed environment.
     *
     * @covers Lunr\Corona\Parsers\Environment\EnvironmentParser::getAsEnum
     */
    public function testGetParsedEnvironmentAsEnum(): void
    {
        $environment = MockEnvironmentEnum::Production;

        $this->setReflectionPropertyValue('environment', $environment);
        $this->setReflectionPropertyValue('environmentInitialized', TRUE);

        $value = $this->class->getAsEnum(EnvironmentValue::Environment);

        $this->assertEquals($environment, $value);
    }

    /**
     * Test getting a environment when it's missing in the header.
     *
     * @covers Lunr\Corona\Parsers\Environment\EnvironmentParser::getAsEnum
     */
    public function testGetEnvironmentWithMissingEnvironmentVariableAsEnum(): void
    {
        unset($_ENV['ENVIRONMENT']);

        $environment = MockEnvironmentEnum::Production;

        $value = $this->class->getAsEnum(EnvironmentValue::Environment);

        $this->assertEquals($environment, $value);
        $this->assertPropertySame('environment', $environment);
    }

    /**
     * Test getting a parsed environment.
     *
     * @covers Lunr\Corona\Parsers\Environment\EnvironmentParser::getAsEnum
     */
    public function testGetEnvironmentAsEnum(): void
    {
        $environment = MockEnvironmentEnum::Test;

        $_ENV['ENVIRONMENT'] = 'test';

        $value = $this->class->getAsEnum(EnvironmentValue::Environment);

        $this->assertEquals($environment, $value);
        $this->assertPropertySame('environment', $environment);
    }

    /**
     * Test getting a parsed environment.
     *
     * @covers Lunr\Corona\Parsers\Environment\EnvironmentParser::getAsEnum
     */
    public function testGetEnvironmentFromCustomEnvironmentVariableAsEnum(): void
    {
        $environment = MockEnvironmentEnum::Test;

        $_ENV['THE_ENVIRONMENT'] = 'test';

        $class = new EnvironmentParser(MockEnvironmentEnum::class, 'production', 'THE_ENVIRONMENT');

        $value = $class->getAsEnum(EnvironmentValue::Environment);

        $this->assertEquals($environment, $value);
    }

}

?>
