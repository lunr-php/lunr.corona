<?php

/**
 * This file contains the UrlParserGetTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2025 Framna Netherlands B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Corona\Parsers\Url\Tests;

use Lunr\Corona\Parsers\Url\UrlValue;
use Lunr\Corona\Tests\Helpers\MockRequestValue;
use RuntimeException;

/**
 * This class contains test methods for the UrlParser class.
 *
 * @covers Lunr\Corona\Parsers\Url\UrlParser
 */
class UrlParserGetTest extends UrlParserTestCase
{

    /**
     * Test that getRequestValueType() returns the correct type.
     *
     * @covers Lunr\Corona\Parsers\Url\UrlParser::getRequestValueType
     */
    public function testGetRequestValueType(): void
    {
        $this->assertEquals(UrlValue::class, $this->class->getRequestValueType());
    }

    /**
     * Test getting an unsupported value.
     *
     * @covers Lunr\Corona\Parsers\Url\UrlParser::get
     */
    public function testGetUnsupportedValue(): void
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Unsupported request value type "Lunr\Corona\Tests\Helpers\MockRequestValue"');

        $this->class->get(MockRequestValue::Foo);
    }

}

?>
