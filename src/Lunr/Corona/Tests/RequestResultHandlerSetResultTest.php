<?php

/**
 * This file contains the RequestResultHandlerSetResultTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2018 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Corona\Tests;

use Lunr\Corona\HttpCode;

/**
 * This class contains test methods for the RequestResultHandler class.
 *
 * @covers Lunr\Corona\RequestResultHandler
 */
class RequestResultHandlerSetResultTest extends RequestResultHandlerTestCase
{

    /**
     * Test setting a result return code with error enums set.
     *
     * @covers Lunr\Corona\RequestResultHandler::setResult
     */
    public function testSetResultReturnCode(): void
    {
        $this->request->expects($this->once())
                      ->method('__get')
                      ->with('call')
                      ->willReturn('controller/method');

        $this->response->expects($this->once())
                       ->method('setResultCode')
                       ->with('controller/method', HttpCode::NOT_IMPLEMENTED);

        $method = $this->getReflectionMethod('setResult');

        $method->invokeArgs($this->class, [ HttpCode::NOT_IMPLEMENTED ]);
    }

    /**
     * Test setting a result without error message.
     *
     * @covers Lunr\Corona\RequestResultHandler::setResult
     */
    public function testSetResultErrorMessageNull(): void
    {
        $this->request->expects($this->once())
                      ->method('__get')
                      ->with('call')
                      ->willReturn('controller/method');

        $this->response->expects($this->once())
                       ->method('setResultCode')
                       ->with('controller/method', HttpCode::NOT_IMPLEMENTED);

        $this->response->expects($this->never())
                       ->method('setResultMessage');

        $method = $this->getReflectionMethod('setResult');

        $method->invokeArgs($this->class, [ HttpCode::NOT_IMPLEMENTED ]);
    }

    /**
     * Test setting a result error message.
     *
     * @covers Lunr\Corona\RequestResultHandler::setResult
     */
    public function testSetResultErrorMessage(): void
    {
        $this->request->expects($this->exactly(2))
                      ->method('__get')
                      ->with('call')
                      ->willReturn('controller/method');

        $this->response->expects($this->once())
                       ->method('setResultCode')
                       ->with('controller/method', HttpCode::NOT_IMPLEMENTED);

        $this->response->expects($this->once())
                       ->method('setResultMessage')
                       ->with('controller/method', 'errmsg');

        $method = $this->getReflectionMethod('setResult');

        $method->invokeArgs($this->class, [ HttpCode::NOT_IMPLEMENTED, 'errmsg' ]);
    }

    /**
     * Test setting a result without error information.
     *
     * @covers Lunr\Corona\RequestResultHandler::setResult
     */
    public function testSetResultErrorInfoNull(): void
    {
        $this->request->expects($this->once())
                      ->method('__get')
                      ->with('call')
                      ->willReturn('controller/method');

        $this->response->expects($this->once())
                       ->method('setResultCode')
                       ->with('controller/method', HttpCode::NOT_IMPLEMENTED);

        $this->response->expects($this->never())
                       ->method('setResultInfoCode');

        $method = $this->getReflectionMethod('setResult');

        $method->invokeArgs($this->class, [ HttpCode::NOT_IMPLEMENTED ]);
    }

    /**
     * Test setting result error information.
     *
     * @covers Lunr\Corona\RequestResultHandler::setResult
     */
    public function testSetResultErrorInfoNotNull(): void
    {
        $this->request->expects($this->exactly(2))
                      ->method('__get')
                      ->with('call')
                      ->willReturn('controller/method');

        $this->response->expects($this->once())
                       ->method('setResultCode')
                       ->with('controller/method', HttpCode::NOT_IMPLEMENTED);

        $this->response->expects($this->once())
                       ->method('setResultInfoCode')
                       ->with('controller/method', 9999);

        $method = $this->getReflectionMethod('setResult');

        $method->invokeArgs($this->class, [ HttpCode::NOT_IMPLEMENTED, NULL, 9999 ]);
    }

}

?>
