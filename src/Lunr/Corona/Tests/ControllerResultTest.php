<?php

/**
 * This file contains the ControllerResultTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2011 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Corona\Tests;

use Lunr\Corona\Exceptions\NotImplementedException;
use Lunr\Corona\HttpCode;

/**
 * This class contains test methods for the Controller class.
 *
 * @covers Lunr\Corona\Controller
 */
class ControllerResultTest extends ControllerTestCase
{

    /**
     * Test calling unimplemented methods with error enums set.
     *
     * @covers Lunr\Corona\Controller::__call
     */
    public function testNonImplementedCall(): void
    {
        $this->expectException(NotImplementedException::class);
        $this->expectExceptionMessage('Not implemented!');

        $this->class->unimplemented();
    }

    /**
     * Test setting a result return code with error enums set.
     *
     * @covers Lunr\Corona\Controller::setResult
     */
    public function testSetResultReturnCode(): void
    {
        $this->request->expects($this->once())
                      ->method('__get')
                      ->with('call')
                      ->willReturn('controller/method');

        $this->response->expects($this->once())
                       ->method('setResultCode')
                       ->with('controller/method', HttpCode::PARTIAL_CONTENT);

        $method = $this->getReflectionMethod('setResult');

        $method->invokeArgs($this->class, [ HttpCode::PARTIAL_CONTENT ]);
    }

    /**
     * Test setting a result without error message.
     *
     * @covers Lunr\Corona\Controller::setResult
     */
    public function testSetResultErrorMessageNull(): void
    {
        $this->request->expects($this->once())
                      ->method('__get')
                      ->with('call')
                      ->willReturn('controller/method');

        $this->response->expects($this->once())
                       ->method('setResultCode')
                       ->with('controller/method', HttpCode::PARTIAL_CONTENT);

        $this->response->expects($this->never())
                       ->method('setResultMessage');

        $method = $this->getReflectionMethod('setResult');

        $method->invokeArgs($this->class, [ HttpCode::PARTIAL_CONTENT ]);
    }

    /**
     * Test setting a result error message.
     *
     * @covers Lunr\Corona\Controller::setResult
     */
    public function testSetResultErrorMessage(): void
    {
        $this->request->expects($this->exactly(2))
                      ->method('__get')
                      ->with('call')
                      ->willReturn('controller/method');

        $this->response->expects($this->once())
                       ->method('setResultCode')
                       ->with('controller/method', HttpCode::PARTIAL_CONTENT);

        $this->response->expects($this->once())
                       ->method('setResultMessage')
                       ->with('controller/method', 'errmsg');

        $method = $this->getReflectionMethod('setResult');

        $method->invokeArgs($this->class, [ HttpCode::PARTIAL_CONTENT, 'errmsg' ]);
    }

    /**
     * Test setting a result without error information.
     *
     * @covers Lunr\Corona\Controller::setResult
     */
    public function testSetResultErrorInfoNull(): void
    {
        $this->request->expects($this->once())
                      ->method('__get')
                      ->with('call')
                      ->willReturn('controller/method');

        $this->response->expects($this->once())
                       ->method('setResultCode')
                       ->with('controller/method', HttpCode::PARTIAL_CONTENT);

        $this->response->expects($this->never())
                       ->method('setResultInfoCode');

        $method = $this->getReflectionMethod('setResult');

        $method->invokeArgs($this->class, [ HttpCode::PARTIAL_CONTENT ]);
    }

    /**
     * Test setting result error information.
     *
     * @covers Lunr\Corona\Controller::setResult
     */
    public function testSetResultErrorInfoNotNull(): void
    {
        $this->request->expects($this->exactly(2))
                      ->method('__get')
                      ->with('call')
                      ->willReturn('controller/method');

        $this->response->expects($this->once())
                       ->method('setResultCode')
                       ->with('controller/method', HttpCode::PARTIAL_CONTENT);

        $this->response->expects($this->once())
                       ->method('setResultInfoCode')
                       ->with('controller/method', 2060);

        $method = $this->getReflectionMethod('setResult');

        $method->invokeArgs($this->class, [ HttpCode::PARTIAL_CONTENT, NULL, 2060 ]);
    }

    /**
     * Test setting a result return code with error enums set.
     *
     * @covers Lunr\Corona\Controller::set_result
     */
    public function testDeprecatedSetResultReturnCode(): void
    {
        $this->request->expects($this->once())
                      ->method('__get')
                      ->with('call')
                      ->willReturn('controller/method');

        $this->response->expects($this->once())
                       ->method('setResultCode')
                       ->with('controller/method', HttpCode::PARTIAL_CONTENT);

        $method = $this->getReflectionMethod('set_result');

        $method->invokeArgs($this->class, [ HttpCode::PARTIAL_CONTENT ]);
    }

    /**
     * Test setting a result without error message.
     *
     * @covers Lunr\Corona\Controller::set_result
     */
    public function testDeprecatedSetResultErrorMessageNull(): void
    {
        $this->request->expects($this->once())
                      ->method('__get')
                      ->with('call')
                      ->willReturn('controller/method');

        $this->response->expects($this->once())
                       ->method('setResultCode')
                       ->with('controller/method', HttpCode::PARTIAL_CONTENT);

        $this->response->expects($this->never())
                       ->method('setResultMessage');

        $method = $this->getReflectionMethod('set_result');

        $method->invokeArgs($this->class, [ HttpCode::PARTIAL_CONTENT ]);
    }

    /**
     * Test setting a result error message.
     *
     * @covers Lunr\Corona\Controller::set_result
     */
    public function testDeprecatedSetResultErrorMessage(): void
    {
        $this->request->expects($this->exactly(2))
                      ->method('__get')
                      ->with('call')
                      ->willReturn('controller/method');

        $this->response->expects($this->once())
                       ->method('setResultCode')
                       ->with('controller/method', HttpCode::PARTIAL_CONTENT);

        $this->response->expects($this->once())
                       ->method('setResultMessage')
                       ->with('controller/method', 'errmsg');

        $method = $this->getReflectionMethod('set_result');

        $method->invokeArgs($this->class, [ HttpCode::PARTIAL_CONTENT, 'errmsg' ]);
    }

    /**
     * Test setting a result without error information.
     *
     * @covers Lunr\Corona\Controller::set_result
     */
    public function testDeprecatedSetResultErrorInfoNull(): void
    {
        $this->request->expects($this->once())
                      ->method('__get')
                      ->with('call')
                      ->willReturn('controller/method');

        $this->response->expects($this->once())
                       ->method('setResultCode')
                       ->with('controller/method', HttpCode::PARTIAL_CONTENT);

        $this->response->expects($this->never())
                       ->method('setResultInfoCode');

        $method = $this->getReflectionMethod('set_result');

        $method->invokeArgs($this->class, [ HttpCode::PARTIAL_CONTENT ]);
    }

    /**
     * Test setting result error information.
     *
     * @covers Lunr\Corona\Controller::set_result
     */
    public function testDeprecatedSetResultErrorInfoNotNull(): void
    {
        $this->request->expects($this->exactly(2))
                      ->method('__get')
                      ->with('call')
                      ->willReturn('controller/method');

        $this->response->expects($this->once())
                       ->method('setResultCode')
                       ->with('controller/method', HttpCode::PARTIAL_CONTENT);

        $this->response->expects($this->once())
                       ->method('setResultInfoCode')
                       ->with('controller/method', 2060);

        $method = $this->getReflectionMethod('set_result');

        $method->invokeArgs($this->class, [ HttpCode::PARTIAL_CONTENT, NULL, 2060 ]);
    }

}

?>
