<?php

/**
 * This file contains the RouteInfoParserGetTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2025 Framna Netherlands B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Corona\Parsers\RouteInfo\Tests;

use Lunr\Corona\Parsers\RouteInfo\RouteInfoParser;
use Lunr\Corona\Parsers\RouteInfo\RouteInfoValue;
use Lunr\Corona\Tests\Helpers\MockRequestValue;
use RuntimeException;

/**
 * This class contains test methods for the RouteInfoParser class.
 *
 * @backupGlobals enabled
 * @covers        Lunr\Corona\Parsers\RouteInfo\RouteInfoParser
 */
class RouteInfoParserGetTest extends RouteInfoParserTestCase
{

    /**
     * Test that getRequestValueType() returns the correct type.
     *
     * @covers Lunr\Corona\Parsers\RouteInfo\RouteInfoParser::getRequestValueType
     */
    public function testGetRequestValueType(): void
    {
        $this->assertEquals(RouteInfoValue::class, $this->class->getRequestValueType());
    }

    /**
     * Test getting an unsupported value.
     *
     * @covers Lunr\Corona\Parsers\RouteInfo\RouteInfoParser::get
     */
    public function testGetUnsupportedValue(): void
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Unsupported request value type "Lunr\Corona\Tests\Helpers\MockRequestValue"');

        $this->class->get(MockRequestValue::Foo);
    }

    /**
     * Test getting the group.
     *
     * @covers Lunr\Corona\Parsers\RouteInfo\RouteInfoParser::get
     */
    public function testGetDefaultGroup(): void
    {
        $string = 'general';

        $value = $this->class->get(RouteInfoValue::Group);

        $this->assertEquals($string, $value);
    }

    /**
     * Test getting the group.
     *
     * @covers Lunr\Corona\Parsers\RouteInfo\RouteInfoParser::get
     */
    public function testGetCustomGroup(): void
    {
        $nullValue = new RouteInfoParser('custom', '/custom/api');

        $value = $nullValue->get(RouteInfoValue::Group);

        $this->assertEquals('custom', $value);
    }

    /**
     * Test getting the name.
     *
     * @covers Lunr\Corona\Parsers\RouteInfo\RouteInfoParser::get
     */
    public function testGetDefaultName(): void
    {
        $string = 'general.pre-routing';

        $value = $this->class->get(RouteInfoValue::Name);

        $this->assertEquals($string, $value);
    }

    /**
     * Test getting the group.
     *
     * @covers Lunr\Corona\Parsers\RouteInfo\RouteInfoParser::get
     */
    public function testGetCustomName(): void
    {
        $nullValue = new RouteInfoParser('custom', '/custom/api');

        $value = $nullValue->get(RouteInfoValue::Name);

        $this->assertEquals('/custom/api', $value);
    }

    /**
     * Test getting the target.
     *
     * @covers Lunr\Corona\Parsers\RouteInfo\RouteInfoParser::get
     */
    public function testGetUnknownTarget(): void
    {
        unset($_SERVER['SCRIPT_NAME']);

        $string = 'unknown';

        $value = $this->class->get(RouteInfoValue::Target);

        $this->assertEquals($string, $value);
    }

    /**
     * Test getting the target.
     *
     * @covers Lunr\Corona\Parsers\RouteInfo\RouteInfoParser::get
     */
    public function testGetEntrypointTarget(): void
    {
        $_SERVER['SCRIPT_NAME'] = '/app/index.php';

        $string = 'index.php';

        $value = $this->class->get(RouteInfoValue::Target);

        $this->assertEquals($string, $value);
    }

    /**
     * Test getting the target.
     *
     * @covers Lunr\Corona\Parsers\RouteInfo\RouteInfoParser::get
     */
    public function testGetParsedEntrypointTarget(): void
    {
        $_SERVER['SCRIPT_NAME'] = '/app/index.php';

        $string = 'index.php';

        $value = $this->class->get(RouteInfoValue::Target);

        $this->assertEquals($string, $value);

        $_SERVER['SCRIPT_NAME'] = '/app/cli.php';

        $value = $this->class->get(RouteInfoValue::Target);

        $this->assertEquals($string, $value);
    }

}

?>
