<?php

/**
 * This file contains the RequestResultHandlerHandleRequestTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2018 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Corona\Tests;

use Error;
use Exception;
use Lunr\Corona\Exceptions\BadRequestException;

/**
 * This class contains test methods for the RequestResultHandler class.
 *
 * @covers Lunr\Corona\RequestResultHandler
 */
class RequestResultHandlerHandleRequestTest extends RequestResultHandlerTestCase
{

    /**
     * Test that handleRequest() works correctly with an already instantiated controller.
     *
     * @covers Lunr\Corona\RequestResultHandler::handleRequest
     */
    public function testHandleRequestWithInstantiatedController(): void
    {
        $controller = $this->getMockBuilder('Lunr\Corona\Tests\MockController')
                           ->disableOriginalConstructor()
                           ->getMock();

        $this->request->expects($this->exactly(1))
                      ->method('__get')
                      ->with('call')
                      ->willReturn('controller/method');

        $this->response->expects($this->exactly(1))
                       ->method('getResultCode')
                       ->willReturn(NULL);

        $this->response->expects($this->exactly(1))
                       ->method('setResultCode')
                       ->with('controller/method', 200);

        $controller->expects($this->once())
                   ->method('foo')
                   ->with(1, 2);

        $this->class->handleRequest([ $controller, 'foo' ], [ 1, 2 ]);
    }

    /**
     * Test that handleRequest() works correctly with a controller name as string.
     *
     * @covers Lunr\Corona\RequestResultHandler::handleRequest
     */
    public function testHandleRequestWithControllerAsString(): void
    {
        $controller = 'Lunr\Corona\Tests\MockController';

        $this->request->expects($this->exactly(1))
                      ->method('__get')
                      ->with('call')
                      ->willReturn('controller/method');

        $this->response->expects($this->exactly(1))
                       ->method('getResultCode')
                       ->willReturn(NULL);

        $this->response->expects($this->exactly(1))
                       ->method('setResultCode')
                       ->with('controller/method', 200);

        $this->class->handleRequest([ $controller, 'bar' ], [ 1, 2 ]);
    }

    /**
     * Test handleRequest() with an HttpException.
     *
     * @covers Lunr\Corona\RequestResultHandler::handleRequest
     */
    public function testHandleRequestWithHttpException(): void
    {
        $controller = $this->getMockBuilder('Lunr\Corona\Tests\MockController')
                           ->disableOriginalConstructor()
                           ->getMock();

        $controller->expects($this->once())
                   ->method('foo')
                   ->will($this->throwException(new BadRequestException('Bad Request!')));

        $this->request->expects($this->exactly(3))
                      ->method('__get')
                      ->with('call')
                      ->willReturn('controller/method');

        $this->response->expects($this->exactly(1))
                       ->method('setResultCode')
                       ->with('controller/method', 400);

        $this->response->expects($this->exactly(1))
                       ->method('getResultCode')
                       ->willReturn(400);

        $message = 'Bad Request!';

        $this->response->expects($this->once())
                       ->method('setResultMessage')
                       ->with('controller/method', $message);

        $this->class->handleRequest([ $controller, 'foo' ], []);
    }

    /**
     * Test handleRequest() with an Exception.
     *
     * @covers Lunr\Corona\RequestResultHandler::handleRequest
     */
    public function testHandleRequestWithException(): void
    {
        $exception = new Exception('Error!');

        $controller = $this->getMockBuilder('Lunr\Corona\Tests\MockController')
                           ->disableOriginalConstructor()
                           ->getMock();

        $controller->expects($this->once())
                   ->method('foo')
                   ->will($this->throwException($exception));

        $this->request->expects($this->exactly(2))
                      ->method('__get')
                      ->with('call')
                      ->willReturn('controller/method');

        $this->response->expects($this->exactly(1))
                       ->method('setResultCode')
                       ->with('controller/method', 500);

        $this->response->expects($this->exactly(1))
                       ->method('getResultCode')
                       ->willReturn(500);

        $message = 'Error!';

        $this->response->expects($this->once())
                       ->method('setResultMessage')
                       ->with('controller/method', $message);

        $this->logger->expects($this->once())
                     ->method('error')
                     ->with($message, [ 'exception' => $exception ]);

        $this->class->handleRequest([ $controller, 'foo' ], []);
    }

