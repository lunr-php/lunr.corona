<?php

/**
 * This file contains the HTMLViewTestCase class.
 *
 * SPDX-FileCopyrightText: Copyright 2013 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Corona\Tests;

use Lunr\Core\Configuration;
use Lunr\Corona\HTMLView;
use Lunr\Corona\Request;
use Lunr\Corona\Response;
use Lunr\Halo\LunrBaseTestCase;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\MockObject\Stub;

/**
 * This class tests the setup of the view class,
 * as well as the helper methods.
 *
 * @covers Lunr\Corona\HTMLView
 */
abstract class HTMLViewTestCase extends LunrBaseTestCase
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
     * Mock instance of the configuration class.
     * @var Configuration
     */
    protected $configuration;

    /**
     * Mock instance of the sub configuration class.
     * @var Configuration
     */
    protected $subConfiguration;

    /**
     * Instance of the tested class.
     * @var HTMLView&MockObject&Stub
     */
    protected HTMLView&MockObject&Stub $class;

    /**
     * TestCase Constructor.
     *
     * @return void
     */
    public function setUp(): void
    {
        $this->subConfiguration = $this->getMockBuilder('Lunr\Core\Configuration')->getMock();

        $this->configuration = $this->getMockBuilder('Lunr\Core\Configuration')->getMock();

        $map = [
            [ 'path', $this->subConfiguration ],
        ];

        $this->configuration->expects($this->any())
                      ->method('offsetGet')
                      ->willReturnMap($map);

        $this->request = $this->getMockBuilder('Lunr\Corona\Request')
                              ->disableOriginalConstructor()
                              ->getMock();

        $this->response = $this->getMockBuilder('Lunr\Corona\Response')->getMock();

        $this->class = $this->getMockBuilder('Lunr\Corona\HTMLView')
                           ->setConstructorArgs([ $this->request, $this->response, $this->configuration ])
                           ->getMockForAbstractClass();

        parent::baseSetUp($this->class);
    }

    /**
     * TestCase Destructor.
     */
    public function tearDown(): void
    {
        unset($this->configuration);
        unset($this->subConfiguration);
        unset($this->request);
        unset($this->response);
        unset($this->class);

        parent::tearDown();
    }

    /**
     * Unit Test Data Provider for css alternating.
     *
     * @return array $values Set of test data.
     */
    public static function cssAlternateProvider(): array
    {
        $values   = [];
        $values[] = [ 'row', 0, '', 'row_even' ];
        $values[] = [ 'row', 1, '', 'row_odd' ];
        $values[] = [ 'row', 0, 'custom', 'row_custom' ];
        return $values;
    }

    /**
     * Unit Test Data Provider for statics values.
     *
     * @return array $values Set of test data.
     */
    public static function staticsProvider(): array
    {
        $values   = [];
        $values[] = [ '/', 'statics', 'image/test.jpg', '/statics/image/test.jpg' ];
        $values[] = [ '/', '/statics', 'image/test.jpg', '/statics/image/test.jpg' ];
        $values[] = [ '/test/', 'statics', 'image/test.jpg', '/test/statics/image/test.jpg' ];
        $values[] = [ '/test/', '/statics', 'image/test.jpg', '/test/statics/image/test.jpg' ];
        return $values;
    }

}

?>
