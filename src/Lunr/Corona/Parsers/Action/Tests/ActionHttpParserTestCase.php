<?php

/**
 * This file contains the ActionHttpParserTestCase class.
 *
 * SPDX-FileCopyrightText: Copyright 2025 Framna Netherlands B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Corona\Parsers\Action\Tests;

use Lunr\Corona\HttpMethod;
use Lunr\Corona\Parsers\Action\ActionHttpParser;
use Lunr\Halo\LunrBaseTestCase;

/**
 * This class contains test methods for the ActionHttpParser class.
 *
 * @covers Lunr\Corona\Parsers\Action\ActionHttpParser
 */
abstract class ActionHttpParserTestCase extends LunrBaseTestCase
{

    /**
     * Instance of the tested class.
     * @var ActionHttpParser
     */
    protected ActionHttpParser $class;

    /**
     * TestCase Constructor.
     */
    public function setUp(): void
    {
        $this->class = new ActionHttpParser(HttpMethod::class);

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
