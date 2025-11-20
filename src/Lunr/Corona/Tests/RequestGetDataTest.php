<?php

/**
 * This file contains the RequestGetDataTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2011 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Corona\Tests;

use Lunr\Corona\RequestData;

/**
 * Tests for getting stored superglobal values.
 *
 * @covers Lunr\Corona\Request
 */
class RequestGetDataTest extends RequestTestCase
{

    /**
     * Test getting GET data returns get value if no mock value.
     *
     * @covers Lunr\Corona\Request::getData
     */
    public function testGetGetData(): void
    {
        $this->assertEquals('get_value', $this->class->getData('get_key', RequestData::Get));
    }

    /**
     * Test getting GET data returns get values if no mock values.
     *
     * @covers Lunr\Corona\Request::getData
     */
    public function testGetGetDataNoKey(): void
    {
        $this->assertEquals([ 'get_key' => 'get_value', 'get_second_key' => 'get_value' ], $this->class->getData(type: RequestData::Get));
    }

    /**
     * Test getting GET data returns mock value if present.
     *
     * @covers Lunr\Corona\Request::getData
     */
    public function testGetGetDataWithMockValue(): void
    {
        $this->setReflectionPropertyValue('mock', [ 'get' => [ 'get_key' => 'get_mock_value' ] ]);

        $this->assertEquals('get_mock_value', $this->class->getData('get_key', RequestData::Get));
    }

    /**
     * Test getting GET data returns mock values if present.
     *
     * @covers Lunr\Corona\Request::getData
     */
    public function testGetGetDataWithMockValueNoKey(): void
    {
        $this->setReflectionPropertyValue('mock', [ 'get' => [ 'get_key' => 'get_mock_value', 'mock_key' => 'get_mock_value' ] ]);

        $expects = [
            'get_key'        => 'get_mock_value',
            'get_second_key' => 'get_value',
            'mock_key'       => 'get_mock_value',
        ];
        $this->assertEquals($expects, $this->class->getData(type: RequestData::Get));
    }

    /**
     * Test getting GET data returns get value if empty mock value.
     *
     * @covers Lunr\Corona\Request::getData
     */
    public function testGetGetDataWithInvalidMockValue(): void
    {
        $this->setReflectionPropertyValue('mock', [ 'get' => [] ]);

        $this->assertEquals('get_value', $this->class->getData('get_key', RequestData::Get));
    }

    /**
     * Test getting POST data returns post value if no mock value.
     *
     * @covers Lunr\Corona\Request::getData
     */
    public function testGetPostData(): void
    {
        $this->assertEquals('post_value', $this->class->getData('post_key', RequestData::Post));
    }

    /**
     * Test getting POST data returns get values if no mock values.
     *
     * @covers Lunr\Corona\Request::getData
     */
    public function testGetPostDataNoKey(): void
    {
        $this->assertEquals([ 'post_key' => 'post_value', 'post_second_key' => 'post_value' ], $this->class->getData(type: RequestData::Post));
    }

    /**
     * Test getting POST data returns mock value if present.
     *
     * @covers Lunr\Corona\Request::getData
     */
    public function testGetPostDataWithMockValue(): void
    {
        $this->setReflectionPropertyValue('mock', [ 'post' => [ 'post_key' => 'post_mock_value' ] ]);

        $this->assertEquals('post_mock_value', $this->class->getData('post_key', RequestData::Post));
    }

    /**
     * Test getting POST data returns mock values if present.
     *
     * @covers Lunr\Corona\Request::getData
     */
    public function testGetPostDataWithMockValueNoKey(): void
    {
        $this->setReflectionPropertyValue('mock', [ 'post' => [ 'post_key' => 'post_mock_value', 'mock_key' => 'post_mock_value' ] ]);

        $expects = [
            'post_key'        => 'post_mock_value',
            'post_second_key' => 'post_value',
            'mock_key'        => 'post_mock_value',
        ];
        $this->assertEquals($expects, $this->class->getData(type: RequestData::Post));
    }

