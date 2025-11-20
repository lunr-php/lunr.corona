<?php

/**
 * This file contains the RequestGetDataFromWrappersTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2011 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Corona\Tests;

/**
 * Tests for getting stored superglobal values.
 *
 * @covers Lunr\Corona\Request
 */
class RequestGetDataFromWrappersTest extends RequestTestCase
{

    /**
     * Test getting GET data returns get value if no mock value.
     *
     * @covers Lunr\Corona\Request::getGetData
     */
    public function testGetGetData(): void
    {
        $this->assertEquals('get_value', $this->class->getGetData('get_key'));
    }

    /**
     * Test getting GET data returns get values if no mock values.
     *
     * @covers Lunr\Corona\Request::getGetData
     */
    public function testGetGetDataNoKey(): void
    {
        $this->assertEquals([ 'get_key' => 'get_value', 'get_second_key' => 'get_value' ], $this->class->getGetData());
    }

    /**
     * Test getting GET data returns mock value if present.
     *
     * @covers Lunr\Corona\Request::getGetData
     */
    public function testGetGetDataWithMockValue(): void
    {
        $this->setReflectionPropertyValue('mock', [ 'get' => [ 'get_key' => 'get_mock_value' ] ]);

        $this->assertEquals('get_mock_value', $this->class->getGetData('get_key'));
    }

    /**
     * Test getting GET data returns mock values if present.
     *
     * @covers Lunr\Corona\Request::getGetData
     */
    public function testGetGetDataWithMockValueNoKey(): void
    {
        $this->setReflectionPropertyValue('mock', [ 'get' => [ 'get_key' => 'get_mock_value', 'mock_key' => 'get_mock_value' ] ]);

        $expects = [
            'get_key'        => 'get_mock_value',
            'get_second_key' => 'get_value',
            'mock_key'       => 'get_mock_value',
        ];
        $this->assertEquals($expects, $this->class->getGetData());
    }

    /**
     * Test getting GET data returns get value if empty mock value.
     *
     * @covers Lunr\Corona\Request::getGetData
     */
    public function testGetGetDataWithInvalidMockValue(): void
    {
        $this->setReflectionPropertyValue('mock', [ 'get' => [] ]);

        $this->assertEquals('get_value', $this->class->getGetData('get_key'));
    }

    /**
     * Test getting POST data returns post value if no mock value.
     *
     * @covers Lunr\Corona\Request::getPostData
     */
    public function testGetPostData(): void
    {
        $this->assertEquals('post_value', $this->class->getPostData('post_key'));
    }

    /**
     * Test getting POST data returns get values if no mock values.
     *
     * @covers Lunr\Corona\Request::getPostData
     */
    public function testGetPostDataNoKey(): void
    {
        $this->assertEquals([ 'post_key' => 'post_value', 'post_second_key' => 'post_value' ], $this->class->getPostData());
    }

    /**
     * Test getting POST data returns mock value if present.
     *
     * @covers Lunr\Corona\Request::getPostData
     */
    public function testGetPostDataWithMockValue(): void
    {
        $this->setReflectionPropertyValue('mock', [ 'post' => [ 'post_key' => 'post_mock_value' ] ]);

        $this->assertEquals('post_mock_value', $this->class->getPostData('post_key'));
    }

    /**
     * Test getting POST data returns mock values if present.
     *
     * @covers Lunr\Corona\Request::getPostData
     */
    public function testGetPostDataWithMockValueNoKey(): void
    {
        $this->setReflectionPropertyValue('mock', [ 'post' => [ 'post_key' => 'post_mock_value', 'mock_key' => 'post_mock_value' ] ]);

        $expects = [
            'post_key'        => 'post_mock_value',
            'post_second_key' => 'post_value',
            'mock_key'        => 'post_mock_value',
        ];
        $this->assertEquals($expects, $this->class->getPostData());
    }

    /**
     * Test getting POST data returns post value if empty mock value.
     *
     * @covers Lunr\Corona\Request::getPostData
     */
    public function testGetPostDataWithInvalidMockValue(): void
    {
        $this->setReflectionPropertyValue('mock', [ 'post' => [] ]);

        $this->assertEquals('post_value', $this->class->getPostData('post_key'));
    }

