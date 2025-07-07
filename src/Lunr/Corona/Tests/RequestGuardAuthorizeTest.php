<?php

/**
 * This file contains the RequestGuardAuthorizeTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2025 Framna Netherlands B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Corona\Tests;

use Lunr\Corona\Authorization\AuthorizationType;
use Lunr\Corona\Parsers\Client\Tests\Helpers\MockClientEnum;
use RuntimeException;

/**
 * This class contains common setup routines, providers
 * and shared attributes for testing the RequestGuard class.
 *
 * @covers Lunr\Corona\RequestGuard
 */
class RequestGuardAuthorizeTest extends RequestGuardTestCase
{

    /**
     * Test that authorize() throws an exception when no authorizer is registered.
     *
     * @covers Lunr\Corona\RequestGuard::authorize
     */
    public function testAuthorizeThrowsExceptionWhenNoAuthorizerRegistered(): void
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('No authorizer registered for authorization type "Client"!');

        $this->class->authorize(AuthorizationType::Client, MockClientEnum::CommandLine);
    }

    /**
     * Test that authorize() succeeds.
     *
     * @covers Lunr\Corona\RequestGuard::authorize
     */
    public function testAuthorizeSucceedsWithEnum(): void
    {
        $this->setReflectionPropertyValue('authorizers', [ AuthorizationType::Client->value => $this->authorizer ]);

        $this->authorizer->expects($this->once())
                         ->method('authorize')
                         ->with([ MockClientEnum::CommandLine ]);

        $this->class->authorize(AuthorizationType::Client, MockClientEnum::CommandLine);
    }

    /**
     * Test that authorize() succeeds.
     *
     * @covers Lunr\Corona\RequestGuard::authorize
     */
    public function testAuthorizeSucceedsWithString(): void
    {
        $this->setReflectionPropertyValue('authorizers', [ AuthorizationType::Client->value => $this->authorizer ]);

        $this->authorizer->expects($this->once())
                         ->method('authorize')
                         ->with([ MockClientEnum::CommandLine->value ]);

        $this->class->authorize(AuthorizationType::Client, MockClientEnum::CommandLine->value);
    }

    /**
     * Test that authorize() succeeds.
     *
     * @covers Lunr\Corona\RequestGuard::authorize
     */
    public function testAuthorizeSucceedsWithEmptyWhitelist(): void
    {
        $this->setReflectionPropertyValue('authorizers', [ AuthorizationType::Client->value => $this->authorizer ]);

        $this->authorizer->expects($this->once())
                         ->method('authorize')
                         ->with([]);

        $this->class->authorize(AuthorizationType::Client);
    }

}

?>
