<?php

/**
 * This file contains the ActionHttpParserGetTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2025 Framna Netherlands B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Corona\Parsers\Action\Tests;

use Lunr\Corona\HttpMethod;
use Lunr\Corona\Parsers\Action\ActionValue;
use Lunr\Corona\Tests\Helpers\MockRequestValue;
use RuntimeException;

/**
 * This class contains test methods for the ActionHttpParser class.
 *
 * @backupGlobals enabled
 * @covers        Lunr\Corona\Parsers\Action\ActionHttpParser
 */
class ActionHttpParserGetTest extends ActionHttpParserTestCase
{

    /**
     * Test that getRequestValueType() returns the correct type.
     *
     * @covers Lunr\Corona\Parsers\Action\ActionHttpParser::getRequestValueType
     */
    public function testGetRequestValueType()
    {
        $this->assertEquals(ActionValue::class, $this->class->getRequestValueType());
    }

    /**
     * Test getting an unsupported value.
     *
     * @covers Lunr\Corona\Parsers\Action\ActionHttpParser::get
     */
    public function testGetUnsupportedValue()
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Unsupported request value type "Lunr\Corona\Tests\Helpers\MockRequestValue"');

        $this->class->get(MockRequestValue::Foo);
    }

    /**
     * Test getting a parsed request action.
     *
     * @covers Lunr\Corona\Parsers\Action\ActionHttpParser::get
     */
    public function testGetParsedAction()
    {
        $action = HttpMethod::Get;

        $this->setReflectionPropertyValue('action', $action);
        $this->setReflectionPropertyValue('actionInitialized', TRUE);

        $value = $this->class->get(ActionValue::Action);

        $this->assertEquals($action->value, $value);
    }

    /**
     * Test getting a parsed request action.
     *
     * @covers Lunr\Corona\Parsers\Action\ActionHttpParser::get
     */
    public function testGetParsedNullAction()
    {
        $this->setReflectionPropertyValue('action', NULL);
        $this->setReflectionPropertyValue('actionInitialized', TRUE);

        $value = $this->class->get(ActionValue::Action);

        $this->assertNull($value);
    }

    /**
     * Test getting a request action when it's missing in the header.
     *
     * @covers Lunr\Corona\Parsers\Action\ActionHttpParser::get
     */
    public function testGetActionWithMissingHeader()
    {
        $value = $this->class->get(ActionValue::Action);

        $this->assertNull($value);
        $this->assertPropertySame('action', NULL);
    }

    /**
     * Test getting a parsed request action.
     *
     * @covers Lunr\Corona\Parsers\Action\ActionHttpParser::get
     */
    public function testGetAction()
    {
        $action = HttpMethod::Get;

        $_SERVER['REQUEST_METHOD'] = 'GET';

        $value = $this->class->get(ActionValue::Action);

        $this->assertEquals($action->value, $value);
        $this->assertPropertySame('action', $action);
    }

    /**
     * Test getting a parsed request action.
     *
     * @covers Lunr\Corona\Parsers\Action\ActionHttpParser::getAsEnum
     */
    public function testGetParsedActionAsEnum()
    {
        $action = HttpMethod::Get;

        $this->setReflectionPropertyValue('action', $action);
        $this->setReflectionPropertyValue('actionInitialized', TRUE);

        $value = $this->class->getAsEnum(ActionValue::Action);

        $this->assertEquals($action, $value);
    }

    /**
     * Test getting a parsed request action.
     *
     * @covers Lunr\Corona\Parsers\Action\ActionHttpParser::getAsEnum
     */
    public function testGetParsedNullActionAsEnum()
    {
        $this->setReflectionPropertyValue('action', NULL);
        $this->setReflectionPropertyValue('actionInitialized', TRUE);

        $value = $this->class->getAsEnum(ActionValue::Action);

        $this->assertNull($value);
    }

    /**
     * Test getting a request action when it's missing in the header.
     *
     * @covers Lunr\Corona\Parsers\Action\ActionHttpParser::getAsEnum
     */
    public function testGetActionWithMissingHeaderAsEnum()
    {
        $value = $this->class->getAsEnum(ActionValue::Action);

        $this->assertNull($value);
        $this->assertPropertySame('action', NULL);
    }

    /**
     * Test getting a parsed request action.
     *
     * @covers Lunr\Corona\Parsers\Action\ActionHttpParser::getAsEnum
     */
    public function testGetActionAsEnum()
    {
        $action = HttpMethod::Get;

        $_SERVER['REQUEST_METHOD'] = 'GET';

        $value = $this->class->getAsEnum(ActionValue::Action);

        $this->assertEquals($action, $value);
        $this->assertPropertySame('action', $action);
    }

}

?>
