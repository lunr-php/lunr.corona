<?php

/**
 * This file contains the RouteInfoParserTestCase class.
 *
 * SPDX-FileCopyrightText: Copyright 2025 Framna Netherlands B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Corona\Parsers\RouteInfo\Tests;

use Lunr\Corona\Parsers\RouteInfo\RouteInfoParser;
use Lunr\Halo\LunrBaseTestCase;

/**
 * This class contains test methods for the RouteInfoParser class.
 *
 * @covers Lunr\Corona\Parsers\RouteInfo\RouteInfoParser
 */
abstract class RouteInfoParserTestCase extends LunrBaseTestCase
{

    /**
     * Instance of the tested class.
     * @var RouteInfoParser
     */
    protected RouteInfoParser $class;

    /**
     * TestCase Constructor.
     */
    public function setUp(): void
    {
        $this->class = new RouteInfoParser();

        parent::baseSetUp($this->class);
    }

    /**
     * TestCase Destructor.
     */
    public function tearDown(): void
    {
        unset($this->class);

        parent::tearDown();
    }

}

?>
