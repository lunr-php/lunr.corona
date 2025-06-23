<?php

/**
 * This file contains the RequestResultHandlerLogRequestResultTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2025 Framna Netherlands B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Corona\Tests;

use Lunr\Corona\Exceptions\BadRequestException;
use Lunr\Corona\Exceptions\ConflictException;
use Lunr\Corona\HttpCode;
use Lunr\Corona\Parsers\Client\ClientValue;
use Lunr\Corona\Parsers\Client\Tests\Helpers\MockClientEnum;
use RuntimeException;

/**
 * This class contains test methods for the RequestResultHandler class.
 *
 * @covers Lunr\Corona\RequestResultHandler
 */
class RequestResultHandlerLogRequestResultTest extends RequestResultHandlerTestCase
{

    /**
     * Test that logRequestResult() does not log anything if there's no registered mapping for the result code.
     *
     * @covers Lunr\Corona\RequestResultHandler::logRequestResult
     */
    public function testLogRequestResultWithMissingCodeMapSkipsLogging(): void
    {
        $exception = new ConflictException('Conflict!');

        $this->eventLogger->expects($this->never())
                          ->method('newEvent');

        $method = $this->getReflectionMethod('logRequestResult');

        $method->invokeArgs($this->class, [ $exception ]);
    }

    /**
     * Test that logRequestResult() logs HttpExceptions.
     *
     * @covers Lunr\Corona\RequestResultHandler::logRequestResult
     */
    public function testLogRequestResultWhenTraceIDIsUnavailable(): void
    {
        $this->setReflectionPropertyValue('codeMap', [ HttpCode::CONFLICT => 'conflict_requests_log' ]);
        $this->setReflectionPropertyValue('tagMap', []);
        $this->setReflectionPropertyValue('eventLogger', $this->eventLogger);

        $exception = new ConflictException('Conflict!');

        $this->request->expects($this->once())
                      ->method('getTraceId')
                      ->willReturn(NULL);

        $this->request->expects($this->never())
                      ->method('getSpanId');

        $this->request->expects($this->never())
                      ->method('getParentSpanId');

        $this->request->expects($this->never())
                      ->method('getSpanSpecificTags');

        $this->eventLogger->expects($this->once())
                          ->method('newEvent')
                          ->with('conflict_requests_log')
                          ->willReturn($this->event);

        $this->event->expects($this->once())
                    ->method('recordTimestamp');

        $this->event->expects($this->never())
                    ->method('setTraceId');

        $this->event->expects($this->never())
                    ->method('setSpanId');

        $this->event->expects($this->never())
                    ->method('setParentSpanId');

        $this->event->expects($this->never())
                    ->method('addTags');

        $this->event->expects($this->never())
                    ->method('addFields');

        $this->event->expects($this->never())
                    ->method('record');

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Trace ID not available!');

        $method = $this->getReflectionMethod('logRequestResult');

        $method->invokeArgs($this->class, [ $exception ]);
    }

    /**
     * Test that logRequestResult() logs HttpExceptions.
     *
     * @covers Lunr\Corona\RequestResultHandler::logRequestResult
     */
    public function testLogRequestResultWhenSpanIDIsUnavailable(): void
    {
        $this->setReflectionPropertyValue('codeMap', [ HttpCode::CONFLICT => 'conflict_requests_log' ]);
        $this->setReflectionPropertyValue('tagMap', []);
        $this->setReflectionPropertyValue('eventLogger', $this->eventLogger);

        $traceID = '7b333e15-aa78-4957-a402-731aecbb358e';

        $exception = new ConflictException('Conflict!');

        $this->request->expects($this->once())
                      ->method('getTraceId')
                      ->willReturn($traceID);

        $this->request->expects($this->once())
                      ->method('getSpanId')
                      ->willReturn(NULL);

        $this->request->expects($this->never())
                      ->method('getParentSpanId');

        $this->request->expects($this->never())
                      ->method('getSpanSpecificTags');

        $this->eventLogger->expects($this->once())
                          ->method('newEvent')
                          ->with('conflict_requests_log')
                          ->willReturn($this->event);

        $this->event->expects($this->once())
                    ->method('recordTimestamp');

        $this->event->expects($this->once())
                    ->method('setTraceId')
                    ->with($traceID);

        $this->event->expects($this->never())
                    ->method('setSpanId');

        $this->event->expects($this->never())
                    ->method('setParentSpanId');

        $this->event->expects($this->never())
                    ->method('addTags');

        $this->event->expects($this->never())
                    ->method('addFields');

        $this->event->expects($this->never())
                    ->method('record');

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Span ID not available!');

        $method = $this->getReflectionMethod('logRequestResult');

        $method->invokeArgs($this->class, [ $exception ]);
    }

