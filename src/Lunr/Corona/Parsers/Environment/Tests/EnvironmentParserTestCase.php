<?php

/**
 * This file contains the EnvironmentParserTestCase class.
 *
 * SPDX-FileCopyrightText: Copyright 2025 Framna Netherlands B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Corona\Parsers\Environment\Tests;

use Lunr\Corona\Parsers\Environment\EnvironmentParser;
use Lunr\Corona\Parsers\Environment\Tests\Helpers\MockEnvironmentEnum;
use Lunr\Halo\LunrBaseTestCase;

/**
 * This class contains test methods for the EnvironmentParser class.
 *
 * @covers Lunr\Corona\Parsers\Environment\EnvironmentParser
 */
abstract class EnvironmentParserTestCase extends LunrBaseTestCase
{

    /**
     * Instance of the tested class.
     * @var EnvironmentParser
     */
    protected EnvironmentParser $class;

    /**
     * TestCase Constructor.
     */
    public function setUp(): void
    {
        $this->class = new EnvironmentParser(MockEnvironmentEnum::class, 'production');

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
