<?php

/**
 * This file contains the ResponseHasCustomResultSetTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2025 Framna Netherlands B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Corona\Tests;

/**
 * This class contains test methods for the Response class.
 *
 * @covers Lunr\Corona\Response
 */
class ResponseHasCustomResultSetTest extends ResponseTestCase
{

    /**
     * Test hasCustomResultSet() with no result set.
     *
     * @covers Lunr\Corona\Response::hasCustomResultSet
     */
    public function testHasCustomResultSetWithNoResultSet(): void
    {
        $this->assertFalse($this->class->hasCustomResultSet());
    }

    /**
     * Test hasCustomResultSet() with only default result set.
     *
     * @covers Lunr\Corona\Response::hasCustomResultSet
     */
    public function testHasCustomResultSetWithOnlyDefaultResultSet(): void
    {
        $this->setReflectionPropertyValue('defaultResultCode', 501);

        $this->assertFalse($this->class->hasCustomResultSet());
    }

    /**
     * Test hasCustomResultSet() with only custom result set.
     *
     * @covers Lunr\Corona\Response::hasCustomResultSet
     */
    public function testHasCustomResultSetWithOnlyCustomResultSet(): void
    {
        $this->setReflectionPropertyValue('resultCode', [ 'controller/method', 200 ]);

        $this->assertTrue($this->class->hasCustomResultSet());
    }

    /**
     * Test hasCustomResultSet() with default and custom result set.
     *
     * @covers Lunr\Corona\Response::hasCustomResultSet
     */
    public function testHasCustomResultSetWithDefaultAndCustomResultSet(): void
    {
        $this->setReflectionPropertyValue('defaultResultCode', 501);
        $this->setReflectionPropertyValue('resultCode', [ 'controller/method', 200 ]);

        $this->assertTrue($this->class->hasCustomResultSet());
    }

}

?>
