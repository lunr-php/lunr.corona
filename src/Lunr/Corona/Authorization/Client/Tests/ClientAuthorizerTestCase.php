<?php

/**
 * This file contains the ClientAuthorizerTestCase class.
 *
 * SPDX-FileCopyrightText: Copyright 2025 Framna Netherlands B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Corona\Authorization\Client\Tests;

use Lunr\Corona\Authorization\Client\ClientAuthorizer;
use Lunr\Corona\Request;
use Lunr\Halo\LunrBaseTestCase;
use PHPUnit\Framework\MockObject\MockObject;

/**
 * This class contains common setup routines, providers
 * and shared attributes for testing the ClientAuthorizer class.
 *
 * @covers Lunr\Corona\Authorization\Client\ClientAuthorizer
 */
abstract class ClientAuthorizerTestCase extends LunrBaseTestCase
{

    /**
     * Mock instance of the Request class.
     * @var Request&MockObject
     */
    protected Request&MockObject $request;

    /**
     * Instance of the tested class.
     * @var ClientAuthorizer
     */
    protected ClientAuthorizer $class;

    /**
     * Testcase Constructor.
     */
    public function setUp(): void
    {
        $this->request = $this->getMockBuilder(Request::class)
                              ->disableOriginalConstructor()
                              ->getMock();

        $this->class = new ClientAuthorizer($this->request);

        parent::baseSetUp($this->class);
    }

    /**
     * Testcase Destructor.
     */
    public function tearDown(): void
    {
        unset($this->request);
        unset($this->class);

        parent::tearDown();
    }

}

?>
