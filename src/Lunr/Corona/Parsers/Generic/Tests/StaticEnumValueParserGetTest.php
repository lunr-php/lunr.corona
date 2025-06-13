<?php

/**
 * This file contains the StaticEnumValueParserGetTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2025 Framna Netherlands B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Corona\Parsers\Generic\Tests;

use Lunr\Corona\Parsers\Client\ClientValue;
use Lunr\Corona\Parsers\Client\Tests\Helpers\MockClientEnum;
use Lunr\Corona\Parsers\Generic\StaticEnumValueParser;
use Lunr\Corona\Tests\Helpers\MockRequestValue;
use RuntimeException;

/**
 * This class contains test methods for the StaticEnumValueParser class.
 *
 * @covers Lunr\Corona\Parsers\Generic\StaticEnumValueParser
 */
class StaticEnumValueParserGetTest extends StaticEnumValueParserTestCase
{

    /**
     * Test that getRequestValueType() returns the correct type.
     *
     * @covers Lunr\Corona\Parsers\Generic\StaticEnumValueParser::getRequestValueType
     */
    public function testGetRequestValueType()
    {
        $this->assertEquals(ClientValue::class, $this->class->getRequestValueType());
    }

    /**
     * Test getting an unsupported value.
     *
     * @covers Lunr\Corona\Parsers\Generic\StaticEnumValueParser::get
     */
    public function testGetUnsupportedValue()
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Unsupported request value type "Lunr\Corona\Tests\Helpers\MockRequestValue"');

        $this->class->get(MockRequestValue::Foo);
    }

    /**
     * Test getting a parsed client.
     *
     * @covers Lunr\Corona\Parsers\Generic\StaticEnumValueParser::get
     */
    public function testGetParsedClient()
    {
        $client = MockClientEnum::CommandLine;

        $value = $this->class->get(ClientValue::Client);

        $this->assertEquals($client->value, $value);
    }

    /**
     * Test getting a parsed client.
     *
     * @covers Lunr\Corona\Parsers\Generic\StaticEnumValueParser::get
     */
    public function testGetParsedNullClient()
    {
        $nullValue = new StaticEnumValueParser(ClientValue::Client, NULL);

        $value = $nullValue->get(ClientValue::Client);

        $this->assertNull($value);
    }

    /**
     * Test getting a parsed client.
     *
     * @covers Lunr\Corona\Parsers\Generic\StaticEnumValueParser::getAsEnum
     */
    public function testGetParsedClientAsEnum()
    {
        $client = MockClientEnum::CommandLine;

        $value = $this->class->getAsEnum(ClientValue::Client);

        $this->assertEquals($client, $value);
    }

    /**
     * Test getting a parsed client.
     *
     * @covers Lunr\Corona\Parsers\Generic\StaticEnumValueParser::getAsEnum
     */
    public function testGetParsedNullClientAsEnum()
    {
        $nullValue = new StaticEnumValueParser(ClientValue::Client, NULL);

        $value = $nullValue->getAsEnum(ClientValue::Client);

        $this->assertNull($value);
    }

}

?>
