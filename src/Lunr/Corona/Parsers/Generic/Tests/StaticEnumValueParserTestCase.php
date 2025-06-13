<?php

/**
 * This file contains the StaticEnumValueParserTestCase class.
 *
 * SPDX-FileCopyrightText: Copyright 2025 Framna Netherlands B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Corona\Parsers\Generic\Tests;

use Lunr\Corona\Parsers\Client\ClientValue;
use Lunr\Corona\Parsers\Client\Tests\Helpers\MockClientEnum;
use Lunr\Corona\Parsers\Generic\StaticEnumValueParser;
use Lunr\Halo\LunrBaseTestCase;

/**
 * This class contains test methods for the StaticEnumValueParser class.
 *
 * @covers Lunr\Corona\Parsers\StaticEnumValue\StaticEnumValueParser
 */
abstract class StaticEnumValueParserTestCase extends LunrBaseTestCase
{

    /**
     * Instance of the tested class.
     * @var StaticEnumValueParser
     */
    protected StaticEnumValueParser $class;

    /**
     * TestCase Constructor.
     */
    public function setUp(): void
    {
        $this->class = new StaticEnumValueParser(ClientValue::Client, MockClientEnum::CommandLine);

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
