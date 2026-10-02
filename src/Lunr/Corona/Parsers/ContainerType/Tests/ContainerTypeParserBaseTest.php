<?php

/**
 * This file contains the ContainerTypeParserBaseTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2025 Framna Netherlands B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Corona\Parsers\ContainerType\Tests;

use Lunr\Corona\Parsers\ContainerType\ContainerTypeParser;
use ReflectionClass;

/**
 * This class contains test methods for the ContainerTypeParser class.
 *
 * @covers Lunr\Corona\Parsers\ContainerType\ContainerTypeParser
 */
class ContainerTypeParserBaseTest extends ContainerTypeParserTestCase
{

    /**
     * Test that the default type is set correctly.
     */
    public function testDefaultTypeIsSetCorrectly(): void
    {
        $this->assertPropertySame('defaultType', 'unknown');
    }

    /**
     * Test that the default environment variable name is set correctly.
     */
    public function testEnvVarIsSetCorrectly(): void
    {
        $this->assertPropertySame('envVar', 'CONTAINER_TYPE');
    }

    /**
     * Test that custom constructor values are stored correctly.
     */
    public function testConstructorStoresCustomValues(): void
    {
        $class = new ContainerTypeParser('fallback', 'MY_CONTAINER_TYPE');

        $reflection = new ReflectionClass($class);

        $defaultType = $reflection->getProperty('defaultType');
        $envVar      = $reflection->getProperty('envVar');

        $this->assertSame('fallback', $defaultType->getValue($class));
        $this->assertSame('MY_CONTAINER_TYPE', $envVar->getValue($class));
    }

}

?>
