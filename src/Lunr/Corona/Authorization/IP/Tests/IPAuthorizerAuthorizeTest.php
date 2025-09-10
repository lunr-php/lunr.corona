<?php

/**
 * This file contains the IPAuthorizerAuthorizeTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2025 Framna Netherlands B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Corona\Authorization\IP\Tests;

use Lunr\Corona\Exceptions\ForbiddenException;

/**
 * This class contains common setup routines, providers
 * and shared attributes for testing the IPAuthorizer class.
 *
 * @covers Lunr\Corona\Authorization\IP\IPAuthorizer
 */
class IPAuthorizerAuthorizeTest extends IPAuthorizerTestCase
{

    /**
     * Test authorize() throws exception when whitelist is empty.
     *
     * @covers Lunr\Corona\Authorization\IP\IPAuthorizer::authorize
     */
    public function testAuthorizeThrowsExceptionWhenWhitelistEmpty(): void
    {
        $this->request->expects($this->once())
                      ->method('getHttpHeaderData')
                      ->with('X-Forwarded-For')
                      ->willReturn('127.0.0.1');

        $this->expectException(ForbiddenException::class);
        $this->expectExceptionMessage('IP not whitelisted to access resource!');

        try
        {
            $this->class->authorize([]);
        }
        catch (ForbiddenException $e)
        {
            $this->assertEquals(4031, $e->getAppCode());
            $this->assertEquals('IP', $e->getDataKey());
            $this->assertEquals('127.0.0.1', $e->getDataValue());

            throw $e;
        }
    }

    /**
     * Test authorize() throws exception when IP is not in whitelist.
     *
     * @covers Lunr\Corona\Authorization\IP\IPAuthorizer::authorize
     */
    public function testAuthorizeThrowsExceptionWhenIPIsNotInWhitelistWithSingleItem(): void
    {
        $this->request->expects($this->once())
                      ->method('getHttpHeaderData')
                      ->with('X-Forwarded-For')
                      ->willReturn('127.0.0.1');

        $this->expectException(ForbiddenException::class);
        $this->expectExceptionMessage('IP not whitelisted to access resource!');

        try
        {
            $this->class->authorize([ '192.168.0.2' ]);
        }
        catch (ForbiddenException $e)
        {
            $this->assertEquals(4031, $e->getAppCode());
            $this->assertEquals('IP', $e->getDataKey());
            $this->assertEquals('127.0.0.1', $e->getDataValue());

            throw $e;
        }
    }

    /**
     * Test authorize() throws exception when IP is not in whitelist.
     *
     * @covers Lunr\Corona\Authorization\IP\IPAuthorizer::authorize
     */
    public function testAuthorizeThrowsExceptionWhenIPIsNotInWhitelistWithMultipleItems(): void
    {
        $this->request->expects($this->once())
                      ->method('getHttpHeaderData')
                      ->with('X-Forwarded-For')
                      ->willReturn('127.0.0.1');

        $this->expectException(ForbiddenException::class);
        $this->expectExceptionMessage('IP not whitelisted to access resource!');

        try
        {
            $this->class->authorize([ '192.168.0.2', '10.0.0.1' ]);
        }
        catch (ForbiddenException $e)
        {
            $this->assertEquals(4031, $e->getAppCode());
            $this->assertEquals('IP', $e->getDataKey());
            $this->assertEquals('127.0.0.1', $e->getDataValue());

            throw $e;
        }
    }

    /**
     * Test authorize() throws exception when multiple IPs are not in whitelist.
     *
     * @covers Lunr\Corona\Authorization\IP\IPAuthorizer::authorize
     */
    public function testAuthorizeThrowsExceptionWhenMultipleIPsAreNotInWhitelistWithSingleItem(): void
    {
        $this->request->expects($this->once())
                      ->method('getHttpHeaderData')
                      ->with('X-Forwarded-For')
                      ->willReturn('127.0.0.1, 192.168.0.3');

        $this->expectException(ForbiddenException::class);
        $this->expectExceptionMessage('IP not whitelisted to access resource!');

        try
        {
            $this->class->authorize([ '192.168.0.2' ]);
        }
        catch (ForbiddenException $e)
        {
            $this->assertEquals(4031, $e->getAppCode());
            $this->assertEquals('IP', $e->getDataKey());
            $this->assertEquals('127.0.0.1, 192.168.0.3', $e->getDataValue());

            throw $e;
        }
    }

