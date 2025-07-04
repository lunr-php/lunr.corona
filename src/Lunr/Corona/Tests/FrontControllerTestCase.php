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
use Lunr\Halo\LunrBaseTestCase;

/**
 * This class contains common setup routines, providers
 * and shared attributes for testing the FrontController class.
 *
 * @covers     Lunr\Corona\FrontController
 */
abstract class FrontControllerTestCase extends LunrBaseTestCase
{

    /**
     * Mock instance of the Request class.
     * @var Request
     */
    protected $request;

    /**
     * Mock instance of the RequestResultHandler class.
     * @var RequestResultHandler
     */
    protected $handler;

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
        $this->request = $this->getMockBuilder('Lunr\Corona\Request')
                              ->disableOriginalConstructor()
                              ->getMock();

        $this->handler = $this->getMockBuilder('Lunr\Corona\RequestResultHandler')
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
     * Unit test data provider for invalid controller names.
     *
     * @return array $names Array of invalid names
     */
    public static function invalidControllerNameProvider(): array
    {
        $names   = [];
        $names[] = [ NULL ];
        $names[] = [ FALSE ];
        $names[] = [ 1 ];
        $names[] = [ 1.1 ];

        return $names;
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
