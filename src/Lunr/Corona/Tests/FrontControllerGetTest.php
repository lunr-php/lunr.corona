<?php

/**
 * This file contains the FrontControllerGetTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2013 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Corona\Tests;

use RuntimeException;

/**
 * This class contains tests for getting controllers from the FrontController class.
 *
 * @covers Lunr\Corona\FrontController
 */
class FrontControllerGetTest extends FrontControllerTestCase
{

    /**
     * Test that getController() returns a FQCN.
     *
     * @covers Lunr\Corona\FrontController::getController
     */
    public function testGetControllerReturnsFQCNForExistingController(): void
    {
        $dir  = TEST_STATICS . '/Corona/';
        $fqcn = 'Project\\Package1\\FunctionController';

        $this->request->expects($this->exactly(2))
                      ->method('__get')
                      ->with('controller')
                      ->willReturn('function');

        $value = $this->class->getController($dir);

        $this->assertEquals($fqcn, $value);
    }

    /**
     * Test that getController() returns an empty string if controller not found.
     *
     * @covers Lunr\Corona\FrontController::getController
     */
    public function testGetControllerReturnsEmptyStringForNonExistingController(): void
    {
        $dir = TEST_STATICS . '/Corona/';

        $this->request->expects($this->exactly(2))
                      ->method('__get')
                      ->with('controller')
                      ->willReturn('method');

        $value = $this->class->getController($dir);

        $this->assertNull($value);
    }

    /**
     * Test that getController() returns an empty string if there is no controller info available.
     *
     * @covers Lunr\Corona\FrontController::getController
     */
    public function testGetControllerReturnsEmptyStringIfNoControllerInfoAvailable(): void
    {
        $dir = TEST_STATICS . '/Corona/';

        $this->request->expects($this->exactly(1))
                      ->method('__get')
                      ->with('controller')
                      ->willReturn(NULL);

        $value = $this->class->getController($dir);

        $this->assertNull($value);
    }

    /**
     * Test that getController() throws an exception if more than one exists.
     *
     * @covers Lunr\Corona\FrontController::getController
     */
    public function testGetControllerThrowsExceptionIfMultipleFound(): void
    {
        $dir = TEST_STATICS . '/Corona/';

        $this->request->expects($this->exactly(2))
                      ->method('__get')
                      ->with('controller')
                      ->willReturn('foo');

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Found multiple matching controllers!');

        $this->class->getController($dir);
    }

    /**
     * Test that getController() returns an empty string if the controller to find is blacklisted.
     *
     * @covers Lunr\Corona\FrontController::getController
     */
    public function testGetBlacklistedControllerReturnsEmptyString(): void
    {
        $dir = TEST_STATICS . '/Corona/';

        $this->request->expects($this->exactly(2))
                      ->method('__get')
                      ->with('controller')
                      ->willReturn('function');

        $value = $this->class->getController($dir, [ 'function' ]);

        $this->assertNull($value);
    }

    /**
     * Test that getController() returns an empty string if the controller to find is not whitelisted.
     *
     * @covers Lunr\Corona\FrontController::getController
     */
    public function testGetNotWhitelistedControllerReturnsEmptyString(): void
    {
        $dir = TEST_STATICS . '/Corona/';

        $this->request->expects($this->exactly(2))
                      ->method('__get')
                      ->with('controller')
                      ->willReturn('function');

        $value = $this->class->getController($dir, [], FALSE);

        $this->assertNull($value);
    }

    /**
     * Test that getController() returns a FQCN if the controller to find is whitelisted.
     *
     * @covers Lunr\Corona\FrontController::getController
     */
    public function testGetWhitelistedControllerReturnsFQCNForExistingController(): void
    {
        $dir  = TEST_STATICS . '/Corona/';
        $fqcn = 'Project\\Package1\\FunctionController';

        $this->request->expects($this->exactly(2))
                      ->method('__get')
                      ->with('controller')
                      ->willReturn('function');

        $value = $this->class->getController($dir, [ 'function' ], FALSE);

        $this->assertEquals($fqcn, $value);
    }

    /**
     * Test that getController() returns '' for invalid controller.
     *
     * @param array $controllerName Invalid controller names
     *
     * @dataProvider invalidControllerNameValuesProvider
     * @covers Lunr\Corona\FrontController::getController
     */
    public function testGetControllerReturnsDefault($controllerName): void
    {
        $dir = 'src';

        $this->request->expects($this->exactly(2))
                      ->method('__get')
                      ->with('controller')
                      ->willReturn($controllerName);

        $value = $this->class->getController($dir);

        $this->assertNull($value);
    }

    /**
     * Test that getController() returns a FQCN for dashes in the controller
     *
     * @covers Lunr\Corona\FrontController::getController
     */
    public function testGetControllerForDashesInController(): void
    {
        $dir  = TEST_STATICS . '/Corona/';
        $fqcn = 'Project\\Package1\\AnonymousTapsController';

        $this->request->expects($this->exactly(2))
                      ->method('__get')
                      ->with('controller')
                      ->willReturn('anonymous-taps');

        $value = $this->class->getController($dir);

        $this->assertEquals($fqcn, $value);
    }

