<?php

/**
 * This file contains the MsgpackViewTestCase class.
 *
 * SPDX-FileCopyrightText: Copyright 2017 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Corona\Tests;

use Lunr\Corona\MsgpackView;
use Lunr\Corona\Request;
use Lunr\Corona\Response;
use Lunr\Halo\LunrBaseTestCase;

/**
 * This class contains common setup routines, providers
 * and shared attributes for testing the MsgpackView class.
 *
 * @covers Lunr\Corona\MsgpackView
 */
abstract class MsgpackViewTestCase extends LunrBaseTestCase
{

    /**
     * Mock instance of the Request class.
     * @var Request
     */
    protected $request;

    /**
     * Mock instance of the Response class.
     * @var Response
     */
    protected $response;

    /**
     * Instance of the tested class.
     * @var MsgpackView
     */
    protected MsgpackView $class;

    /**
     * TestCase Constructor.
     */
    public function setUp(): void
    {
        $this->response = $this->getMockBuilder('Lunr\Corona\Response')->getMock();

        $this->request = $this->getMockBuilder('Lunr\Corona\Request')
                              ->disableOriginalConstructor()
                              ->getMock();

        $this->class = new MsgpackView($this->request, $this->response);

        parent::baseSetUp($this->class);
    }

    /**
     * TestCase Destructor.
     */
    public function tearDown(): void
    {
        unset($this->request);
        unset($this->response);
        unset($this->class);

        parent::tearDown();
    }

    /**
     * Unit Test Data Provider for non-integer error info values.
     *
     * @return array $info Array of non-integer error info values.
     */
    public static function invalidErrorInfoProvider(): array
    {
        $info   = [];
        $info[] = [ 'string' ];
        $info[] = [ NULL ];
        $info[] = [ '404_1' ];
        $info[] = [ '404.1' ];

        return $info;
    }

}

?>
