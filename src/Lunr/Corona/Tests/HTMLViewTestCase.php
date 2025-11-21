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
use Mockery;
use Mockery\MockInterface;
use PHPUnit\Framework\MockObject\MockObject;

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
     * @var Request&MockObject
     */
    protected Request&MockObject $request;

    /**
     * Mock instance of the response class.
     * @var Response&MockObject
     */
    protected Response&MockObject $response;

    /**
     * Mock instance of the Configuration class.
     * @var Configuration&MockInterface
     */
    protected Configuration&MockInterface $config;

    /**
     * Instance of the tested class.
     * @var HTMLView&MockInterface
     */
    protected HTMLView&MockInterface $class;

    /**
     * TestCase Constructor.
     *
     * @return void
     */
    public function setUp(): void
    {
        $this->config = Mockery::mock(Configuration::class);

        $this->request = $this->getMockBuilder(Request::class)
                              ->disableOriginalConstructor()
                              ->getMock();

        $this->response = $this->getMockBuilder(Response::class)->getMock();

        $this->mockFunction('headers_sent', fn() => TRUE);

        $this->class = Mockery::mock(HTMLView::class, [ $this->request, $this->response, $this->config ]);

        $this->unmockFunction('headers_sent');

        parent::baseSetUp($this->class);
    }

    /**
     * TestCase Destructor.
     */
    public function tearDown(): void
    {
        unset($this->config);
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
