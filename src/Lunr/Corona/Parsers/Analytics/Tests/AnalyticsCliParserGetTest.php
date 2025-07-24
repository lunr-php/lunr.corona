<?php

/**
 * This file contains the AnalyticsCliParserGetTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2025 Framna Netherlands B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Corona\Parsers\Analytics\Tests;

use Lunr\Corona\Parsers\Analytics\AnalyticsCliParser;
use Lunr\Corona\Parsers\Analytics\AnalyticsValue;
use Lunr\Corona\Tests\Helpers\MockRequestValue;
use RuntimeException;

/**
 * This class contains test methods for the AnalyticsCliParser class.
 *
 * @covers Lunr\Corona\Parsers\Analytics\AnalyticsCliParser
 */
class AnalyticsCliParserGetTest extends AnalyticsCliParserTestCase
{

    /**
     * Test that getRequestValueType() returns the correct type.
     *
     * @covers Lunr\Corona\Parsers\Analytics\AnalyticsCliParser::getRequestValueType
     */
    public function testGetRequestValueType(): void
    {
        $this->assertEquals(AnalyticsValue::class, $this->class->getRequestValueType());
    }

    /**
     * Test getting an unsupported value.
     *
     * @covers Lunr\Corona\Parsers\Analytics\AnalyticsCliParser::get
     */
    public function testGetUnsupportedValue(): void
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Unsupported request value type "Lunr\Corona\Tests\Helpers\MockRequestValue"');

        $this->class->get(MockRequestValue::Foo);
    }

    /**
     * Test getting a parsed value.
     *
     * @covers Lunr\Corona\Parsers\Analytics\AnalyticsCliParser::get
     */
    public function testGetParsedAnalytics(): void
    {
        $enabled = TRUE;

        $this->setReflectionPropertyValue('analytics', $enabled);

        $value = $this->class->get(AnalyticsValue::AnalyticsEnabled);

        $this->assertEquals($enabled, $value);
    }

    /**
     * Test getting a value when it's not passed on the CLI.
     *
     * @covers Lunr\Corona\Parsers\Analytics\AnalyticsCliParser::get
     */
    public function testGetAnalyticsWithMissingCliArgumentUsesDefault(): void
    {
        $value = $this->class->get(AnalyticsValue::AnalyticsEnabled);

        $this->assertFalse($value);
        $this->assertPropertySame('analytics', FALSE);
    }

    /**
     * Test getting a value.
     *
     * @param string $arg Argument indicating enabled analytics
     *
     * @dataProvider enabledAnalyticsValueProvider
     * @covers       Lunr\Corona\Parsers\Analytics\AnalyticsCliParser::get
     */
    public function testGetAnalyticsWhenEnabled(string $arg): void
    {
        $ast = [
            'analytics' => [
                $arg,
            ],
        ];

        $class = new AnalyticsCliParser($ast);

        $value = $class->get(AnalyticsValue::AnalyticsEnabled);

        $this->assertTrue($value);

        $property = $this->getReflectionProperty('analytics');

        $this->assertTrue($property->getValue($class));
    }

    /**
     * Test getting a value.
     *
     * @param string $arg Argument indicating disabled analytics
     *
     * @dataProvider disabledAnalyticsValueProvider
     * @covers       Lunr\Corona\Parsers\Analytics\AnalyticsCliParser::get
     */
    public function testGetAnalyticsWhenDisabled(string $arg): void
    {
        $ast = [
            'analytics' => [
                $arg,
            ],
        ];

        $class = new AnalyticsCliParser($ast);

        $value = $class->get(AnalyticsValue::AnalyticsEnabled);

        $this->assertFalse($value);

        $property = $this->getReflectionProperty('analytics');

        $this->assertFalse($property->getValue($class));
    }

}

?>
