<?php

/**
 * This file contains the ResponseGetTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2011 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Corona\Tests;

/**
 * This class contains test methods for the Response class.
 *
 * @covers Lunr\Corona\Response
 */
class ResponseGetTest extends ResponseTestCase
{

    /**
     * Test getting existing attributes via __get.
     *
     * @param string $attr  Attribute name
     * @param mixed  $value Expected attribute value
     *
     * @dataProvider validResponseAttributesProvider
     * @covers       Lunr\Corona\Response::__get
     */
    public function testGettingExistingAttributes($attr, $value): void
    {
        $this->assertEquals($value, $this->class->$attr);
    }

    /**
     * Test getting existing attributes via __get.
     *
     * @param string $attr Attribute name
     *
     * @dataProvider invalidResponseAttributesProvider
     * @covers       Lunr\Corona\Response::__get
     */
    public function testGettingInaccessibleAttributes($attr): void
    {
        $this->assertNull($this->class->$attr);
    }

    /**
     * Test getting existing response data.
     *
     * @covers Lunr\Corona\Response::getResponseData
     */
    public function testGetResponseDataWithExistingKey(): void
    {
        $data = [ 'key' => 'value' ];

        $this->setReflectionPropertyValue('data', $data);

        $this->assertEquals('value', $this->class->getResponseData('key'));
    }

    /**
     * Test getting non-existing response data.
     *
     * @covers Lunr\Corona\Response::getResponseData
     */
    public function testGetResponseDataWithNonExistingKey(): void
    {
        $this->assertNull($this->class->getResponseData('non-existing'));
    }

    /**
     * Test getting all the response data.
     *
     * @covers Lunr\Corona\Response::getResponseData
     */
    public function testGetResponseDataWithoutKey(): void
    {
        $data = [ 'key1' => 'value1', 'key2' => 'value2' ];

        $this->setReflectionPropertyValue('data', $data);

        $this->assertEquals($data, $this->class->getResponseData());
    }

    /**
     * Test getting existing response data.
     *
     * @covers Lunr\Corona\Response::get_response_data
     */
    public function testDeprecatedGetResponseDataWithExistingKey(): void
    {
        $data = [ 'key' => 'value' ];

        $this->setReflectionPropertyValue('data', $data);

        $this->assertEquals('value', $this->class->get_response_data('key'));
    }

    /**
     * Test getting non-existing response data.
     *
     * @covers Lunr\Corona\Response::get_response_data
     */
    public function testDeprecatedGetResponseDataWithNonExistingKey(): void
    {
        $this->assertNull($this->class->get_response_data('non-existing'));
    }

    /**
     * Test getting all the response data.
     *
     * @covers Lunr\Corona\Response::get_response_data
     */
    public function testDeprecatedGetResponseDataWithoutKey(): void
    {
        $data = [ 'key1' => 'value1', 'key2' => 'value2' ];

        $this->setReflectionPropertyValue('data', $data);

        $this->assertEquals($data, $this->class->get_response_data());
    }

    /**
     * Test getting existing result message.
     *
     * @covers Lunr\Corona\Response::getResultMessage
     */
    public function testGetExistingResultMessage(): void
    {
        $data = [ 'controller/method' => 'error message' ];

        $this->setReflectionPropertyValue('resultMessage', $data);

        $this->assertEquals('error message', $this->class->getResultMessage('controller/method'));
    }

    /**
     * Test getting non-existing result message.
     *
     * @covers Lunr\Corona\Response::getResultMessage
     */
    public function testGetNonExistentResultMessage(): void
    {
        $this->assertNull($this->class->getResultMessage('controller/method'));
    }

    /**
     * Test getting default result message.
     *
     * @covers Lunr\Corona\Response::getResultMessage
     */
    public function testGetDefaultResultMessage(): void
    {
        $this->setReflectionPropertyValue('defaultResultMessage', 'Not implemented!');

        $this->assertEquals('Not implemented!', $this->class->getResultMessage('_lunr_corona_response_default'));
    }

    /**
     * Test getting non-existing result message.
     *
     * @covers Lunr\Corona\Response::getResultMessage
     */
    public function testGetNonExistentDefaultResultMessage(): void
    {
        $this->assertNull($this->class->getResultMessage('_lunr_corona_response_default'));
    }

    /**
     * Test getting existing error message.
     *
     * @covers Lunr\Corona\Response::get_error_message
     */
    public function testGetExistingErrorMessage(): void
    {
        $data = [ 'controller/method' => 'error message' ];

        $this->setReflectionPropertyValue('resultMessage', $data);

        $this->assertEquals('error message', $this->class->get_error_message('controller/method'));
    }

    /**
     * Test getting non-existing error message.
     *
     * @covers Lunr\Corona\Response::get_error_message
     */
    public function testGetNonExistentErrorMessage(): void
    {
        $this->assertNull($this->class->get_error_message('controller/method'));
    }

