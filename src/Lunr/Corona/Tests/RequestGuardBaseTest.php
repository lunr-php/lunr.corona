<?php

/**
 * This file contains the RequestGuardBaseTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2025 Framna Netherlands B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Corona\Tests;

use Lunr\Corona\Authorization\AuthorizationType;

/**
 * This class contains common setup routines, providers
 * and shared attributes for testing the RequestGuard class.
 *
 * @covers Lunr\Corona\RequestGuard
 */
class RequestGuardBaseTest extends RequestGuardTestCase
{

    /**
     * Test that the Request class is set correctly.
     */
    public function testRequestSetCorrectly(): void
    {
        $this->assertPropertySame('request', $this->request);
    }

    /**
     * Test registerAuthorizer().
     *
     * @covers Lunr\Corona\RequestGuard::registerAuthorizer
     */
    public function testRegisterAuthorizer(): void
    {
        $this->authorizer->expects($this->once())
                         ->method('getAuthorizationType')
                         ->willReturn(AuthorizationType::Client);

        $this->class->registerAuthorizer($this->authorizer);

        $this->assertPropertyEquals('authorizers', [ AuthorizationType::Client->value => $this->authorizer ]);
    }

}

?>
