<?php

/**
 * This file contains the StaticBooleanValueParserGetTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2025 Framna Netherlands B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Corona\Parsers\Generic\Tests;

use Lunr\Corona\Parsers\Analytics\AnalyticsValue;
use Lunr\Corona\Parsers\Generic\StaticBooleanValueParser;
use Lunr\Corona\Tests\Helpers\MockRequestValue;
use RuntimeException;

/**
 * This class contains test methods for the StaticBooleanValueParser class.
 *
 * @covers Lunr\Corona\Parsers\Generic\StaticBooleanValueParser
 */
class StaticBooleanValueParserGetTest extends StaticBooleanValueParserTestCase
{

    /**
     * Test that getRequestValueType() returns the correct type.
     *
     * @covers Lunr\Corona\Parsers\Generic\StaticBooleanValueParser::getRequestValueType
     */
    public function testGetRequestValueType(): void
    {
        $this->assertEquals(AnalyticsValue::class, $this->class->getRequestValueType());
    }

    /**
     * Test getting an unsupported value.
     *
     * @covers Lunr\Corona\Parsers\Generic\StaticBooleanValueParser::get
     */
    public function testGetUnsupportedValue(): void
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Unsupported request value type "Lunr\Corona\Tests\Helpers\MockRequestValue"');

        $this->class->get(MockRequestValue::Foo);
    }

    /**
     * Test getting a parsed boolean value.
     *
     * @covers Lunr\Corona\Parsers\Generic\StaticBooleanValueParser::get
     */
    public function testGetParsedValue(): void
    {
        $this->assertTrue($this->class->get(AnalyticsValue::AnalyticsEnabled));
    }

    /**
     * Test getting a parsed boolean value.
     *
     * @covers Lunr\Corona\Parsers\Generic\StaticBooleanValueParser::get
     */
    public function testGetParsedFalseValue(): void
    {
        $this->assertFalse((new StaticBooleanValueParser(AnalyticsValue::AnalyticsEnabled, FALSE))->get(AnalyticsValue::AnalyticsEnabled));
    }

}

?>
