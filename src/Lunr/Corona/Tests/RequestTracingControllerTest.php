<?php

/**
 * This file contains the RequestTracingControllerTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2025 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Corona\Tests;

use Lunr\Corona\Parsers\TracingInfo\TracingInfoValue;
use Lunr\Corona\Request;
use Lunr\Corona\RequestParserInterface;
use Lunr\Corona\RequestValueParserInterface;

/**
 * Tests for getAsEnumting request values.
 *
 * @covers Lunr\Corona\Request
 */
class RequestTracingControllerTest extends RequestTestCase
{

    /**
     * Check that startChildSpan() starts a new span.
     *
     * @covers Lunr\Corona\Request::startChildSpan
     */
    public function testStartChildSpanWithExistingMock(): void
    {
        $parser = $this->getMockBuilder(RequestValueParserInterface::class)
                       ->getMock();

        $parsers = [
            TracingInfoValue::class => $parser,
        ];

        $this->setReflectionPropertyValue('parsers', $parsers);

        $mock = [
            [
                'controller' => 'test',
            ],
        ];

        $this->setReflectionPropertyValue('mock', $mock);

        $id = '1bee74f0-5f21-4b7f-9fff-62e7320e9aa5';

        $parser->expects($this->once())
               ->method('get')
               ->with(TracingInfoValue::SpanID)
               ->willReturn($id);

        $this->mockFunction('uuid_create', fn() => '200c5938-cbe1-4b58-ad36-022ab5c6bcc6');

        $this->class->startChildSpan();

        $expected = [
            [
                TracingInfoValue::ParentSpanID->value => '1bee74f0-5f21-4b7f-9fff-62e7320e9aa5',
                TracingInfoValue::SpanID->value       => '200c5938cbe14b58ad36022ab5c6bcc6',
                'controller'                          => 'test',
            ],
            [
                'controller' => 'test',
            ],
        ];

        $this->assertPropertyEquals('mock', $expected);

        $this->unmockFunction('uuid_create');
    }

    /**
     * Check that startChildSpan() starts a new span.
     *
     * @covers Lunr\Corona\Request::startChildSpan
     */
    public function testStartChildSpan(): void
    {
        $parser = $this->getMockBuilder(RequestValueParserInterface::class)
                       ->getMock();

        $parsers = [
            TracingInfoValue::class => $parser,
        ];

        $this->setReflectionPropertyValue('parsers', $parsers);

        $id = '1bee74f0-5f21-4b7f-9fff-62e7320e9aa5';

        $parser->expects($this->once())
               ->method('get')
               ->with(TracingInfoValue::SpanID)
               ->willReturn($id);

        $this->mockFunction('uuid_create', fn() => '200c5938-cbe1-4b58-ad36-022ab5c6bcc6');

        $this->class->startChildSpan();

        $expected = [
            [
                TracingInfoValue::ParentSpanID->value => '1bee74f0-5f21-4b7f-9fff-62e7320e9aa5',
                TracingInfoValue::SpanID->value       => '200c5938cbe14b58ad36022ab5c6bcc6',
            ],
        ];

        $this->assertPropertyEquals('mock', $expected);

        $this->unmockFunction('uuid_create');
    }

    /**
     * Check that startChildSpan() starts a new span.
     *
     * @covers Lunr\Corona\Request::startChildSpan
     */
    public function testStartChildSpanWithRealUuidValue(): void
    {
        $parser = $this->getMockBuilder(RequestParserInterface::class)->getMock();

        $parser->expects($this->once())
               ->method('parse_request')
               ->willReturn([]);

        $parser->expects($this->once())
               ->method('parse_post')
               ->willReturn([]);

        $parser->expects($this->once())
               ->method('parse_get')
               ->willReturn([]);

        $parser->expects($this->once())
               ->method('parse_cookie')
               ->willReturn([]);

        $parser->expects($this->once())
               ->method('parse_server')
               ->willReturn([]);

        $parser->expects($this->once())
               ->method('parse_files')
               ->willReturn([]);

        $parser->expects($this->once())
               ->method('parse_command_line_arguments')
               ->willReturn([]);

        $class = new Request($parser, uuidAsHexString: FALSE);

        $parser = $this->getMockBuilder(RequestValueParserInterface::class)
                       ->getMock();

        $parsers = [
            TracingInfoValue::class => $parser,
        ];

        $this->getReflectionProperty('parsers')->setValue($class, $parsers);

        $id = '1bee74f0-5f21-4b7f-9fff-62e7320e9aa5';

        $parser->expects($this->once())
               ->method('get')
               ->with(TracingInfoValue::SpanID)
               ->willReturn($id);

        $this->mockFunction('uuid_create', fn() => '200c5938-cbe1-4b58-ad36-022ab5c6bcc6');

        $class->startChildSpan();

        $expected = [
            [
                TracingInfoValue::ParentSpanID->value => '1bee74f0-5f21-4b7f-9fff-62e7320e9aa5',
                TracingInfoValue::SpanID->value       => '200c5938-cbe1-4b58-ad36-022ab5c6bcc6',
            ],
        ];

        $value = $this->getReflectionProperty('mock')->getValue($class);

        $this->assertEquals($expected, $value);

        $this->unmockFunction('uuid_create');
    }

