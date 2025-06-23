<?php

/**
 * This file contains the ActionCliParserGetTest class.
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
 * This class contains test methods for the ActionCliParser class.
 *
 * @backupGlobals enabled
 * @covers        Lunr\Corona\Parsers\Action\ActionCliParser
 */
class ActionCliParserGetTest extends ActionCliParserTestCase
{

    /**
     * Test that getRequestValueType() returns the correct type.
     *
     * @covers Lunr\Corona\Parsers\Action\ActionCliParser::getRequestValueType
     */
    public function testGetRequestValueType()
    {
        $this->assertEquals(ActionValue::class, $this->class->getRequestValueType());
    }

    /**
     * Test getting an unsupported value.
     *
     * @covers Lunr\Corona\Parsers\Action\ActionCliParser::get
     */
    public function testGetUnsupportedValue()
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Unsupported request value type "Lunr\Corona\Tests\Helpers\MockRequestValue"');

        $this->class->get(MockRequestValue::Foo);
    }

    /**
     * Test getting a parsed action.
     *
     * @covers Lunr\Corona\Parsers\Action\ActionCliParser::get
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
     * Test getting a parsed action.
     *
     * @covers Lunr\Corona\Parsers\Action\ActionCliParser::get
     */
    public function testGetParsedNullAction()
    {
        $this->setReflectionPropertyValue('action', NULL);
        $this->setReflectionPropertyValue('actionInitialized', TRUE);

        $value = $this->class->get(ActionValue::Action);

        $this->assertNull($value);
    }

    /**
     * Test getting a parsed action.
     *
     * @covers Lunr\Corona\Parsers\Action\ActionCliParser::get
     */
    public function testGetAction()
    {
        $action = HttpMethod::Get;

        $value = $this->class->get(ActionValue::Action);

        $this->assertEquals($action->value, $value);
        $this->assertPropertySame('action', $action);
    }

    /**
     * Test getting a parsed action.
     *
     * @covers Lunr\Corona\Parsers\Action\ActionCliParser::getAsEnum
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
     * Test getting a parsed action.
     *
     * @covers Lunr\Corona\Parsers\Action\ActionCliParser::getAsEnum
     */
    public function testGetParsedNullActionAsEnum()
    {
        $this->setReflectionPropertyValue('action', NULL);
        $this->setReflectionPropertyValue('actionInitialized', TRUE);

        $value = $this->class->getAsEnum(ActionValue::Action);

        $this->assertNull($value);
    }

}

?>