    /**
     * Test that logRequestResult() logs HttpExceptions.
     *
     * @covers Lunr\Corona\RequestResultHandler::logRequestResult
     */
    public function testLogRequestResultWhenParentSpanIDIsUnavailable(): void
    {
        $this->setReflectionPropertyValue('codeMap', [ HttpCode::CONFLICT => 'conflict_requests_log' ]);
        $this->setReflectionPropertyValue('tagMap', []);
        $this->setReflectionPropertyValue('eventLogger', $this->eventLogger);

        $traceID = '7b333e15-aa78-4957-a402-731aecbb358e';
        $spanID  = '24ec5f90-7458-4dd5-bb51-7a1e8f4baafe';

        $exception = new ConflictException('Conflict!');

        $this->request->expects($this->once())
                      ->method('getTraceId')
                      ->willReturn($traceID);

        $this->request->expects($this->once())
                      ->method('getSpanId')
                      ->willReturn($spanID);

        $this->request->expects($this->once())
                      ->method('getParentSpanId')
                      ->willReturn(NULL);

        $this->request->expects($this->once())
                      ->method('getSpanSpecificTags')
                      ->willReturn([ 'call' => 'controller/method' ]);

        $this->eventLogger->expects($this->once())
                          ->method('newEvent')
                          ->with('conflict_requests_log')
                          ->willReturn($this->event);

        $this->event->expects($this->once())
                    ->method('recordTimestamp');

        $this->event->expects($this->once())
                    ->method('setTraceId')
                    ->with($traceID);

        $this->event->expects($this->once())
                    ->method('setSpanId')
                    ->with($spanID);

        $this->event->expects($this->never())
                    ->method('setParentSpanId');

        $tags = [
            'call' => 'controller/method',
        ];

        $this->event->expects($this->once())
                    ->method('addTags')
                    ->with($tags);

        $fields = [
            'message' => 'Conflict!',
        ];

        $this->event->expects($this->once())
                    ->method('addFields')
                    ->with($fields);

        $this->event->expects($this->once())
                    ->method('record');

        $method = $this->getReflectionMethod('logRequestResult');

        $method->invokeArgs($this->class, [ $exception ]);
    }

    /**
     * Test that logRequestResult() logs HttpExceptions.
     *
     * @covers Lunr\Corona\RequestResultHandler::logRequestResult
     */
    public function testLogRequestResultWithHttpException(): void
    {
        $this->setReflectionPropertyValue('codeMap', [ HttpCode::CONFLICT => 'conflict_requests_log' ]);
        $this->setReflectionPropertyValue('tagMap', []);
        $this->setReflectionPropertyValue('eventLogger', $this->eventLogger);

        $traceID      = '7b333e15-aa78-4957-a402-731aecbb358e';
        $spanID       = '24ec5f90-7458-4dd5-bb51-7a1e8f4baafe';
        $parentSpanID = '8b1f87b5-8383-4413-a341-7619cd4b9948';

        $exception = new ConflictException('Conflict!');

        $this->request->expects($this->once())
                      ->method('getTraceId')
                      ->willReturn($traceID);

        $this->request->expects($this->once())
                      ->method('getSpanId')
                      ->willReturn($spanID);

        $this->request->expects($this->once())
                      ->method('getParentSpanId')
                      ->willReturn($parentSpanID);

        $this->request->expects($this->once())
                      ->method('getSpanSpecificTags')
                      ->willReturn([ 'call' => 'controller/method' ]);

        $this->eventLogger->expects($this->once())
                          ->method('newEvent')
                          ->with('conflict_requests_log')
                          ->willReturn($this->event);

        $this->event->expects($this->once())
                    ->method('recordTimestamp');

        $this->event->expects($this->once())
                    ->method('setTraceId')
                    ->with($traceID);

        $this->event->expects($this->once())
                    ->method('setSpanId')
                    ->with($spanID);

        $this->event->expects($this->once())
                    ->method('setParentSpanId')
                    ->with($parentSpanID);

        $tags = [
            'call' => 'controller/method',
        ];

        $this->event->expects($this->once())
                    ->method('addTags')
                    ->with($tags);

        $fields = [
            'message' => 'Conflict!',
        ];

        $this->event->expects($this->once())
                    ->method('addFields')
                    ->with($fields);

        $this->event->expects($this->once())
                    ->method('record');

        $method = $this->getReflectionMethod('logRequestResult');

        $method->invokeArgs($this->class, [ $exception ]);
    }

