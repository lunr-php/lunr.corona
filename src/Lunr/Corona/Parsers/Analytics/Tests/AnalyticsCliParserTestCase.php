<?php

/**
 * This file contains the AnalyticsCliParserTestCase class.
 *
 * SPDX-FileCopyrightText: Copyright 2025 Framna Netherlands B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Corona\Parsers\Analytics\Tests;

use Lunr\Corona\Parsers\Analytics\AnalyticsCliParser;
use Lunr\Halo\LunrBaseTestCase;

/**
 * This class contains test methods for the AnalyticsCliParser class.
 *
 * @covers Lunr\Corona\Parsers\Analytics\AnalyticsCliParser
 */
abstract class AnalyticsCliParserTestCase extends LunrBaseTestCase
{

    /**
     * Instance of the tested class.
     * @var AnalyticsCliParser
     */
    protected AnalyticsCliParser $class;

    /**
     * TestCase Constructor.
     */
    public function setUp(): void
    {
        $this->class = new AnalyticsCliParser([]);

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

    /**
     * Unit test data provider for values indicating enabled analytics.
     *
     * @return list<string[]>
     */
    public static function enabledAnalyticsValueProvider(): array
    {
        $data   = [];
        $data[] = [ 'on' ];
        $data[] = [ 'yes' ];
        $data[] = [ 'enabled' ];

        return $data;
    }

    /**
     * Unit test data provider for values indicating disabled analytics.
     *
     * @return list<string[]>
     */
    public static function disabledAnalyticsValueProvider(): array
    {
        $data   = [];
        $data[] = [ 'off' ];
        $data[] = [ 'no' ];
        $data[] = [ 'disabled' ];
        $data[] = [ 'local' ];
        $data[] = [ 'foo' ];

        return $data;
    }

}

?>
