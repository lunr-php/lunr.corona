<?php

/**
 * This file contains the FrontControllerDispatchTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2013 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Corona\Tests;

/**
 * This class contains tests for dispatching controllers with the FrontController class.
 *
 * @covers Lunr\Corona\FrontController
 */
class FrontControllerDispatchTest extends FrontControllerTestCase
{

    /**
     * Test that dispatch works correctly with an already instantiated controller.
     *
     * @covers Lunr\Corona\FrontController::dispatch
     */
    public function testDispatchWithInstantiatedController(): void
    {
        $controller = $this->getMockBuilder(MockController::class)
                           ->disableOriginalConstructor()
                           ->getMock();

        $this->handler->expects($this->once())
                      ->method('handle_request')
                      ->with([ $controller, 'foo' ], [ 1, 2 ]);

        $this->request->expects($this->exactly(2))
                      ->method('__get')
                      ->willReturnMap([
                          [ 'method', 'foo' ],
                          [ 'params', [ 1, 2 ]],
                      ]);

        $this->class->dispatch($controller);
    }

    /**
     * Test that dispatch ignores uncallable controller/method combination.
     *
     * @covers Lunr\Corona\FrontController::dispatch
     */
    public function testDispatchWithUncallableControllerMethodCombination(): void
    {
        $object = $this->getMockBuilder(Model::class)
                       ->disableOriginalConstructor()
                       ->getMock();

        $this->handler->expects($this->never())
                      ->method('handle_request');

        $this->request->expects($this->once())
                      ->method('__get')
                      ->with('method')
                      ->willReturn('baz');

        $this->class->dispatch($object);
    }

}

?>