    /**
     * Test getting SERVER data.
     *
     * @covers Lunr\Corona\Request::getServerData
     */
    public function testGetServerData(): void
    {
        $this->assertEquals('server_value', $this->class->getServerData('server_key'));
        $this->assertSame(1763641074.580797, $this->class->getServerData('REQUEST_TIME_FLOAT'));
        $this->assertSame(1763641074, $this->class->getServerData('REQUEST_TIME'));
        $this->assertSame([ 'Standard input code' ], $this->class->getServerData('argv'));
    }

    /**
     * Test getting HTTP Header data.
     *
     * @covers Lunr\Corona\Request::getHttpHeaderData
     */
    public function testGetHeaderData(): void
    {
        $this->assertEquals('HTTP_SERVER_VALUE', $this->class->getHttpHeaderData('server_key'));
    }

    /**
     * Test getting FILES data.
     *
     * @covers Lunr\Corona\Request::getFilesData
     */
    public function testGetFileData(): void
    {
        $this->assertEquals($this->files['image'], $this->class->getFilesData('image'));
    }

    /**
     * Test getting COOKIE data.
     *
     * @covers Lunr\Corona\Request::getCookieData
     */
    public function testGetCookieData(): void
    {
        $this->assertEquals('cookie_value', $this->class->getCookieData('cookie_key'));
    }

    /**
     * Tests that getAllOptions() returns the ast property.
     *
     * @param array $keys The array of keys to test
     *
     * @dataProvider cliArgsKeyProvider
     * @covers       Lunr\Corona\Request::getAllOptions
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

        $return = $class->getAllOptions();

        $this->assertEquals($keys, $return);
    }

    /**
     * Tests that getOptionData() returns a value for a proper key.
     *
     * @param array $value The expected value to test
     *
     * @dataProvider validCliArgsValueProvider
     * @covers       Lunr\Corona\Request::getOptionData
     */
    public function testGetOptionDataReturnsValueForValidKey($value): void
    {
        $class = $this->reflection->newInstanceWithoutConstructor();

        $this->reflection->getProperty('cliArgs')
                         ->setValue($class, [ 'a' => $value ]);

        $result = $class->getOptionData('a');

        $this->assertEquals($value, $result);
    }

    /**
     * Tests that getOptionData() returns NULL for invalid key.
     *
     * @covers Lunr\Corona\Request::getOptionData
     */
    public function testGetOptionDataReturnsNullForInvalidKey(): void
    {
        $ast = $this->getReflectionPropertyValue('cliArgs');

        $this->assertArrayNotHasKey('foo', $ast);
        $this->assertNull($this->class->getOptionData('foo'));
    }

    /**
     * Test that getRawData() returns raw request data.
     *
     * @covers Lunr\Corona\Request::getRawData
     */
    public function testGetRawDataReturnsRawRequestData(): void
    {
        $this->parser->expects($this->once())
                     ->method('parse_raw_data')
                     ->willReturn('raw');

        $this->assertEquals('raw', $this->class->getRawData());
    }

    /**
     * Test that getRawData() returns cached raw request data if parsing it is FALSE.
     *
     * @covers Lunr\Corona\Request::getRawData
     */
    public function testGetRawDataReturnsCachedRawRequestData(): void
    {
        $this->parser->expects($this->exactly(2))
                     ->method('parse_raw_data')
                     ->willReturnOnConsecutiveCalls('raw', FALSE);

        $this->assertEquals('raw', $this->class->getRawData());
        $this->assertEquals('raw', $this->class->getRawData());
        $this->assertEquals('raw', $this->getReflectionPropertyValue('rawData'));
    }

    /**
     * Test that getRawData() returns no cached raw request data if parsing it is not empty.
     *
     * @covers Lunr\Corona\Request::getRawData
     */
    public function testGetRawDataReturnsUnCachedRawRequestData(): void
    {
        $this->parser->expects($this->exactly(2))
                     ->method('parse_raw_data')
                     ->willReturnOnConsecutiveCalls('raw', 'hello');

        $this->assertEquals('raw', $this->class->getRawData());
        $this->assertEquals('raw', $this->getReflectionPropertyValue('rawData'));
        $this->assertEquals('hello', $this->class->getRawData());
        $this->assertEquals('hello', $this->getReflectionPropertyValue('rawData'));
    }

}

?>
