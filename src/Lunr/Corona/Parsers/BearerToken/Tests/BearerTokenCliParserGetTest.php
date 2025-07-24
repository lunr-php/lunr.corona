<?php

/**
 * This file contains the BearerTokenCliParserGetTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2025 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Corona\Parsers\BearerToken\Tests;

use Lunr\Corona\Parsers\BearerToken\BearerTokenCliParser;
use Lunr\Corona\Parsers\BearerToken\BearerTokenValue;
use Lunr\Corona\Tests\Helpers\MockRequestValue;
use RuntimeException;

/**
 * This class contains test methods for the BearerTokenCliParser class.
 *
 * @covers Lunr\Corona\Parsers\BearerToken\BearerTokenCliParser
 */
class BearerTokenCliParserGetTest extends BearerTokenCliParserTestCase
{

    /**
     * Test that getRequestValueType() returns the correct type.
     *
     * @covers Lunr\Corona\Parsers\BearerToken\BearerTokenCliParser::getRequestValueType
     */
    public function testGetRequestValueType(): void
    {
        $this->assertEquals(BearerTokenValue::class, $this->class->getRequestValueType());
    }

    /**
     * Test getting an unsupported value.
     *
     * @covers Lunr\Corona\Parsers\BearerToken\BearerTokenCliParser::get
     */
    public function testGetUnsupportedValue(): void
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Unsupported request value type "Lunr\Corona\Tests\Helpers\MockRequestValue"');

        $this->class->get(MockRequestValue::Foo);
    }

    /**
     * Test getting a parsed bearer token.
     *
     * @covers Lunr\Corona\Parsers\BearerToken\BearerTokenCliParser::get
     */
    public function testGetParsedBearerToken(): void
    {
        $token = '123456789';

        $this->setReflectionPropertyValue('bearerToken', $token);
        $this->setReflectionPropertyValue('bearerTokenInitialized', TRUE);

        $value = $this->class->get(BearerTokenValue::BearerToken);

        $this->assertEquals($token, $value);
    }

    /**
     * Test getting a parsed bearer token.
     *
     * @covers Lunr\Corona\Parsers\BearerToken\BearerTokenCliParser::get
     */
    public function testGetParsedNullBearerToken(): void
    {
        $this->setReflectionPropertyValue('bearerToken', NULL);
        $this->setReflectionPropertyValue('bearerTokenInitialized', TRUE);

        $value = $this->class->get(BearerTokenValue::BearerToken);

        $this->assertNull($value);
    }

    /**
     * Test getting a bearer token when it's not in the authorization header.
     *
     * @covers Lunr\Corona\Parsers\BearerToken\BearerTokenCliParser::get
     */
    public function testGetBearerTokenWithMissingCliArgument(): void
    {
        $class = new BearerTokenCliParser([]);

        $value = $class->get(BearerTokenValue::BearerToken);

        $this->assertNull($value);

        $property = $this->getReflectionProperty('bearerToken');

        $this->assertNull($property->getValue($class));
    }

    /**
     * Test getting a parsed bearer token.
     *
     * @covers Lunr\Corona\Parsers\BearerToken\BearerTokenCliParser::get
     */
    public function testGetBearerToken(): void
    {
        $token = '123456789';

        $value = $this->class->get(BearerTokenValue::BearerToken);

        $this->assertEquals($token, $value);
        $this->assertPropertySame('bearerToken', $token);
    }

}

?>