    /**
     * Test getting POST data returns post value if empty mock value.
     *
     * @covers Lunr\Corona\Request::getData
     */
    public function testGetPostDataWithInvalidMockValue(): void
    {
        $this->setReflectionPropertyValue('mock', [ 'post' => [] ]);

        $this->assertEquals('post_value', $this->class->getData('post_key', RequestData::Post));
    }

    /**
     * Test getting SERVER data.
     *
     * @covers Lunr\Corona\Request::getData
     */
    public function testGetServerData(): void
    {
        $this->assertEquals('server_value', $this->class->getData('server_key', RequestData::Server));
        $this->assertSame(1763641074.580797, $this->class->getData('REQUEST_TIME_FLOAT', RequestData::Server));
        $this->assertSame(1763641074, $this->class->getData('REQUEST_TIME', RequestData::Server));
        $this->assertSame([ 'Standard input code' ], $this->class->getData('argv', RequestData::Server));
    }

    /**
     * Test getting HTTP Header data.
     *
     * @covers Lunr\Corona\Request::getData
     */
    public function testGetHeaderData(): void
    {
        $this->assertEquals('HTTP_SERVER_VALUE', $this->class->getData('server_key', RequestData::Header));
    }

    /**
     * Test getting FILES data.
     *
     * @covers Lunr\Corona\Request::getData
     */
    public function testGetFileData(): void
    {
        $this->assertEquals($this->files['image'], $this->class->getData('image', RequestData::Upload));
    }

    /**
     * Test getting COOKIE data.
     *
     * @covers Lunr\Corona\Request::getData
     */
    public function testGetCookieData(): void
    {
        $this->assertEquals('cookie_value', $this->class->getData('cookie_key', RequestData::Cookie));
    }

    /**
     * Tests that getData() returns the ast property.
     *
     * @param array $keys The array of keys to test
     *
     * @dataProvider cliArgsKeyProvider
     * @covers       Lunr\Corona\Request::getData
     */
    public function testGetAllOptionsReturnsArray($keys): void
    {
        $values = [];
        for ($i = 0; $i < count($keys); $i++)
        {
            $values[] = 'value';
        }

        $class = $this->reflection->newInstanceWithoutConstructor();

        $this->reflection->getProperty('cliArgs')
                         ->setValue($class, array_combine($keys, $values));

        $return = $class->getData(type: RequestData::CliOption);

        $this->assertEquals($keys, $return);
    }

    /**
     * Tests that getData() returns a value for a proper key.
     *
     * @param array $value The expected value to test
     *
     * @dataProvider validCliArgsValueProvider
     * @covers       Lunr\Corona\Request::getData
     */
    public function testGetOptionDataReturnsValueForValidKey($value): void
    {
        $class = $this->reflection->newInstanceWithoutConstructor();

        $this->reflection->getProperty('cliArgs')
                         ->setValue($class, [ 'a' => $value ]);

        $result = $class->getData('a', RequestData::CliArgument);

        $this->assertEquals($value, $result);
    }

    /**
     * Tests that getData() returns NULL for invalid key.
     *
     * @covers Lunr\Corona\Request::getData
     */
    public function testGetOptionDataReturnsNullForInvalidKey(): void
    {
        $ast = $this->getReflectionPropertyValue('cliArgs');

        $this->assertArrayNotHasKey('foo', $ast);
        $this->assertNull($this->class->getData('foo', RequestData::CliArgument));
    }

    /**
     * Test that getAcceptFormat() returns content type when called with a valid set of supported formats.
     *
     * @param array $value The expected value
     *
     * @dataProvider contentTypeProvider
     * @covers       Lunr\Corona\Request::getAcceptFormat
     */
    public function testGetAcceptFormatWithValidSupportedFormatsReturnsString(array $value): void
    {
        $this->parser->expects($this->once())
                     ->method('parse_accept_format')
                     ->with($value)
                     ->willReturn('text/html');

        $this->assertEquals($value[0], $this->class->getAcceptFormat($value));
    }

