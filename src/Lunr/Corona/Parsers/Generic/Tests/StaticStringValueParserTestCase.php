<?php

/**
 * This file contains the StaticStringValueParserTestCase class.
 *
 * SPDX-FileCopyrightText: Copyright 2025 Framna Netherlands B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Corona\Parsers\Generic\Tests;

use Lunr\Corona\Parsers\ClientVersion\ClientVersionValue;
use Lunr\Corona\Parsers\Generic\StaticStringValueParser;
use Lunr\Halo\LunrBaseTestCase;

/**
 * This class contains test methods for the StaticStringValueParser class.
 *
 * @covers Lunr\Corona\Parsers\StaticStringValue\StaticStringValueParser
 */
abstract class StaticStringValueParserTestCase extends LunrBaseTestCase
{

    /**
     * Instance of the tested class.
     * @var StaticStringValueParser
     */
    protected StaticStringValueParser $class;

    /**
     * TestCase Constructor.
     */
    public function setUp(): void
    {
        $this->class = new StaticStringValueParser(ClientVersionValue::ClientVersion, '1.2.3');

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