    /**
     * Test handleRequest() with an Error.
     *
     * @covers Lunr\Corona\RequestResultHandler::handleRequest
     */
    public function testHandleRequestWithError(): void
    {
        $exception = new Error('Fatal Error!');

        $controller = $this->getMockBuilder('Lunr\Corona\Tests\MockController')
                           ->disableOriginalConstructor()
                           ->getMock();

        $controller->expects($this->once())
                   ->method('foo')
                   ->will($this->throwException($exception));

        $this->request->expects($this->exactly(2))
                      ->method('__get')
                      ->with('call')
                      ->willReturn('controller/method');

        $this->response->expects($this->exactly(1))
                       ->method('setResultCode')
                       ->with('controller/method', 500);

        $this->response->expects($this->exactly(1))
                       ->method('getResultCode')
                       ->willReturn(500);

        $message = 'Fatal Error!';

        $this->response->expects($this->once())
                       ->method('setResultMessage')
                       ->with('controller/method', $message);

        $this->logger->expects($this->once())
                     ->method('error')
                     ->with($message, [ 'exception' => $exception ]);

        $this->class->handleRequest([ $controller, 'foo' ], []);
    }

    /**
     * Test handleRequest() when the request was successful.
     *
     * @covers Lunr\Corona\RequestResultHandler::handleRequest
     */
    public function testHandleRequestWithSuccess(): void
    {
        $controller = $this->getMockBuilder('Lunr\Corona\Tests\MockController')
                           ->disableOriginalConstructor()
                           ->getMock();

        $controller->expects($this->once())
                   ->method('foo');

        $this->request->expects($this->exactly(1))
                      ->method('__get')
                      ->with('call')
                      ->willReturn('controller/method');

        $this->response->expects($this->exactly(1))
                       ->method('getResultCode')
                       ->willReturn(NULL);

        $this->response->expects($this->exactly(1))
                       ->method('setResultCode')
                       ->with('controller/method', 200);

        $this->response->expects($this->never())
                       ->method('setResultMessage');

        $this->class->handleRequest([ $controller, 'foo' ], []);
    }

    /**
     * Test that handleRequest works correctly with an already instantiated controller.
     *
     * @covers Lunr\Corona\RequestResultHandler::handle_request
     */
    public function testDeprecatedHandleRequestWithInstantiatedController(): void
    {
        $controller = $this->getMockBuilder('Lunr\Corona\Tests\MockController')
                           ->disableOriginalConstructor()
                           ->getMock();

        $this->request->expects($this->exactly(1))
                      ->method('__get')
                      ->with('call')
                      ->willReturn('controller/method');

        $this->response->expects($this->exactly(1))
                       ->method('getResultCode')
                       ->willReturn(NULL);

        $this->response->expects($this->exactly(1))
                       ->method('setResultCode')
                       ->with('controller/method', 200);

        $controller->expects($this->once())
                   ->method('foo')
                   ->with(1, 2);

        $this->class->handle_request([ $controller, 'foo' ], [ 1, 2 ]);
    }

    /**
     * Test that handle_request works correctly with a controller name as string.
     *
     * @covers Lunr\Corona\RequestResultHandler::handle_request
     */
    public function testDeprecatedHandleRequestWithControllerAsString(): void
    {
        $controller = 'Lunr\Corona\Tests\MockController';

        $this->request->expects($this->exactly(1))
                      ->method('__get')
                      ->with('call')
                      ->willReturn('controller/method');

        $this->response->expects($this->exactly(1))
                       ->method('getResultCode')
                       ->willReturn(NULL);

        $this->response->expects($this->exactly(1))
                       ->method('setResultCode')
                       ->with('controller/method', 200);

        $this->class->handle_request([ $controller, 'bar' ], [ 1, 2 ]);
    }

