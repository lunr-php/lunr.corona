<?php

/**
 * This file contains the ActionCliParserTestCase class.
 *
 * SPDX-FileCopyrightText: Copyright 2025 Framna Netherlands B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Corona\Parsers\Action\Tests;

use Lunr\Corona\HttpMethod;
use Lunr\Corona\Parsers\Action\ActionCliParser;
use Lunr\Halo\LunrBaseTestCase;

/**
 * This class contains test methods for the ActionCliParser class.
 *
 * @covers Lunr\Corona\Parsers\Action\ActionCliParser
 */
abstract class ActionCliParserTestCase extends LunrBaseTestCase
{

    /**
     * Instance of the tested class.
     * @var ActionCliParser
     */
    protected ActionCliParser $class;

    /**
     * TestCase Constructor.
     */
    public function setUp(): void
    {
        $method = 'GET';

        $ast = [
            'action' => [
                $method,
            ]
        ];

        $this->class = new ActionCliParser(HttpMethod::class, $ast);

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
