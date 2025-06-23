<?php

/**
 * This file contains the ClientVersionCliParserTestCase class.
 *
 * SPDX-FileCopyrightText: Copyright 2025 Framna Netherlands B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Corona\Parsers\ClientVersion\Tests;

use Lunr\Corona\Parsers\ClientVersion\ClientVersionCliParser;
use Lunr\Halo\LunrBaseTestCase;

/**
 * This class contains test methods for the ClientVersionCliParser class.
 *
 * @covers Lunr\Corona\Parsers\ClientVersion\ClientVersionCliParser
 */
abstract class ClientVersionCliParserTestCase extends LunrBaseTestCase
{

    /**
     * Instance of the tested class.
     * @var ClientVersionCliParser
     */
    protected ClientVersionCliParser $class;

    /**
     * TestCase Constructor.
     */
    public function setUp(): void
    {
        $version = 'Client 1.2.3/beta 1';

        $ast = [
            'client-version' => [
                $version,
            ]
        ];

        $this->class = new ClientVersionCliParser($ast);

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
