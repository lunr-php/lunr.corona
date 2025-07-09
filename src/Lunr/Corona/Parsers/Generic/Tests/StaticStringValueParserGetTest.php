<?php

/**
 * This file contains the StaticStringValueParserGetTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2025 Framna Netherlands B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Corona\Parsers\Generic\Tests;

use Lunr\Corona\Parsers\ClientVersion\ClientVersionValue;
use Lunr\Corona\Parsers\Generic\StaticStringValueParser;
use Lunr\Corona\Tests\Helpers\MockRequestValue;
use RuntimeException;

/**
 * This class contains test methods for the StaticStringValueParser class.
 *
 * @covers Lunr\Corona\Parsers\Generic\StaticStringValueParser
 */
class StaticStringValueParserGetTest extends StaticStringValueParserTestCase
{

    /**
     * Test that getRequestValueType() returns the correct type.
     *
     * @covers Lunr\Corona\Parsers\Generic\StaticStringValueParser::getRequestValueType
     */
    public function testGetRequestValueType()
    {
        $this->assertEquals(ClientVersionValue::class, $this->class->getRequestValueType());
    }

    /**
     * Test getting an unsupported value.
     *
     * @covers Lunr\Corona\Parsers\Generic\StaticStringValueParser::get
     */
    public function testGetUnsupportedValue()
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Unsupported request value type "Lunr\Corona\Tests\Helpers\MockRequestValue"');

        $this->class->get(MockRequestValue::Foo);
    }

    /**
     * Test getting a parsed string value.
     *
     * @covers Lunr\Corona\Parsers\Generic\StaticStringValueParser::get
     */
    public function testGetParsedValue()
    {
        $string = '1.2.3';

        $value = $this->class->get(ClientVersionValue::ClientVersion);

        $this->assertEquals($string, $value);
    }

    /**
     * Test getting a parsed client.
     *
     * @covers Lunr\Corona\Parsers\Generic\StaticStringValueParser::get
     */
    public function testGetParsedNullClient()
    {
        $nullValue = new StaticStringValueParser(ClientVersionValue::ClientVersion, NULL);

        $value = $nullValue->get(ClientVersionValue::ClientVersion);

        $this->assertNull($value);
    }

}

?>