    /**
     * Test that getAcceptFormat() returns null when called with an empty set of supported formats.
     *
     * @covers Lunr\Corona\Request::getAcceptFormat
     */
    public function testGetAcceptFormatWithEmptySupportedFormatsReturnsNull(): void
    {
        $this->assertNull($this->class->getAcceptFormat([]));
    }

    /**
     * Test that getAcceptLanguage() returns content type when called with a valid set of supported languages.
     *
     * @param array $value The expected value
     *
     * @dataProvider acceptLanguageProvider
     * @covers       Lunr\Corona\Request::getAcceptLanguage
     */
    public function testGetAcceptLanguageWithValidSupportedLanguagesReturnsString(array $value): void
    {
        $this->parser->expects($this->once())
                     ->method('parse_accept_language')
                     ->with($value)
                     ->willReturn('en-US');

        $this->assertEquals($value[0], $this->class->getAcceptLanguage($value));
    }

    /**
     * Test that getAcceptFormat() returns null when called with an empty set of supported languages.
     *
     * @covers Lunr\Corona\Request::getAcceptLanguage
     */
    public function testGetAcceptLanguageWithEmptySupportedLanguagesReturnsNull(): void
    {
        $this->assertNull($this->class->getAcceptLanguage([]));
    }

    /**
     * Test that getAcceptCharset() returns content type when called with a valid set of supported charsets.
     *
     * @param array $value The expected value
     *
     * @dataProvider acceptCharsetProvider
     * @covers       Lunr\Corona\Request::getAcceptCharset
     */
    public function testGetAcceptCharsetWithValidSupportedCharsetsReturnsString(array $value): void
    {
        $this->parser->expects($this->once())
                     ->method('parse_accept_charset')
                     ->with($value)
                     ->willReturn('utf-8');

        $this->assertEquals($value[0], $this->class->getAcceptCharset($value));
    }

    /**
     * Test that getAcceptCharset() returns null when called with an empty set of supported charsets.
     *
     * @covers Lunr\Corona\Request::getAcceptCharset
     */
    public function testGetAcceptCharsetWithEmptySupportedCharsetsReturnsNull(): void
    {
        $this->assertNull($this->class->getAcceptCharset([]));
    }

    /**
     * Test that getData() returns raw request data.
     *
     * @covers Lunr\Corona\Request::getData
     */
    public function testGetRawDataReturnsRawRequestData(): void
    {
        $this->parser->expects($this->once())
                     ->method('parse_raw_data')
                     ->willReturn('raw');

        $this->assertEquals('raw', $this->class->getData(type: RequestData::Raw));
    }

    /**
     * Test that getData() returns cached raw request data if parsing it is FALSE.
     *
     * @covers Lunr\Corona\Request::getData
     */
    public function testGetRawDataReturnsCachedRawRequestData(): void
    {
        $this->parser->expects($this->exactly(2))
                     ->method('parse_raw_data')
                     ->willReturnOnConsecutiveCalls('raw', FALSE);

        $this->assertEquals('raw', $this->class->getData(type: RequestData::Raw));
        $this->assertEquals('raw', $this->class->getData(type: RequestData::Raw));
        $this->assertEquals('raw', $this->getReflectionPropertyValue('rawData'));
    }

    /**
     * Test that getData() returns no cached raw request data if parsing it is not empty.
     *
     * @covers Lunr\Corona\Request::getData
     */
    public function testGetRawDataReturnsUnCachedRawRequestData(): void
    {
        $this->parser->expects($this->exactly(2))
                     ->method('parse_raw_data')
                     ->willReturnOnConsecutiveCalls('raw', 'hello');

        $this->assertEquals('raw', $this->class->getData(type: RequestData::Raw));
        $this->assertEquals('raw', $this->getReflectionPropertyValue('rawData'));
        $this->assertEquals('hello', $this->class->getData(type: RequestData::Raw));
        $this->assertEquals('hello', $this->getReflectionPropertyValue('rawData'));
    }

}

?>
