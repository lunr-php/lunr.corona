<?php

/**
 * This file contains the HostParserTestCase class.
 *
 * SPDX-FileCopyrightText: Copyright 2025 Framna Netherlands B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Corona\Parsers\Host\Tests;

use Lunr\Corona\Parsers\Host\HostParser;
use Lunr\Halo\LunrBaseTestCase;

/**
 * This class contains test methods for the HostParser class.
 *
 * @covers Lunr\Corona\Parsers\Host\HostParser
 */
abstract class HostParserTestCase extends LunrBaseTestCase
{

    /**
     * Instance of the tested class.
     * @var HostParser
     */
    protected HostParser $class;

    /**
     * TestCase Constructor.
     */
    public function setUp(): void
    {
        $this->class = new HostParser();

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