    /**
     * Test authorize() throws exception when multiple IPs are not in whitelist.
     *
     * @covers Lunr\Corona\Authorization\IP\IPAuthorizer::authorize
     */
    public function testAuthorizeThrowsExceptionWhenMultipleIPsAreNotInWhitelistWithMultipleItems(): void
    {
        $this->request->expects($this->once())
                      ->method('getHttpHeaderData')
                      ->with('X-Forwarded-For')
                      ->willReturn('127.0.0.1, 192.168.0.3');

        $this->expectException(ForbiddenException::class);
        $this->expectExceptionMessage('IP not whitelisted to access resource!');

        try
        {
            $this->class->authorize([ '192.168.0.2', '10.0.0.1' ]);
        }
        catch (ForbiddenException $e)
        {
            $this->assertEquals(4031, $e->getAppCode());
            $this->assertEquals('IP', $e->getDataKey());
            $this->assertEquals('127.0.0.1, 192.168.0.3', $e->getDataValue());

            throw $e;
        }
    }

    /**
     * Test authorize() succeeds with single IP.
     *
     * @covers Lunr\Corona\Authorization\IP\IPAuthorizer::authorize
     */
    public function testAuthorizeSucceedsWithSingleIPInWhitelist(): void
    {
        $this->request->expects($this->once())
                      ->method('getHttpHeaderData')
                      ->with('X-Forwarded-For')
                      ->willReturn(NULL);

        $this->request->expects($this->once())
                      ->method('getServerData')
                      ->with('REMOTE_ADDR')
                      ->willReturn('127.0.0.1');

        $this->class->authorize([ '127.0.0.1' ]);
    }

    /**
     * Test authorize() succeeds with single IP.
     *
     * @covers Lunr\Corona\Authorization\IP\IPAuthorizer::authorize
     */
    public function testAuthorizeSucceedsWithSingleIPInWhitelistWithMultipleItems(): void
    {
        $this->request->expects($this->once())
                      ->method('getHttpHeaderData')
                      ->with('X-Forwarded-For')
                      ->willReturn(NULL);

        $this->request->expects($this->once())
                      ->method('getServerData')
                      ->with('REMOTE_ADDR')
                      ->willReturn('127.0.0.1');

        $this->class->authorize([ '127.0.0.1', '192.168.0.3' ]);
    }

    /**
     * Test authorize() succeeds with single IP.
     *
     * @covers Lunr\Corona\Authorization\IP\IPAuthorizer::authorize
     */
    public function testAuthorizeSucceedsWithOneOfMultipleIPsInWhitelist(): void
    {
        $this->request->expects($this->once())
                      ->method('getHttpHeaderData')
                      ->with('X-Forwarded-For')
                      ->willReturn('127.0.0.1, 192.168.0.3');

        $this->request->expects($this->never())
                      ->method('getServerData');

        $this->class->authorize([ '192.168.0.3' ]);
    }

    /**
     * Test authorize() succeeds with single IP.
     *
     * @covers Lunr\Corona\Authorization\IP\IPAuthorizer::authorize
     */
    public function testAuthorizeSucceedsWithOneOfMultipleIPsInWhitelistWithMultipleItems(): void
    {
        $this->request->expects($this->once())
                      ->method('getHttpHeaderData')
                      ->with('X-Forwarded-For')
                      ->willReturn('127.0.0.1, 192.168.0.3');

        $this->request->expects($this->never())
                      ->method('getServerData');

        $this->class->authorize([ '192.168.0.3', '192.168.0.5' ]);
    }

}

?>
