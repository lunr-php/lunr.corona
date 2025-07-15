<?php

/**
 * This file contains the ViewHelpersTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2012 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Corona\Tests;

/**
 * This class tests the helper methods of the view class.
 *
 * @covers Lunr\Corona\View
 */
class ViewHelpersTest extends ViewTestCase
{

    /**
     * Tests the baseUrl method of the View class.
     *
     * @param string $baseurl Baseurl value
     * @param string $path    Path to append to the baseurl
     * @param string $result  Expected combined result
     *
     * @dataProvider baseUrlProvider
     * @covers       Lunr\Corona\View::baseUrl
     */
    public function testBaseUrl($baseurl, $path, $result): void
    {
        $this->request->expects($this->once())
                      ->method('__get')
                      ->willReturn($baseurl);

        $method = $this->getReflectionMethod('baseUrl');

        $this->assertEquals($result, $method->invokeArgs($this->class, [ $path ]));
    }

    /**
     * Test that isFatalError() returns TRUE if last error is fatal.
     *
     * @param array $error Mocked error information
     *
     * @dataProvider fatalErrorInfoProvider
     * @covers       Lunr\Corona\View::isFatalError
     */
    public function testIsFatalErrorReturnsTrueIfErrorIsFatal($error): void
    {
        $method = $this->getReflectionMethod('isFatalError');

        $this->assertTrue($method->invokeArgs($this->class, [ $error ]));
    }

    /**
     * Test that isFatalError() returns FALSE if last error is fatal.
     *
     * @param array $error Mocked error information
     *
     * @dataProvider errorInfoProvider
     * @covers       Lunr\Corona\View::isFatalError
     */
    public function testIsFatalErrorReturnsFalseIfErrorIsNotFatal($error): void
    {
        $method = $this->getReflectionMethod('isFatalError');

        $this->assertFalse($method->invokeArgs($this->class, [ $error ]));
    }

}

?>