    /**
     * Test getting existing result information code.
     *
     * @covers Lunr\Corona\Response::getResultInfoCode
     */
    public function testGetExistingResultInfoCode(): void
    {
        $data = [ 'controller/method' => 5010 ];

        $this->setReflectionPropertyValue('resultInfoCode', $data);

        $this->assertEquals(5010, $this->class->getResultInfoCode('controller/method'));
    }

    /**
     * Test getting non-existing result information code.
     *
     * @covers Lunr\Corona\Response::getResultInfoCode
     */
    public function testGetNonExistentResultInfoCode(): void
    {
        $this->assertNull($this->class->getResultInfoCode('controller/method'));
    }

    /**
     * Test getting existing error information.
     *
     * @covers Lunr\Corona\Response::get_error_info
     */
    public function testGetExistingErrorInfo(): void
    {
        $data = [ 'controller/method' => 5010 ];

        $this->setReflectionPropertyValue('resultInfoCode', $data);

        $this->assertEquals(5010, $this->class->get_error_info('controller/method'));
    }

    /**
     * Test getting non-existing error information.
     *
     * @covers Lunr\Corona\Response::get_error_info
     */
    public function testGetNonExistentErrorInfo(): void
    {
        $this->assertNull($this->class->get_error_info('controller/method'));
    }

    /**
     * Test getting result code without identifier with no code.
     *
     * @covers Lunr\Corona\Response::getResultCode
     */
    public function testGetResultCodeWithoutIdentifierWithEmptyCodes(): void
    {
        $this->setReflectionPropertyValue('resultCode', []);

        $this->assertNull($this->class->getResultCode());
    }

    /**
     * Test getting result code without identifier with no code.
     *
     * @covers Lunr\Corona\Response::getResultCode
     */
    public function testGetResultCodeWithoutIdentifierWithEmptyCodesAndDefaultSet(): void
    {
        $this->setReflectionPropertyValue('resultCode', []);
        $this->setReflectionPropertyValue('defaultResultCode', 501);

        $this->assertSame(501, $this->class->getResultCode());
    }

    /**
     * Test getting result code without identifier with no code.
     *
     * @covers Lunr\Corona\Response::getResultCode
     */
    public function testGetResultCodeWithoutIdentifierWithEmptyCodesAndRequestingDefault(): void
    {
        $this->setReflectionPropertyValue('resultCode', []);
        $this->setReflectionPropertyValue('defaultResultCode', 501);

        $this->assertSame(501, $this->class->getResultCode('_lunr_corona_response_default'));
    }

    /**
     * Test getting result code without identifier with no code.
     *
     * @covers Lunr\Corona\Response::getResultCode
     */
    public function testGetResultCodeWithoutIdentifierWithEmptyCodesAndRequestingNonExistentDefault(): void
    {
        $this->setReflectionPropertyValue('resultCode', []);

        $this->assertNull($this->class->getResultCode('_lunr_corona_response_default'));
    }

    /**
     * Test getting result code with no code.
     *
     * @covers Lunr\Corona\Response::getResultCode
     */
    public function testGetResultCodeWithEmptyCodes(): void
    {
        $this->setReflectionPropertyValue('resultCode', []);

        $this->assertNull($this->class->getResultCode('controller/method'));
    }

    /**
     * Test getting existing result code.
     *
     * @covers Lunr\Corona\Response::getResultCode
     */
    public function testGetExistingResultCode(): void
    {
        $data = [ 'controller/method' => 200 ];

        $this->setReflectionPropertyValue('resultCode', $data);

        $this->assertSame(200, $this->class->getResultCode('controller/method'));
    }

    /**
     * Test getting non-existing result code.
     *
     * @covers Lunr\Corona\Response::getResultCode
     */
    public function testGetNonExistentResultCode(): void
    {
        $this->assertNull($this->class->getResultCode('controller/method'));
    }

    /**
     * Test getting result code with highest error code.
     *
     * @covers Lunr\Corona\Response::getResultCode
     */
    public function testGetResultCodeWithoutIdentifier(): void
    {
        $data = [ 'controller/method' => 200, 'ID' => 300, 'ID3' => 500 ];

        $this->setReflectionPropertyValue('resultCode', $data);

        $this->assertSame(500, $this->class->getResultCode());
    }

    /**
     * Test getting return code without identifier with no code.
     *
     * @covers Lunr\Corona\Response::get_return_code
     */
    public function testGetReturnCodeWithoutIdentifierWithEmptyCodes(): void
    {
        $this->setReflectionPropertyValue('resultCode', []);

        $this->assertNull($this->class->get_return_code());
    }

