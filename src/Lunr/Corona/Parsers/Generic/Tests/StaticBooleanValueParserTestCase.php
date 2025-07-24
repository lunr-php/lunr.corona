<?php

/**
 * This file contains the StaticBooleanValueParserTestCase class.
 *
 * SPDX-FileCopyrightText: Copyright 2025 Framna Netherlands B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Corona\Parsers\Generic\Tests;

use Lunr\Corona\Parsers\Analytics\AnalyticsValue;
use Lunr\Corona\Parsers\Generic\StaticBooleanValueParser;
use Lunr\Halo\LunrBaseTestCase;

/**
 * This class contains test methods for the StaticBooleanValueParser class.
 *
 * @covers Lunr\Corona\Parsers\StaticBooleanValue\StaticBooleanValueParser
 */
abstract class StaticBooleanValueParserTestCase extends LunrBaseTestCase
{

    /**
     * Instance of the tested class.
     * @var StaticBooleanValueParser
     */
    protected StaticBooleanValueParser $class;

    /**
     * TestCase Constructor.
     */
    public function setUp(): void
    {
        $this->class = new StaticBooleanValueParser(AnalyticsValue::AnalyticsEnabled, TRUE);

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
