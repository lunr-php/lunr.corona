<?php

/**
 * This file contains the ResponseSetTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2011 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Corona\Tests;

use Lunr\Corona\HttpCode;

/**
 * This class contains test methods for the Response class.
 *
 * @covers Lunr\Corona\Response
 */
class ResponseSetTest extends ResponseTestCase
{

    /**
     * Test that setting data directly does not work.
     *
     * @param string $attr Attribute name
     *
     * @dataProvider invalidResponseAttributesProvider
     * @covers       Lunr\Corona\Response::__set
     */
    public function testSetInaccessibleAttributesDoesNotWork($attr): void
    {
        $this->class->$attr = 'value';

        $this->assertArrayEmpty($this->getReflectionPropertyValue($attr));
    }

    /**
     * Test setting a view.
     *
     * @covers Lunr\Corona\Response::__set
     */
    public function testSetView(): void
    {
        $this->class->view = 'TestView';

        $this->assertEquals('TestView', $this->getReflectionPropertyValue('view'));
    }

    /**
     * Test setting a default result without message.
     *
     * @covers Lunr\Corona\Response::setDefaultResult
     */
    public function testSetDefaultResult(): void
    {
        $this->class->setDefaultResult(HttpCode::NOT_IMPLEMENTED);

        $this->assertPropertySame('defaultResultCode', HttpCode::NOT_IMPLEMENTED);
        $this->assertPropertySame('defaultResultMessage', NULL);
    }

    /**
     * Test setting a default result without message.
     *
     * @covers Lunr\Corona\Response::setDefaultResult
     */
    public function testSetDefaultResultWithMessage(): void
    {
        $this->class->setDefaultResult(HttpCode::NOT_IMPLEMENTED, 'Not implemented!');

        $this->assertPropertySame('defaultResultCode', HttpCode::NOT_IMPLEMENTED);
        $this->assertPropertySame('defaultResultMessage', 'Not implemented!');
    }

    /**
     * Test adding response data.
     *
     * @covers Lunr\Corona\Response::addResponseData
     */
    public function testAddResponseData(): void
    {
        $this->class->addResponseData('key', 'value');

        $value = $this->getReflectionPropertyValue('data');

        $this->assertArrayHasKey('key', $value);
        $this->assertEquals('value', $value['key']);
    }

    /**
     * Test adding response data.
     *
     * @covers Lunr\Corona\Response::add_response_data
     */
    public function testDeprecatedAddResponseData(): void
    {
        $this->class->add_response_data('key', 'value');

        $value = $this->getReflectionPropertyValue('data');

        $this->assertArrayHasKey('key', $value);
        $this->assertEquals('value', $value['key']);
    }

    /**
     * Test setting a result message.
     *
     * @covers Lunr\Corona\Response::setResultMessage
     */
    public function testSetResultMessage(): void
    {
        $this->class->setResultMessage('ID', 'Message');

        $value = $this->getReflectionPropertyValue('resultMessage');

        $this->assertArrayHasKey('ID', $value);
        $this->assertEquals('Message', $value['ID']);
    }

    /**
     * Test setting an error message.
     *
     * @covers Lunr\Corona\Response::set_error_message
     */
    public function testSetErrorMessage(): void
    {
        $this->class->set_error_message('ID', 'Message');

        $value = $this->getReflectionPropertyValue('resultMessage');

        $this->assertArrayHasKey('ID', $value);
        $this->assertEquals('Message', $value['ID']);
    }

    /**
     * Test setting a result information code.
     *
     * @covers Lunr\Corona\Response::setResultInfoCode
     */
    public function testSetResultInformationCode(): void
    {
        $this->class->setResultInfoCode('ID', 5010);

        $value = $this->getReflectionPropertyValue('resultInfoCode');

        $this->assertArrayHasKey('ID', $value);
        $this->assertEquals(5010, $value['ID']);
    }

    /**
     * Test setting an error information.
     *
     * @covers Lunr\Corona\Response::set_error_info
     */
    public function testSetErrorInformation(): void
    {
        $this->class->set_error_info('ID', 5010);

        $value = $this->getReflectionPropertyValue('resultInfoCode');

        $this->assertArrayHasKey('ID', $value);
        $this->assertEquals(5010, $value['ID']);
    }

    /**
     * Test setting a valid result code.
     *
     * @covers Lunr\Corona\Response::setResultCode
     */
    public function testSetValidResultCode(): void
    {
        $this->class->setResultCode('ID', 503);

        $value = $this->getReflectionPropertyValue('resultCode');

        $this->assertArrayHasKey('ID', $value);
        $this->assertSame(503, $value['ID']);
    }

    /**
     * Test setting a valid return code.
     *
     * @covers Lunr\Corona\Response::set_return_code
     */
    public function testSetValidReturnCode(): void
    {
        $this->class->set_return_code('ID', 503);

        $value = $this->getReflectionPropertyValue('resultCode');

        $this->assertArrayHasKey('ID', $value);
        $this->assertSame(503, $value['ID']);
    }

}

?>