    /**
     * Test getting return code with no code.
     *
     * @covers Lunr\Corona\Response::get_return_code
     */
    public function testGetReturnCodeWithEmptyCodes(): void
    {
        $this->setReflectionPropertyValue('resultCode', []);

        $this->assertNull($this->class->get_return_code('controller/method'));
    }

    /**
     * Test getting existing return code.
     *
     * @covers Lunr\Corona\Response::get_return_code
     */
    public function testGetExistingReturnCode(): void
    {
        $data = [ 'controller/method' => 200 ];

        $this->setReflectionPropertyValue('resultCode', $data);

        $this->assertSame(200, $this->class->get_return_code('controller/method'));
    }

    /**
     * Test getting non-existing return code.
     *
     * @covers Lunr\Corona\Response::get_return_code
     */
    public function testGetNonExistentReturnCode(): void
    {
        $this->assertNull($this->class->get_return_code('controller/method'));
    }

    /**
     * Test getting return code with highest error code.
     *
     * @covers Lunr\Corona\Response::get_return_code
     */
    public function testGetReturnCodeWithoutIdentifier(): void
    {
        $data = [ 'controller/method' => 200, 'ID' => 300, 'ID3' => 500 ];

        $this->setReflectionPropertyValue('resultCode', $data);

        $this->assertSame(500, $this->class->get_return_code());
    }

    /**
     * Test getting identifier of the highest result code with no code.
     *
     * @covers Lunr\Corona\Response::getResultCodeIdentifiers
     */
    public function testGetMaximumResultCodeIdentifiersWithEmptyCodes(): void
    {
        $this->setReflectionPropertyValue('resultCode', []);

        $this->assertEquals([ '_lunr_corona_response_default' ], $this->class->getResultCodeIdentifiers());
    }

    /**
     * Test getting all result code identifiers with no code.
     *
     * @covers Lunr\Corona\Response::getResultCodeIdentifiers
     */
    public function testGetResultCodeIdentifiersWithEmptyCodes(): void
    {
        $this->setReflectionPropertyValue('resultCode', []);

        $this->assertEquals('_lunr_corona_response_default', $this->class->getResultCodeIdentifiers(max: TRUE));
    }

    /**
     * Test getting identifier of the highest result code.
     *
     * @covers Lunr\Corona\Response::getResultCodeIdentifiers
     */
    public function testGetMaximumResultCodeIdentifier(): void
    {
        $data = [ 'controller/method' => 200, 'ID' => 300, 'ID3' => 500 ];

        $this->setReflectionPropertyValue('resultCode', $data);

        $this->assertEquals('ID3', $this->class->getResultCodeIdentifiers(max: TRUE));
    }

    /**
     * Test getting all result code identifiers.
     *
     * @covers Lunr\Corona\Response::getResultCodeIdentifiers
     */
    public function testGetAllResultCodeIdentifiers(): void
    {
        $data = [ 'controller/method' => 200, 'ID' => 300, 'ID3' => 500 ];

        $this->setReflectionPropertyValue('resultCode', $data);

        $this->assertSame([ 'controller/method', 'ID', 'ID3' ], $this->class->getResultCodeIdentifiers());
    }

    /**
     * Test getting identifier of the highest return code with no code.
     *
     * @covers Lunr\Corona\Response::get_return_code_identifiers
     */
    public function testGetMaximumReturnCodeIdentifiersWithEmptyCodes(): void
    {
        $this->setReflectionPropertyValue('resultCode', []);

        $this->assertEquals([ '_lunr_corona_response_default' ], $this->class->get_return_code_identifiers());
    }

    /**
     * Test getting all return code identifiers with no code.
     *
     * @covers Lunr\Corona\Response::get_return_code_identifiers
     */
    public function testGetReturnCodeIdentifiersWithEmptyCodes(): void
    {
        $this->setReflectionPropertyValue('resultCode', []);

        $this->assertEquals('_lunr_corona_response_default', $this->class->get_return_code_identifiers(max: TRUE));
    }

    /**
     * Test getting identifier of the highest return code.
     *
     * @covers Lunr\Corona\Response::get_return_code_identifiers
     */
    public function testGetMaximumReturnCodeIdentifier(): void
    {
        $data = [ 'controller/method' => 200, 'ID' => 300, 'ID3' => 500 ];

        $this->setReflectionPropertyValue('resultCode', $data);

        $this->assertEquals('ID3', $this->class->get_return_code_identifiers(max: TRUE));
    }

    /**
     * Test getting all return code identifiers.
     *
     * @covers Lunr\Corona\Response::get_return_code_identifiers
     */
    public function testGetAllReturnCodeIdentifiers(): void
    {
        $data = [ 'controller/method' => 200, 'ID' => 300, 'ID3' => 500 ];

        $this->setReflectionPropertyValue('resultCode', $data);

        $this->assertSame([ 'controller/method', 'ID', 'ID3' ], $this->class->get_return_code_identifiers());
    }

}

?>
