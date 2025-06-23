<?php

/**
 * This file contains the ClientVersionHttpHeaderParserTestCase class.
 *
 * SPDX-FileCopyrightText: Copyright 2025 Framna Netherlands B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Corona\Parsers\ClientVersion\Tests;

use Lunr\Corona\Parsers\ClientVersion\ClientVersionHttpHeaderParser;
use Lunr\Halo\LunrBaseTestCase;

/**
 * This class contains test methods for the ClientVersionHttpHeaderParser class.
 *
 * @covers Lunr\Corona\Parsers\ClientVersion\ClientVersionHttpHeaderParser
 */
abstract class ClientVersionHttpHeaderParserTestCase extends LunrBaseTestCase
{

    /**
     * Instance of the tested class.
     * @var ClientVersionHttpHeaderParser
     */
    protected ClientVersionHttpHeaderParser $class;

    /**
     * TestCase Constructor.
     */
    public function setUp(): void
    {
        $this->class = new ClientVersionHttpHeaderParser();

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
