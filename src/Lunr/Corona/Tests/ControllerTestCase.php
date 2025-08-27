<?php

/**
 * This file contains the ControllerTestCase class.
 *
 * SPDX-FileCopyrightText: Copyright 2011 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Corona\Tests;

use Lunr\Corona\Controller;
use Lunr\Corona\Request;
use Lunr\Corona\Response;
use Lunr\Halo\LunrBaseTestCase;
use PHPUnit\Framework\MockObject\MockObject;

/**
 * This class contains test methods for the Controller class.
 *
 * @covers Lunr\Corona\Controller
 */
abstract class ControllerTestCase extends LunrBaseTestCase
{

    /**
     * Mock instance of the response class.
     * @var Response&MockObject
     */
    protected Response&MockObject $response;

    /**
     * Mock instance of the request class.
     * @var Request&MockObject
     */
    protected Request&MockObject $request;

    /**
     * Instance of the tested class.
     * @var Controller&MockObject
     */
    protected Controller&MockObject $class;

    /**
     * TestCase Constructor.
     */
    public function setUp(): void
    {
        $this->response = $this->getMockBuilder(Response::class)->getMock();
        $this->request  = $this->getMockBuilder(Request::class)
                               ->disableOriginalConstructor()
                               ->getMock();

        $this->class = $this->getMockBuilder(Controller::class)
                            ->setConstructorArgs([ $this->request, $this->response ])
                            ->getMockForAbstractClass();

        parent::baseSetUp($this->class);
    }

    /**
     * TestCase Destructor.
     */
    public function tearDown(): void
    {
        unset($this->response);
        unset($this->request);
        unset($this->class);

        parent::tearDown();
    }

}

?>