    /**
     * Test that get_controller() returns a FQCN.
     *
     * @covers Lunr\Corona\FrontController::get_controller
     */
    public function testDeprecatedGetControllerReturnsFQCNForExistingController(): void
    {
        $dir  = TEST_STATICS . '/Corona/';
        $fqcn = 'Project\\Package1\\FunctionController';

        $this->request->expects($this->exactly(2))
                      ->method('__get')
                      ->with('controller')
                      ->willReturn('function');

        $value = $this->class->get_controller($dir);

        $this->assertEquals($fqcn, $value);
    }

    /**
     * Test that get_controller() returns an empty string if controller not found.
     *
     * @covers Lunr\Corona\FrontController::get_controller
     */
    public function testDeprecatedGetControllerReturnsEmptyStringForNonExistingController(): void
    {
        $dir = TEST_STATICS . '/Corona/';

        $this->request->expects($this->exactly(2))
                      ->method('__get')
                      ->with('controller')
                      ->willReturn('method');

        $value = $this->class->get_controller($dir);

        $this->assertNull($value);
    }

    /**
     * Test that get_controller() returns an empty string if there is no controller info available.
     *
     * @covers Lunr\Corona\FrontController::get_controller
     */
    public function testDeprecatedGetControllerReturnsEmptyStringIfNoControllerInfoAvailable(): void
    {
        $dir = TEST_STATICS . '/Corona/';

        $this->request->expects($this->exactly(1))
                      ->method('__get')
                      ->with('controller')
                      ->willReturn(NULL);

        $value = $this->class->get_controller($dir);

        $this->assertNull($value);
    }

    /**
     * Test that get_controller() throws an exception if more than one exists.
     *
     * @covers Lunr\Corona\FrontController::get_controller
     */
    public function testDeprecatedGetControllerThrowsExceptionIfMultipleFound(): void
    {
        $dir = TEST_STATICS . '/Corona/';

        $this->request->expects($this->exactly(2))
                      ->method('__get')
                      ->with('controller')
                      ->willReturn('foo');

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Found multiple matching controllers!');

        $this->class->get_controller($dir);
    }

    /**
     * Test that get_controller() returns an empty string if the controller to find is blacklisted.
     *
     * @covers Lunr\Corona\FrontController::get_controller
     */
    public function testDeprecatedGetBlacklistedControllerReturnsEmptyString(): void
    {
        $dir = TEST_STATICS . '/Corona/';

        $this->request->expects($this->exactly(2))
                      ->method('__get')
                      ->with('controller')
                      ->willReturn('function');

        $value = $this->class->get_controller($dir, [ 'function' ]);

        $this->assertNull($value);
    }

    /**
     * Test that get_controller() returns an empty string if the controller to find is not whitelisted.
     *
     * @covers Lunr\Corona\FrontController::get_controller
     */
    public function testDeprecatedGetNotWhitelistedControllerReturnsEmptyString(): void
    {
        $dir = TEST_STATICS . '/Corona/';

        $this->request->expects($this->exactly(2))
                      ->method('__get')
                      ->with('controller')
                      ->willReturn('function');

        $value = $this->class->get_controller($dir, [], FALSE);

        $this->assertNull($value);
    }

    /**
     * Test that get_controller() returns a FQCN if the controller to find is whitelisted.
     *
     * @covers Lunr\Corona\FrontController::get_controller
     */
    public function testDeprecatedGetWhitelistedControllerReturnsFQCNForExistingController(): void
    {
        $dir  = TEST_STATICS . '/Corona/';
        $fqcn = 'Project\\Package1\\FunctionController';

        $this->request->expects($this->exactly(2))
                      ->method('__get')
                      ->with('controller')
                      ->willReturn('function');

        $value = $this->class->get_controller($dir, [ 'function' ], FALSE);

        $this->assertEquals($fqcn, $value);
    }

    /**
     * Test that get_controller() returns '' for invalid controller.
     *
     * @param array $controllerName Invalid controller names
     *
     * @dataProvider invalidControllerNameValuesProvider
     * @covers Lunr\Corona\FrontController::get_controller
     */
    public function testDeprecatedGetControllerReturnsDefault($controllerName): void
    {
        $dir = 'src';

        $this->request->expects($this->exactly(2))
                      ->method('__get')
                      ->with('controller')
                      ->willReturn($controllerName);

        $value = $this->class->get_controller($dir);

        $this->assertNull($value);
    }

    /**
     * Test that get_controller() returns a FQCN for dashes in the controller
     *
     * @covers Lunr\Corona\FrontController::get_controller
     */
    public function testDeprecatedGetControllerForDashesInController(): void
    {
        $dir  = TEST_STATICS . '/Corona/';
        $fqcn = 'Project\\Package1\\AnonymousTapsController';

        $this->request->expects($this->exactly(2))
                      ->method('__get')
                      ->with('controller')
                      ->willReturn('anonymous-taps');

        $value = $this->class->get_controller($dir);

        $this->assertEquals($fqcn, $value);
    }

}

?>
