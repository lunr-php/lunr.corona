<?php

/**
 * This file contains the RequestResultHandlerTestCase class.
 *
 * SPDX-FileCopyrightText: Copyright 2018 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Corona\Tests;

use Lunr\Corona\Request;
use Lunr\Corona\RequestResultHandler;
use Lunr\Corona\Response;
use Lunr\Halo\LunrBaseTestCase;
use Lunr\Ticks\EventLogging\EventInterface;
use Lunr\Ticks\EventLogging\EventLoggerInterface;
use PHPUnit\Framework\MockObject\MockObject;
use Psr\Log\LoggerInterface;

/**
 * This class contains common setup routines, providers
 * and shared attributes for testing the RequestResultHandlerTrait class.
 *
 * @covers     Lunr\Corona\RequestResultHandlerTrait
 */
abstract class RequestResultHandlerTestCase extends LunrBaseTestCase
{

    /**
     * Mock instance of the Request class.
     * @var Request&MockObject
     */
    protected Request&MockObject $request;

    /**
     * Mock instance of the Response class.
     * @var Response&MockObject
     */
    protected Response&MockObject $response;

    /**
     * Mock instance of a Logger class.
     * @var LoggerInterface&MockObject
     */
    protected LoggerInterface&MockObject $logger;

    /**
     * Mock Instance of an event logger.
     * @var EventLoggerInterface&MockObject
     */
    protected EventLoggerInterface&MockObject $eventLogger;

    /**
     * Mock Instance of an analytics event.
     * @var EventInterface&MockObject
     */
    protected EventInterface&MockObject $event;

    /**
     * Instance of the tested class.
     * @var RequestResultHandler
     */
    protected RequestResultHandler $class;

    /**
     * Test case constructor.
     */
    public function setUp(): void
    {
        $this->request = $this->getMockBuilder(Request::class)
                              ->disableOriginalConstructor()
                              ->getMock();

        $this->response = $this->getMockBuilder(Response::class)
                               ->disableOriginalConstructor()
                               ->getMock();

        $this->logger = $this->getMockBuilder(LoggerInterface::class)
                             ->getMock();

        $this->eventLogger = $this->getMockBuilder(EventLoggerInterface::class)
                                  ->getMock();

        $this->event = $this->getMockBuilder(EventInterface::class)
                            ->getMock();

        $this->class = new RequestResultHandler($this->request, $this->response, $this->logger);

        parent::baseSetUp($this->class);
    }

    /**
     * Test case destructor.
     */
    public function tearDown(): void
    {
        unset($this->class);
        unset($this->request);
        unset($this->response);
        unset($this->logger);
        unset($this->eventLogger);
        unset($this->event);

        parent::tearDown();
    }

}

?>