    /**
     * Test that logRequestResult() logs HttpExceptions.
     *
     * @covers Lunr\Corona\RequestResultHandler::logRequestResult
     */
    public function testLogRequestResultWithHttpExceptionAndCustomTags(): void
    {
        $this->setReflectionPropertyValue('codeMap', [ HttpCode::CONFLICT => 'conflict_requests_log' ]);
        $this->setReflectionPropertyValue('tagMap', [ 'client' => ClientValue::Client ]);
        $this->setReflectionPropertyValue('eventLogger', $this->eventLogger);

        $traceID      = '7b333e15-aa78-4957-a402-731aecbb358e';
        $spanID       = '24ec5f90-7458-4dd5-bb51-7a1e8f4baafe';
        $parentSpanID = '8b1f87b5-8383-4413-a341-7619cd4b9948';

        $exception = new ConflictException('Conflict!');

        $this->request->expects($this->once())
                      ->method('getTraceId')
                      ->willReturn($traceID);

        $this->request->expects($this->once())
                      ->method('getSpanId')
                      ->willReturn($spanID);

        $this->request->expects($this->once())
                      ->method('getParentSpanId')
                      ->willReturn($parentSpanID);

        $this->request->expects($this->once())
                      ->method('getSpanSpecificTags')
                      ->willReturn([ 'call' => 'controller/method' ]);

        $this->request->expects($this->once())
                      ->method('get')
                      ->with(ClientValue::Client)
                      ->willReturn(MockClientEnum::CommandLine->value);

        $this->eventLogger->expects($this->once())
                          ->method('newEvent')
                          ->with('conflict_requests_log')
                          ->willReturn($this->event);

        $this->event->expects($this->once())
                    ->method('recordTimestamp');

        $this->event->expects($this->once())
                    ->method('setTraceId')
                    ->with($traceID);

        $this->event->expects($this->once())
                    ->method('setSpanId')
                    ->with($spanID);

        $this->event->expects($this->once())
                    ->method('setParentSpanId')
                    ->with($parentSpanID);

        $tags = [
            'call'   => 'controller/method',
            'client' => 'Command Line',
        ];

        $this->event->expects($this->once())
                    ->method('addTags')
                    ->with($tags);

        $fields = [
            'message' => 'Conflict!',
        ];

        $this->event->expects($this->once())
                    ->method('addFields')
                    ->with($fields);

        $this->event->expects($this->once())
                    ->method('record');

        $method = $this->getReflectionMethod('logRequestResult');

        $method->invokeArgs($this->class, [ $exception ]);
    }

    /**
     * Test that logRequestResult() logs ClientDataHttpExceptions.
     *
     * @covers Lunr\Corona\RequestResultHandler::logRequestResult
     */
    public function testLogRequestResultWithClientDataHttpException(): void
    {
        $this->setReflectionPropertyValue('codeMap', [ HttpCode::BAD_REQUEST => 'bad_requests_log' ]);
        $this->setReflectionPropertyValue('tagMap', []);
        $this->setReflectionPropertyValue('eventLogger', $this->eventLogger);

        $traceID      = '7b333e15-aa78-4957-a402-731aecbb358e';
        $spanID       = '24ec5f90-7458-4dd5-bb51-7a1e8f4baafe';
        $parentSpanID = '8b1f87b5-8383-4413-a341-7619cd4b9948';

        $exception = new BadRequestException('Bad Request!');

        $exception->setData('input-key', 'bad-value');

        $this->request->expects($this->once())
                      ->method('getTraceId')
                      ->willReturn($traceID);

        $this->request->expects($this->once())
                      ->method('getSpanId')
                      ->willReturn($spanID);

        $this->request->expects($this->once())
                      ->method('getParentSpanId')
                      ->willReturn($parentSpanID);

        $this->request->expects($this->once())
                      ->method('getSpanSpecificTags')
                      ->willReturn([ 'call' => 'controller/method' ]);

        $this->eventLogger->expects($this->once())
                          ->method('newEvent')
                          ->willReturn($this->event);

        $this->event->expects($this->once())
                    ->method('recordTimestamp');

        $this->event->expects($this->once())
                    ->method('setTraceId')
                    ->with($traceID);

        $this->event->expects($this->once())
                    ->method('setSpanId')
                    ->with($spanID);

        $this->event->expects($this->once())
                    ->method('setParentSpanId')
                    ->with($parentSpanID);

        $tags = [
            'call'     => 'controller/method',
            'inputKey' => 'input-key',
        ];

        $this->event->expects($this->once())
                    ->method('addTags')
                    ->with($tags);

        $fields = [
            'message'    => 'Bad Request!',
            'inputValue' => 'bad-value'
        ];

        $this->event->expects($this->once())
                    ->method('addFields')
                    ->with($fields);

        $this->event->expects($this->once())
                    ->method('record');

        $method = $this->getReflectionMethod('logRequestResult');

        $method->invokeArgs($this->class, [ $exception ]);
    }

