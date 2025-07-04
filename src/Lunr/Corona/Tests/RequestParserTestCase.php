<?php

/**
 * This file contains the RequestParserTestCase class.
 *
 * SPDX-FileCopyrightText: Copyright 2014 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Corona\Tests;

use Lunr\Corona\RequestParser;
use Lunr\Halo\LunrBaseTestCase;

/**
 * This class contains common setup routines, providers
 * and shared attributes for testing the RequestParser class.
 *
 * @covers     Lunr\Corona\RequestParser
 */
abstract class RequestParserTestCase extends LunrBaseTestCase
{

    /**
     * Mock of the Configuration class.
     * @var Configuration
     */
    protected $configuration;

    /**
     * Instance of the tested class.
     * @var RequestParser
     */
    protected RequestParser $class;

    /**
     * Shared TestCase Constructor code.
     *
     * @return void
     */
    public function setUp(): void
    {
        $this->configuration = $this->getMockBuilder('Lunr\Core\Configuration')->getMock();

        $this->class = new RequestParser($this->configuration);

        parent::baseSetUp($this->class);
    }

    /**
     * TestCase Destructor.
     */
    public function tearDown(): void
    {
        unset($this->class);
        unset($this->configuration);

        parent::tearDown();
    }

    /**
     * Unit Test Data Provider for invalid super global values.
     *
     * @return array $cookie Set of invalid super global values
     */
    public static function invalidSuperglobalValueProvider(): array
    {
        $values   = [];
        $values[] = [ [] ];
        $values[] = [ 0 ];
        $values[] = [ 'String' ];
        $values[] = [ TRUE ];
        $values[] = [ NULL ];

        return $values;
    }

    /**
     * Unit Test Data Provider for Accept header content type(s).
     *
     * @return array $value Array of content type(s)
     */
    public static function contentTypeProvider(): array
    {
        $value   = [];
        $value[] = [ 'text/html' ];

        return $value;
    }

    /**
     * Unit Test Data Provider for Accept header language(s).
     *
     * @return array $value Array of language(s)
     */
    public static function acceptLanguageProvider(): array
    {
        $value   = [];
        $value[] = [ 'en-US' ];

        return $value;
    }

    /**
     * Unit Test Data Provider for Accept header charset(s).
     *
     * @return array $value Array of charset(s)
     */
    public static function acceptCharsetProvider(): array
    {
        $value   = [];
        $value[] = [ 'utf-8' ];

        return $value;
    }

}

?>