    /**
     * Test handle_request() with an HttpException.
     *
     * @covers Lunr\Corona\RequestResultHandler::handle_request
     */
    public function testDeprecatedHandleRequestWithHttpException(): void
    {
        $controller = $this->getMockBuilder('Lunr\Corona\Tests\MockController')
                           ->disableOriginalConstructor()
                           ->getMock();

        $controller->expects($this->once())
                   ->method('foo')
                   ->will($this->throwException(new BadRequestException('Bad Request!')));

        $this->request->expects($this->exactly(3))
                      ->method('__get')
                      ->with('call')
                      ->willReturn('controller/method');

        $this->response->expects($this->exactly(1))
                       ->method('setResultCode')
                       ->with('controller/method', 400);

        $this->response->expects($this->exactly(1))
                       ->method('getResultCode')
                       ->willReturn(400);

        $message = 'Bad Request!';

        $this->response->expects($this->once())
                       ->method('setResultMessage')
                       ->with('controller/method', $message);

        $this->class->handle_request([ $controller, 'foo' ], []);
    }

    /**
     * Test handle_request() with an Exception.
     *
     * @covers Lunr\Corona\RequestResultHandler::handle_request
     */
    public function testDeprecatedHandleRequestWithException(): void
    {
        $exception = new Exception('Error!');

        $controller = $this->getMockBuilder('Lunr\Corona\Tests\MockController')
                           ->disableOriginalConstructor()
                           ->getMock();

        $controller->expects($this->once())
                   ->method('foo')
                   ->will($this->throwException($exception));

        $this->request->expects($this->exactly(2))
                      ->method('__get')
                      ->with('call')
                      ->willReturn('controller/method');

        $this->response->expects($this->exactly(1))
                       ->method('setResultCode')
                       ->with('controller/method', 500);

        $this->response->expects($this->exactly(1))
                       ->method('getResultCode')
                       ->willReturn(500);

        $message = 'Error!';

        $this->response->expects($this->once())
                       ->method('setResultMessage')
                       ->with('controller/method', $message);

        $this->logger->expects($this->once())
                     ->method('error')
                     ->with($message, [ 'exception' => $exception ]);

        $this->class->handle_request([ $controller, 'foo' ], []);
    }

    /**
     * Test handle_request() with an Error.
     *
     * @covers Lunr\Corona\RequestResultHandler::handle_request
     */
    public function testDeprecatedHandleRequestWithError(): void
    {
        $exception = new Error('Fatal Error!');

        $controller = $this->getMockBuilder('Lunr\Corona\Tests\MockController')
                           ->disableOriginalConstructor()
                           ->getMock();

        $controller->expects($this->once())
                   ->method('foo')
                   ->will($this->throwException($exception));

        $this->request->expects($this->exactly(2))
                      ->method('__get')
                      ->with('call')
                      ->willReturn('controller/method');

        $this->response->expects($this->exactly(1))
                       ->method('setResultCode')
                       ->with('controller/method', 500);

        $this->response->expects($this->exactly(1))
                       ->method('getResultCode')
                       ->willReturn(500);

        $message = 'Fatal Error!';

        $this->response->expects($this->once())
                       ->method('setResultMessage')
                       ->with('controller/method', $message);

        $this->logger->expects($this->once())
                     ->method('error')
                     ->with($message, [ 'exception' => $exception ]);

        $this->class->handle_request([ $controller, 'foo' ], []);
    }

    /**
     * Test handle_request() when the request was successful.
     *
     * @covers Lunr\Corona\RequestResultHandler::handle_request
     */
    public function testDeprecatedHandleRequestWithSuccess(): void
    {
        $controller = $this->getMockBuilder('Lunr\Corona\Tests\MockController')
                           ->disableOriginalConstructor()
                           ->getMock();

        $controller->expects($this->once())
                   ->method('foo');

        $this->request->expects($this->exactly(1))
                      ->method('__get')
                      ->with('call')
                      ->willReturn('controller/method');

        $this->response->expects($this->exactly(1))
                       ->method('getResultCode')
                       ->willReturn(NULL);

        $this->response->expects($this->exactly(1))
                       ->method('setResultCode')
                       ->with('controller/method', 200);

        $this->response->expects($this->never())
                       ->method('setResultMessage');

        $this->class->handle_request([ $controller, 'foo' ], []);
    }

}

?>
