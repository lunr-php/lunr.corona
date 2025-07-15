<?php

/**
 * This file contains the ClientAuthorizerAuthorizeTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2025 Framna Netherlands B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Corona\Authorization\Client\Tests;

use Lunr\Corona\Exceptions\ForbiddenException;
use Lunr\Corona\Exceptions\UnauthorizedException;
use Lunr\Corona\Parsers\Client\ClientValue;
use Lunr\Corona\Parsers\Client\Tests\Helpers\MockClientEnum;

/**
 * This class contains common setup routines, providers
 * and shared attributes for testing the ClientAuthorizer class.
 *
 * @covers Lunr\Corona\Authorization\Client\ClientAuthorizer
 */
class ClientAuthorizerAuthorizeTest extends ClientAuthorizerTestCase
{

    /**
     * Test authorize() throws exception when whitelist is empty.
     *
     * @covers Lunr\Corona\Authorization\Client\ClientAuthorizer::authorize
     */
    public function testAuthorizeThrowsExceptionWhenWhitelistEmpty(): void
    {
        $this->expectException(ForbiddenException::class);
        $this->expectExceptionMessage('Insufficient privileges to access resource!');

        try
        {
            $this->class->authorize([]);
        }
        catch (ForbiddenException $e)
        {
            $this->assertEquals(4030, $e->getAppCode());

            throw $e;
        }
    }

    /**
     * Test authorize() throws exception when client is not in whitelist.
     *
     * @covers Lunr\Corona\Authorization\Client\ClientAuthorizer::authorize
     */
    public function testAuthorizeThrowsExceptionWhenClientIsNotInWhitelist(): void
    {
        $this->request->expects($this->once())
                      ->method('getAsEnum')
                      ->with(ClientValue::Client)
                      ->willReturn(MockClientEnum::CommandLine);

        $this->expectException(ForbiddenException::class);
        $this->expectExceptionMessage('Insufficient privileges to access resource!');

        try
        {
            $this->class->authorize([ MockClientEnum::Website ]);
        }
        catch (ForbiddenException $e)
        {
            $this->assertEquals(4030, $e->getAppCode());

            throw $e;
        }
    }

    /**
     * Test authorize() throws exception when client is not in whitelist and it's NULL.
     *
     * @covers Lunr\Corona\Authorization\Client\ClientAuthorizer::authorize
     */
    public function testAuthorizeThrowsExceptionWhenClientIsNotInWhitelistAndNull(): void
    {
        $this->request->expects($this->once())
                      ->method('getAsEnum')
                      ->with(ClientValue::Client)
                      ->willReturn(NULL);

        $this->expectException(UnauthorizedException::class);
        $this->expectExceptionMessage('Unauthorized access!');

        try
        {
            $this->class->authorize([ MockClientEnum::Website ]);
        }
        catch (UnauthorizedException $e)
        {
            $this->assertEquals(4010, $e->getAppCode());

            throw $e;
        }
    }

    /**
     * Test authorize() succeeds when client has global access.
     *
     * @covers Lunr\Corona\Authorization\Client\ClientAuthorizer::authorize
     */
    public function testAuthorizeSucceedsWhenClientHasGlobalAccess(): void
    {
        $this->request->expects($this->once())
                      ->method('getAsEnum')
                      ->with(ClientValue::Client)
                      ->willReturn(MockClientEnum::Developer);

        $this->class->authorize([ MockClientEnum::Website, MockClientEnum::CommandLine ]);
    }

    /**
     * Test authorize() succeeds when client is in whitelist as enum.
     *
     * @covers Lunr\Corona\Authorization\Client\ClientAuthorizer::authorize
     */
    public function testAuthorizeSucceedsWhenClientInWhitelistAsEnum(): void
    {
        $this->request->expects($this->once())
                      ->method('getAsEnum')
                      ->with(ClientValue::Client)
                      ->willReturn(MockClientEnum::CommandLine);

        $this->class->authorize([ MockClientEnum::Website, MockClientEnum::CommandLine ]);
    }

    /**
     * Test authorize() succeeds when client is in whitelist as string.
     *
     * @covers Lunr\Corona\Authorization\Client\ClientAuthorizer::authorize
     */
    public function testAuthorizeSucceedsWhenClientInWhitelistAsString(): void
    {
        $this->request->expects($this->once())
                      ->method('getAsEnum')
                      ->with(ClientValue::Client)
                      ->willReturn(MockClientEnum::CommandLine);

        $this->class->authorize([ 'Website', 'Command Line' ]);
    }

}

?>
