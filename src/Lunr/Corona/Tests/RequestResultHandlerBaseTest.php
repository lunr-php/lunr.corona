<?php

/**
 * This file contains the RequestResultHandlerBaseTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2018 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Corona\Tests;

use Lunr\Corona\HttpCode;
use Lunr\Corona\Parsers\Client\ClientValue;
use Lunr\Halo\PropertyTraits\PsrLoggerTestTrait;

/**
 * This class contains test methods for the RequestResultHandler class.
 *
 * @covers Lunr\Corona\RequestResultHandler
 */
class RequestResultHandlerBaseTest extends RequestResultHandlerTestCase
{

    use PsrLoggerTestTrait;

    /**
     * Test that the Request class was passed correctly.
     */
    public function testRequestPassedCorrectly(): void
    {
        $this->assertPropertySame('request', $this->request);
    }

    /**
     * Test that the Response class was passed correctly.
     */
    public function testResponsePassedCorrectly(): void
    {
        $this->assertPropertySame('response', $this->response);
    }

    /**
     * Test that the code map was initialized correctly.
     */
    public function testCodeMapInitializedCorrectly(): void
    {
        $this->assertPropertySame('codeMap', []);
    }

    /**
     * Test that the tag map was initialized correctly.
     */
    public function testTagMapInitializedCorrectly(): void
    {
        $this->assertPropertySame('tagMap', []);
    }

    /**
     * Test enableAnalytics().
     *
     * @covers Lunr\Corona\RequestResultHandler::enableAnalytics
     */
    public function testEnableAnalytics(): void
    {
        $codeMap = [ HttpCode::BAD_REQUEST => 'bad_requests_log' ];
        $tagMap  = [ 'client' => ClientValue::Client ];

        $this->class->enableAnalytics($this->eventLogger, $codeMap, $tagMap);

        $this->assertPropertySame('eventLogger', $this->eventLogger);
        $this->assertPropertySame('codeMap', $codeMap);
        $this->assertPropertySame('tagMap', $tagMap);
    }

}

?>