    /**
     * Test that logRequestResult() logs ClientDataHttpExceptions.
     *
     * @covers Lunr\Corona\RequestResultHandler::logRequestResult
     */
    public function testLogRequestResultWithClientDataHttpExceptionAndReport(): void
    {
        $this->setReflectionPropertyValue('codeMap', [ HttpCode::BAD_REQUEST => 'bad_requests_log' ]);
        $this->setReflectionPropertyValue('tagMap', []);
        $this->setReflectionPropertyValue('eventLogger', $this->eventLogger);

        $traceID      = '7b333e15-aa78-4957-a402-731aecbb358e';
        $spanID       = '24ec5f90-7458-4dd5-bb51-7a1e8f4baafe';
        $parentSpanID = '8b1f87b5-8383-4413-a341-7619cd4b9948';

        $exception = new BadRequestException('Bad Request!');

        $exception->setReport('input-key: bad-value');

        $this->request->expects($this->once())
                      ->method('getTraceId')
                      ->willReturn($traceID);

        $this->request->expects($this->once())
                      ->method('getSpanId')
                      ->willReturn($spanID);

        $this->request->expects($this->once())
                      ->method('getParentSpanId')
                      ->willReturn($parentSpanID);

        $this->request->expects($this->once())
                      ->method('getSpanSpecificTags')
                      ->willReturn([ 'call' => 'controller/method' ]);

        $this->eventLogger->expects($this->once())
                          ->method('newEvent')
                          ->willReturn($this->event);

        $this->event->expects($this->once())
                    ->method('recordTimestamp');

        $this->event->expects($this->once())
                    ->method('setTraceId')
                    ->with($traceID);

        $this->event->expects($this->once())
                    ->method('setSpanId')
                    ->with($spanID);

        $this->event->expects($this->once())
                    ->method('setParentSpanId')
                    ->with($parentSpanID);

        $tags = [
            'call' => 'controller/method',
        ];

        $this->event->expects($this->once())
                    ->method('addTags')
                    ->with($tags);

        $fields = [
            'message' => 'Bad Request!',
            'report'  => 'input-key: bad-value'
        ];

        $this->event->expects($this->once())
                    ->method('addFields')
                    ->with($fields);

        $this->event->expects($this->once())
                    ->method('record');

        $method = $this->getReflectionMethod('logRequestResult');

        $method->invokeArgs($this->class, [ $exception ]);
    }

    /**
     * Test that logRequestResult() logs ClientDataHttpExceptions.
     *
     * @covers Lunr\Corona\RequestResultHandler::logRequestResult
     */
    public function testLogRequestResultWithClientDataHttpExceptionAndCustomTags(): void
    {
        $this->setReflectionPropertyValue('codeMap', [ HttpCode::BAD_REQUEST => 'bad_requests_log' ]);
        $this->setReflectionPropertyValue('tagMap', [ 'client' => ClientValue::Client ]);
        $this->setReflectionPropertyValue('eventLogger', $this->eventLogger);

        $traceID      = '7b333e15-aa78-4957-a402-731aecbb358e';
        $spanID       = '24ec5f90-7458-4dd5-bb51-7a1e8f4baafe';
        $parentSpanID = '8b1f87b5-8383-4413-a341-7619cd4b9948';

        $exception = new BadRequestException('Bad Request!');

        $exception->setData('input-key', 'bad-value');

        $this->request->expects($this->once())
                      ->method('getTraceId')
                      ->willReturn($traceID);

        $this->request->expects($this->once())
                      ->method('getSpanId')
                      ->willReturn($spanID);

        $this->request->expects($this->once())
                      ->method('getParentSpanId')
                      ->willReturn($parentSpanID);

        $this->request->expects($this->once())
                      ->method('getSpanSpecificTags')
                      ->willReturn([ 'call' => 'controller/method' ]);

        $this->request->expects($this->once())
                      ->method('get')
                      ->with(ClientValue::Client)
                      ->willReturn(MockClientEnum::CommandLine->value);

        $this->eventLogger->expects($this->once())
                          ->method('newEvent')
                          ->willReturn($this->event);

        $this->event->expects($this->once())
                    ->method('recordTimestamp');

        $this->event->expects($this->once())
                    ->method('setTraceId')
                    ->with($traceID);

        $this->event->expects($this->once())
                    ->method('setSpanId')
                    ->with($spanID);

        $this->event->expects($this->once())
                    ->method('setParentSpanId')
                    ->with($parentSpanID);

        $tags = [
            'call'     => 'controller/method',
            'client'   => 'Command Line',
            'inputKey' => 'input-key',
        ];

        $this->event->expects($this->once())
                    ->method('addTags')
                    ->with($tags);

        $fields = [
            'message'    => 'Bad Request!',
            'inputValue' => 'bad-value'
        ];

        $this->event->expects($this->once())
                    ->method('addFields')
                    ->with($fields);

        $this->event->expects($this->once())
                    ->method('record');

        $method = $this->getReflectionMethod('logRequestResult');

        $method->invokeArgs($this->class, [ $exception ]);
    }

}

?>