    /**
     * Check that stopChildSpan() stops the current span.
     *
     * @covers Lunr\Corona\Request::stopChildSpan
     */
    public function testStopChildSpanWithSingleMock(): void
    {
        $mock = [
            [
                TracingInfoValue::ParentSpanID->value => '1bee74f0-5f21-4b7f-9fff-62e7320e9aa5',
                TracingInfoValue::SpanID->value       => '200c5938cbe14b58ad36022ab5c6bcc6',
                'controller'                          => 'test',
            ],
        ];

        $this->setReflectionPropertyValue('mock', $mock);

        $this->class->stopChildSpan();

        $expected = [];

        $this->assertPropertyEquals('mock', $expected);
    }

    /**
     * Check that stopChildSpan() stops the current span.
     *
     * @covers Lunr\Corona\Request::stopChildSpan
     */
    public function testStopChildSpanWithMultipleMocks(): void
    {
        $mock = [
            [
                TracingInfoValue::ParentSpanID->value => '1bee74f0-5f21-4b7f-9fff-62e7320e9aa5',
                TracingInfoValue::SpanID->value       => '200c5938cbe14b58ad36022ab5c6bcc6',
                'controller'                          => 'test',
            ],
            [
                'controller' => 'test',
            ],
        ];

        $this->setReflectionPropertyValue('mock', $mock);

        $this->class->stopChildSpan();

        $expected = [
            [
                'controller' => 'test',
            ],
        ];

        $this->assertPropertyEquals('mock', $expected);
    }

    /**
     * Check that stopChildSpan() stops the current span.
     *
     * @covers Lunr\Corona\Request::stopChildSpan
     */
    public function testStopChildSpanWithNoMock(): void
    {
        $mock = [];

        $this->setReflectionPropertyValue('mock', $mock);

        $this->class->stopChildSpan();

        $this->assertPropertyEquals('mock', $mock);
    }

    /**
     * Test that getNewSpanId() returns a hex-only ID.
     *
     * @covers Lunr\Corona\Request::getNewSpanId
     */
    public function testGetNewHexOnlySpanId(): void
    {
        $this->mockFunction('uuid_create', fn() => '200c5938-cbe1-4b58-ad36-022ab5c6bcc6');

        $value = $this->class->getNewSpanId();

        $this->assertEquals('200c5938cbe14b58ad36022ab5c6bcc6', $value);

        $this->unmockFunction('uuid_create');
    }

    /**
     * Test that getNewSpanId() returns a canonical ID.
     *
     * @covers Lunr\Corona\Request::getNewSpanId
     */
    public function testGetNewCanonicalSpanId(): void
    {
        $parser = $this->getMockBuilder(RequestParserInterface::class)->getMock();

        $parser->expects($this->once())
               ->method('parse_request')
               ->willReturn([]);

        $parser->expects($this->once())
               ->method('parse_post')
               ->willReturn([]);

        $parser->expects($this->once())
               ->method('parse_get')
               ->willReturn([]);

        $parser->expects($this->once())
               ->method('parse_cookie')
               ->willReturn([]);

        $parser->expects($this->once())
               ->method('parse_server')
               ->willReturn([]);

        $parser->expects($this->once())
               ->method('parse_files')
               ->willReturn([]);

        $parser->expects($this->once())
               ->method('parse_command_line_arguments')
               ->willReturn([]);

        $class = new Request($parser, uuidAsHexString: FALSE);

        $this->mockFunction('uuid_create', fn() => '200c5938-cbe1-4b58-ad36-022ab5c6bcc6');

        $value = $class->getNewSpanId();

        $this->assertEquals('200c5938-cbe1-4b58-ad36-022ab5c6bcc6', $value);

        $this->unmockFunction('uuid_create');
    }

    /**
     * Test that isValidSpanId() checks correctly when class is set to hex only.
     *
     * @covers Lunr\Corona\Request::isValidSpanId
     */
    public function testIsValidSpanIdWhenHexOnly(): void
    {
        $this->assertTrue($this->class->isValidSpanId('200c5938cbe14b58ad36022ab5c6bcc6'));
        $this->assertFalse($this->class->isValidSpanId('200c5938-cbe1-4b58-ad36-022ab5c6bcc6'));
    }

    /**
     * Test that isValidSpanId() checks correctly when class is set to canonical.
     *
     * @covers Lunr\Corona\Request::isValidSpanId
     */
    public function testIsValidSpanIdWhenCanonical(): void
    {
        $parser = $this->getMockBuilder(RequestParserInterface::class)->getMock();

        $parser->expects($this->once())
               ->method('parse_request')
               ->willReturn([]);

        $parser->expects($this->once())
               ->method('parse_post')
               ->willReturn([]);

        $parser->expects($this->once())
               ->method('parse_get')
               ->willReturn([]);

        $parser->expects($this->once())
               ->method('parse_cookie')
               ->willReturn([]);

        $parser->expects($this->once())
               ->method('parse_server')
               ->willReturn([]);

        $parser->expects($this->once())
               ->method('parse_files')
               ->willReturn([]);

        $parser->expects($this->once())
               ->method('parse_command_line_arguments')
               ->willReturn([]);

        $class = new Request($parser, uuidAsHexString: FALSE);

        $this->assertFalse($class->isValidSpanId('200c5938cbe14b58ad36022ab5c6bcc6'));
        $this->assertTrue($class->isValidSpanId('200c5938-cbe1-4b58-ad36-022ab5c6bcc6'));
    }

}

?>
