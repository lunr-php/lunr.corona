<?php

/**
 * This file contains the ViewTestCase class.
 *
 * SPDX-FileCopyrightText: Copyright 2012 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Corona\Tests;

use Lunr\Corona\Parsers\TracingInfo\TracingInfoValue;
use Lunr\Corona\Request;
use Lunr\Corona\Response;
use Lunr\Corona\View;
use Lunr\Halo\LunrBaseTestCase;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\MockObject\Stub;

/**
 * This class tests the setup of the view class,
 * as well as the helper methods.
 *
 * @covers Lunr\Corona\View
 */
abstract class ViewTestCase extends LunrBaseTestCase
{

    /**
     * Mock instance of the request class.
     * @var Request
     */
    protected $request;

    /**
     * Mock instance of the response class.
     * @var Response
     */
    protected $response;

    /**
     * Instance of the tested class.
     * @var View&MockObject&Stub
     */
    protected View&MockObject&Stub $class;

    /**
     * TestCase Constructor.
     *
     * @return void
     */
    public function setUp(): void
    {
        $this->request = $this->getMockBuilder('Lunr\Corona\Request')
                              ->disableOriginalConstructor()
                              ->getMock();

        $this->response = $this->getMockBuilder('Lunr\Corona\Response')->getMock();

        if (!headers_sent())
        {
            $this->request->expects($this->once())
                          ->method('get')
                          ->with(TracingInfoValue::TraceID)
                          ->willReturn('962161b27a0141f384c63834ad001adf');
        }

        $this->class = $this->getMockBuilder('Lunr\Corona\View')
                            ->setConstructorArgs(
                               [ $this->request, $this->response ]
                             )
                           ->getMockForAbstractClass();

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
     * Unit Test Data Provider for baseurl values.
     *
     * @return array $values Set of test data.
     */
    public static function baseUrlProvider(): array
    {
        $values   = [];
        $values[] = [ 'http://www.example.org/', 'method/param', 'http://www.example.org/method/param' ];
        $values[] = [ 'http://www.example.org/test/', 'method/param', 'http://www.example.org/test/method/param' ];
        return $values;
    }

    /**
     * Unit Test Data Provider for fatal error information.
     *
     * @return array $values Array of mocked fatal error information.
     */
    public static function fatalErrorInfoProvider(): array
    {
        $values   = [];
        $values[] = [ [ 'type' => 1, 'message' => 'Message', 'file' => 'index.php', 'line' => 2 ] ];
        $values[] = [ [ 'type' => 4, 'message' => 'Message', 'file' => 'index.php', 'line' => 2 ] ];
        $values[] = [ [ 'type' => 16, 'message' => 'Message', 'file' => 'index.php', 'line' => 2 ] ];
        $values[] = [ [ 'type' => 64, 'message' => 'Message', 'file' => 'index.php', 'line' => 2 ] ];
        $values[] = [ [ 'type' => 256, 'message' => 'Message', 'file' => 'index.php', 'line' => 2 ] ];

        return $values;
    }

    /**
     * Unit Test Data Provider for error information.
     *
     * @return array $values Array of non-fatal error information.
     */
    public static function errorInfoProvider(): array
    {
        $values   = [];
        $values[] = [ NULL ];
        $values[] = [ [ 'type' => 2, 'message' => 'Message', 'file' => 'index.php', 'line' => 2 ] ];
        $values[] = [ [ 'type' => 8, 'message' => 'Message', 'file' => 'index.php', 'line' => 2 ] ];
        $values[] = [ [ 'type' => 32, 'message' => 'Message', 'file' => 'index.php', 'line' => 2 ] ];
        $values[] = [ [ 'type' => 128, 'message' => 'Message', 'file' => 'index.php', 'line' => 2 ] ];
        $values[] = [ [ 'type' => 512, 'message' => 'Message', 'file' => 'index.php', 'line' => 2 ] ];
        $values[] = [ [ 'type' => 1024, 'message' => 'Message', 'file' => 'index.php', 'line' => 2 ] ];
        $values[] = [ [ 'type' => 2048, 'message' => 'Message', 'file' => 'index.php', 'line' => 2 ] ];
        $values[] = [ [ 'type' => 4096, 'message' => 'Message', 'file' => 'index.php', 'line' => 2 ] ];
        $values[] = [ [ 'type' => 8192, 'message' => 'Message', 'file' => 'index.php', 'line' => 2 ] ];
        $values[] = [ [ 'type' => 16384, 'message' => 'Message', 'file' => 'index.php', 'line' => 2 ] ];

        return $values;
    }

}

?>
