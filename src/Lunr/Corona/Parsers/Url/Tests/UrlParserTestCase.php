<?php

/**
 * This file contains the UrlParserTestCase class.
 *
 * SPDX-FileCopyrightText: Copyright 2025 Framna Netherlands B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Corona\Parsers\Url\Tests;

use Lunr\Corona\Parsers\Url\UrlParser;
use Lunr\Halo\LunrBaseTestCase;

/**
 * This class contains test methods for the UrlParser class.
 *
 * @covers Lunr\Corona\Parsers\Url\UrlParser
 */
abstract class UrlParserTestCase extends LunrBaseTestCase
{

    /**
     * Instance of the tested class.
     * @var UrlParser
     */
    protected UrlParser $class;

    /**
     * TestCase Constructor.
     */
    public function setUp(): void
    {
        $this->class = new UrlParser();

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
