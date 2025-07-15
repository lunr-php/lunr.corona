<?php

/**
 * This file contains the ClientAuthorizerBaseTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2025 Framna Netherlands B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Corona\Authorization\Client\Tests;

use Lunr\Corona\Authorization\AuthorizationType;

/**
 * This class contains common setup routines, providers
 * and shared attributes for testing the ClientAuthorizer class.
 *
 * @covers Lunr\Corona\Authorization\Client\ClientAuthorizer
 */
class ClientAuthorizerBaseTest extends ClientAuthorizerTestCase
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
     * @covers Lunr\Corona\Authorization\Client\ClientAuthorizer::getAuthorizationType
     */
    public function testGetAuthorizationType(): void
    {
        $this->assertEquals(AuthorizationType::Client, $this->class->getAuthorizationType());
    }

}

?>
