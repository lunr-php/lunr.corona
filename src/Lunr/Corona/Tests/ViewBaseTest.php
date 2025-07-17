<?php

/**
 * This file contains the ViewBaseTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2012 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Corona\Tests;

use Lunr\Corona\Parsers\TracingInfo\TracingInfoValue;
use Lunr\Corona\View;

/**
 * Base tests for the view class.
 *
 * @covers Lunr\Corona\View
 */
class ViewBaseTest extends ViewTestCase
{

    /**
     * Test that the request class is set correctly.
     */
    public function testRequestSetCorrectly(): void
    {
        $this->assertPropertySame('request', $this->request);
    }

    /**
     * Test that the response class is set correctly.
     */
    public function testResponseSetCorrectly(): void
    {
        $this->assertPropertySame('response', $this->response);
    }

    /**
     * Test that the request ID header is set.
     *
     * @requires extension xdebug
     * @runInSeparateProcess
     */
    public function testRequestIdHeaderIsSet(): void
    {
        if (!headers_sent())
        {
            $this->request->expects($this->once())
                          ->method('get')
                          ->with(TracingInfoValue::TraceID)
                          ->willReturn('962161b27a0141f384c63834ad001adf');
        }

        // Need to instantiate the class to send headers
        $this->getMockBuilder(View::class)
             ->setConstructorArgs(
                [ $this->request, $this->response ]
             )
             ->getMockForAbstractClass();

        $headers = xdebug_get_headers();

        $this->assertIsArray($headers);
        $this->assertNotEmpty($headers);

        $value = strpos($headers[0], 'X-Xdebug-Profile-Filename') !== FALSE ? $headers[1] : $headers[0];

        $this->assertEquals('X-Request-ID: 962161b27a0141f384c63834ad001adf', $value);
    }

    /**
     * Test that the request ID header is not set.
     */
    public function testRequestIdHeaderIsNotSet(): void
    {
        $headers = xdebug_get_headers();

        $this->assertIsArray($headers);

        $this->assertArrayEmpty($headers);
    }

}

?>
