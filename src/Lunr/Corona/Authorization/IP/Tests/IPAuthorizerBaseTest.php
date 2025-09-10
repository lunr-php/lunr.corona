<?php

/**
 * This file contains the IPAuthorizerBaseTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2025 Framna Netherlands B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Corona\Authorization\IP\Tests;

use Lunr\Corona\Authorization\AuthorizationType;

/**
 * This class contains common setup routines, providers
 * and shared attributes for testing the IPAuthorizer class.
 *
 * @covers Lunr\Corona\Authorization\IP\IPAuthorizer
 */
class IPAuthorizerBaseTest extends IPAuthorizerTestCase
{

    /**
     * Test that the Request class is set correctly.
     */
    public function testRequestSetCorrectly(): void
    {
        $this->assertPropertySame('request', $this->request);
    }

    /**
     * Test getAuthorizationType().
     *
     * @covers Lunr\Corona\Authorization\IP\IPAuthorizer::getAuthorizationType
     */
    public function testGetAuthorizationType(): void
    {
        $this->assertEquals(AuthorizationType::IP, $this->class->getAuthorizationType());
    }

}

?>
