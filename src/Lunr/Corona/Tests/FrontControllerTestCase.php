<?php

/**
 * This file contains the FrontControllerTestCase class.
 *
 * SPDX-FileCopyrightText: Copyright 2013 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Corona\Tests;

use Lunr\Corona\FrontController;
use Lunr\Corona\Request;
use Lunr\Corona\RequestResultHandler;
use Lunr\Halo\LunrBaseTestCase;
use PHPUnit\Framework\MockObject\MockObject;

/**
 * This class contains common setup routines, providers
 * and shared attributes for testing the FrontController class.
 *
 * @covers Lunr\Corona\FrontController
 */
abstract class FrontControllerTestCase extends LunrBaseTestCase
{

    /**
     * Mock instance of the Request class.
     * @var Request&MockObject
     */
    protected Request&MockObject $request;

    /**
     * Mock instance of the RequestResultHandler class.
     * @var RequestResultHandler&MockObject
     */
    protected RequestResultHandler&MockObject $handler;

    /**
     * Instance of the tested class.
     * @var FrontController
     */
    protected FrontController $class;

    /**
     * Test case constructor.
     */
    public function setUp(): void
    {
        $this->request = $this->getMockBuilder(Request::class)
                              ->disableOriginalConstructor()
                              ->getMock();

        $this->handler = $this->getMockBuilder(RequestResultHandler::class)
                              ->disableOriginalConstructor()
                              ->getMock();

        $this->class = new FrontController($this->request, $this->handler);

        parent::baseSetUp($this->class);
    }

    /**
     * Test case destructor.
     */
    public function tearDown(): void
    {
        unset($this->class);
        unset($this->request);
        unset($this->handler);

        parent::tearDown();
    }

    /**
     * Unit test data provider for invalid controller names
     *
     * @return array Array of invalid controller names
     */
    public static function invalidControllerNameValuesProvider(): array
    {
        $controllerNames   = [];
        $controllerNames[] = [ 'test+test' ];
        $controllerNames[] = [ 'test test' ];
        $controllerNames[] = [ 'test\test' ];
        $controllerNames[] = [ 'test/test' ];
        $controllerNames[] = [ 'w00tw00t.at.blackhats.romanian.anti-sec:)controller' ];

        return $controllerNames;
    }

}

?>
