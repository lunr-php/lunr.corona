<?php

/**
 * This file contains the ContainerTypeParserTestCase class.
 *
 * SPDX-FileCopyrightText: Copyright 2025 Framna Netherlands B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Corona\Parsers\ContainerType\Tests;

use Lunr\Corona\Parsers\ContainerType\ContainerTypeParser;
use Lunr\Halo\LunrBaseTestCase;

/**
 * This class contains test methods for the ContainerTypeParser class.
 *
 * @covers Lunr\Corona\Parsers\ContainerType\ContainerTypeParser
 */
abstract class ContainerTypeParserTestCase extends LunrBaseTestCase
{

    /**
     * Instance of the tested class.
     * @var ContainerTypeParser
     */
    protected ContainerTypeParser $class;

    /**
     * TestCase Constructor.
     */
    public function setUp(): void
    {
        $this->class = new ContainerTypeParser();

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
