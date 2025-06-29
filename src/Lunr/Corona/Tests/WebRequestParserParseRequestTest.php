<?php

/**
 * This file contains the WebRequestParserParseRequestTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2014 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Corona\Tests;

use Lunr\Corona\HttpMethod;
use Lunr\Corona\Tests\Helpers\RequestParserDynamicRequestTestTrait;

/**
 * Basic tests for the case of empty superglobals.
 *
 * @covers        Lunr\Corona\WebRequestParser
 * @backupGlobals enabled
 */
class WebRequestParserParseRequestTest extends WebRequestParserTestCase
{

    use RequestParserDynamicRequestTestTrait;

    /**
     * Preparation work for the request tests.
     *
     * @param string $protocol  Protocol name
     * @param string $port      Port number
     * @param bool   $useragent Whether to include useragent information or not
     * @param string $key       Device useragent key
     *
     * @return void
     */
    protected function prepare_request_test($protocol = 'HTTP', $port = '80', $useragent = FALSE, $key = ''): void
    {
        if (!extension_loaded('uuid'))
        {
            $this->markTestSkipped('Extension uuid is required.');
        }

        $this->mockFunction('gethostname', fn() => 'Lunr');
        $this->mockFunction('uuid_create', fn() => '962161b2-7a01-41f3-84c6-3834ad001adf');

        $_SERVER['SCRIPT_NAME'] = '/path/to/index.php';

        if ($protocol == 'TERMINATED_HTTPS')
        {
            $_SERVER['HTTP_X_FORWARDED_PROTO'] = 'https';
        }
        elseif ($protocol == 'PROXIED_HTTP')
        {
            $_SERVER['HTTP_X_FORWARDED_PROTO'] = 'http';
        }
        elseif ($protocol == 'MIXED_HTTPS')
        {
            $_SERVER['HTTP_X_FORWARDED_PROTO'] = 'https';
            $_SERVER['HTTPS']                  = 'off';
        }
        elseif ($protocol == 'MIXED_HTTP')
        {
            $_SERVER['HTTP_X_FORWARDED_PROTO'] = 'http';
            $_SERVER['HTTPS']                  = 'on';
        }
        else
        {
            $_SERVER['HTTPS'] = $protocol === 'HTTPS' ? 'on' : 'off';
        }

        $_SERVER['HTTP_HOST']   = 'www.domain.com';
        $_SERVER['SERVER_NAME'] = 'www.domain.com';
        $_SERVER['SERVER_PORT'] = $port;

        $_SERVER['SCRIPT_FILENAME'] = '/full/path/to/index.php';

        if ($useragent !== TRUE)
        {
            return;
        }

        $_SERVER['HTTP_USER_AGENT'] = 'UserAgent';

        if ($key == '')
        {
            return;
        }

        $_SERVER[$key] = 'Device UserAgent';
    }

    /**
     * Preparation work for the request tests.
     *
     * @param bool $controller Whether to set a controller value
     * @param bool $method     Whether to set a method value
     * @param bool $override   Whether to override default values or not
     *
     * @return void
     */
    protected function prepare_request_data($controller = TRUE, $method = TRUE, $override = FALSE): void
    {
        $map = [];

        if ($controller === TRUE)
        {
            $map[] = [ 'default_controller', 'DefaultController' ];
        }

        if ($method === TRUE)
        {
            $map[] = [ 'default_method', 'default_method' ];
        }

        $this->configuration->expects($this->any())
                            ->method('offsetGet')
                            ->willReturnMap($map);

        if ($override === FALSE)
        {
            return;
        }

        if ($controller === TRUE)
        {
            $_GET[$this->controller] = 'thecontroller';
        }

        if ($method === TRUE)
        {
            $_GET[$this->method] = 'themethod';
        }

        $_GET[$this->params . '1'] = 'parama';
        $_GET[$this->params . '2'] = 'paramb';
        $_GET['data']              = 'value';
    }

    /**
     * Preparation work for the request tests.
     *
     * @param bool $controller Whether to set a controller value
     * @param bool $method     Whether to set a method value
     *
     * @return void
     */
    protected function prepare_request_data_with_slashes($controller = TRUE, $method = TRUE): void
    {
        if ($controller === TRUE)
        {
            $_GET[$this->controller] = '/thecontroller//';
        }

        if ($method === TRUE)
        {
            $_GET[$this->method] = '/themethod/';
        }

        $_GET[$this->params . '1'] = '/parama/';
        $_GET[$this->params . '2'] = '//paramb/';
    }

    /**
     * Cleanup work for the request tests.
     *
     * @return void
     */
    private function cleanup_request_test(): void
    {
        $this->unmockFunction('gethostname');
        $this->unmockFunction('uuid_create');
    }

    /**
     * Unit Test Data Provider for possible base_url values and parameters.
     *
     * @return array $base Array of base_url parameters and possible values
     */
    public static function baseurlProvider(): array
    {
        $base   = [];
        $base[] = [ 'HTTPS', '443', 'https://www.domain.com/path/to/' ];
        $base[] = [ 'HTTPS', '80', 'https://www.domain.com:80/path/to/' ];
        $base[] = [ 'HTTP', '80', 'http://www.domain.com/path/to/' ];
        $base[] = [ 'HTTP', '443', 'http://www.domain.com:443/path/to/' ];

        return $base;
    }

    /**
     * Unit Test Data Provider for possible controller key names.
     *
     * @return array $base Array of controller key names
     */
    public static function controllerKeyNameProvider(): array
    {
        $value   = [];
        $value[] = [ 'controller' ];

        return $value;
    }

    /**
     * Unit Test Data Provider for possible method key names.
     *
     * @return array $base Array of method key names
     */
    public static function methodKeyNameProvider(): array
    {
        $value   = [];
        $value[] = [ 'method' ];

        return $value;
    }

    /**
     * Unit Test Data Provider for possible parameter key names.
     *
     * @return array $base Array of parameter key names
     */
    public static function paramsKeyNameProvider(): array
    {
        $value   = [];
        $value[] = [ 'param' ];

        return $value;
    }

    /**
     * Unit Test Data Provider for Device Useragent keys in $_SERVER.
     *
     * @return array $keys Array of array keys.
     */
    public static function deviceUserAgentKeyProvider(): array
    {
        $keys   = [];
        $keys[] = [ 'HTTP_X_DEVICE_USER_AGENT' ];
        $keys[] = [ 'HTTP_X_ORIGINAL_USER_AGENT' ];
        $keys[] = [ 'HTTP_X_OPERAMINI_PHONE_UA' ];
        $keys[] = [ 'HTTP_X_SKYFIRE_PHONE' ];
        $keys[] = [ 'HTTP_X_BOLT_PHONE_UA' ];
        $keys[] = [ 'HTTP_DEVICE_STOCK_UA' ];
        $keys[] = [ 'HTTP_X_UCBROWSER_DEVICE_UA' ];

        return $keys;
    }

    /**
     * Test that parse_request() unsets request data in the $_GET super global variable.
     *
     * @covers Lunr\Corona\WebRequestParser::parse_request
     */
    public function testParseRequestRemovesRequestDataFromGet(): void
    {
        $this->prepare_request_test('HTTP', '80');
        $this->prepare_request_data(TRUE, TRUE, TRUE);

        $this->class->parse_request();

        $this->assertIsArray($_GET);
        $this->assertCount(1, $_GET);
        $this->assertArrayHasKey('data', $_GET);
        $this->assertEquals('value', $_GET['data']);

        $this->cleanup_request_test();
    }

    /**
     * Test that parse_request() sets $requestParsed to TRUE.
     *
     * @covers Lunr\Corona\WebRequestParser::parse_request
     */
    public function testParseRequestSetsRequestParsedTrue(): void
    {
        $this->prepare_request_test('HTTP', '80');
        $this->prepare_request_data(TRUE, TRUE, TRUE);

        $this->class->parse_request();

        $this->assertTrue($this->getReflectionPropertyValue('requestParsed'));

        $this->cleanup_request_test();
    }

    /**
     * Test that parse_request() returns an empty array if the data has already been parsed.
     *
     * @covers Lunr\Corona\WebRequestParser::parse_request
     */
    public function testParseRequestReturnsEmptyArrayIfAlreadyParsed(): void
    {
        $this->prepare_request_test('HTTP', '80');
        $this->prepare_request_data(TRUE, TRUE, TRUE);

        $this->setReflectionPropertyValue('requestParsed', TRUE);

        $this->assertArrayEmpty($this->class->parse_request());

        $this->cleanup_request_test();
    }

    /**
     * Test that parse_request() returns correct protocol for http request.
     *
     * @covers Lunr\Corona\WebRequestParser::parse_request
     */
    public function testParseRequestForHttpRequest(): void
    {
        $this->prepare_request_test('HTTP', '80');
        $this->prepare_request_data(TRUE, TRUE, TRUE);

        $request = $this->class->parse_request();

        $this->assertIsArray($request);
        $this->assertArrayHasKey('protocol', $request);
        $this->assertEquals('http', $request['protocol']);

        $this->cleanup_request_test();
    }

    /**
     * Test that parse_request() returns correct protocol for https request.
     *
     * @covers Lunr\Corona\WebRequestParser::parse_request
     */
    public function testParseRequestForHttpsRequest(): void
    {
        $this->prepare_request_test('HTTPS', '443');
        $this->prepare_request_data(TRUE, TRUE, TRUE);

        $request = $this->class->parse_request();

        $this->assertIsArray($request);
        $this->assertArrayHasKey('protocol', $request);
        $this->assertEquals('https', $request['protocol']);

        $this->cleanup_request_test();
    }

    /**
     * Test that parse_request() returns correct protocol for proxied http request.
     *
     * @covers Lunr\Corona\WebRequestParser::parse_request
     */
    public function testParseRequestForProxiedHttpRequest(): void
    {
        $this->prepare_request_test('PROXIED_HTTP', '80');
        $this->prepare_request_data(TRUE, TRUE, TRUE);

        $request = $this->class->parse_request();

        $this->assertIsArray($request);
        $this->assertArrayHasKey('protocol', $request);
        $this->assertEquals('http', $request['protocol']);

        $this->cleanup_request_test();
    }

    /**
     * Test that parse_request() returns correct protocol for terminated https request.
     *
     * @covers Lunr\Corona\WebRequestParser::parse_request
     */
    public function testParseRequestForSSLterminationRequest(): void
    {
        $this->prepare_request_test('TERMINATED_HTTPS', '443');
        $this->prepare_request_data(TRUE, TRUE, TRUE);

        $request = $this->class->parse_request();

        $this->assertIsArray($request);
        $this->assertArrayHasKey('protocol', $request);
        $this->assertEquals('https', $request['protocol']);

        $this->cleanup_request_test();
    }

    /**
     * Test that parse_request() returns correct protocol for proxied https request.
     *
     * @covers Lunr\Corona\WebRequestParser::parse_request
     */
    public function testParseRequestForProxiedHttpsRequest(): void
    {
        $this->prepare_request_test('MIXED_HTTPS', '443');
        $this->prepare_request_data(TRUE, TRUE, TRUE);

        $request = $this->class->parse_request();

        $this->assertIsArray($request);
        $this->assertArrayHasKey('protocol', $request);
        $this->assertEquals('https', $request['protocol']);

        $this->cleanup_request_test();
    }

    /**
     * Test that parse_request() returns correct protocol for proxied http request.
     *
     * @covers Lunr\Corona\WebRequestParser::parse_request
     */
    public function testParseRequestForproxiedMixedHttpRequest(): void
    {
        $this->prepare_request_test('MIXED_HTTP', '443');
        $this->prepare_request_data(TRUE, TRUE, TRUE);

        $request = $this->class->parse_request();

        $this->assertIsArray($request);
        $this->assertArrayHasKey('protocol', $request);
        $this->assertEquals('http', $request['protocol']);

        $this->cleanup_request_test();
    }

    /**
     * Test that parse_request() sets domain from http post.
     *
     * @covers Lunr\Corona\WebRequestParser::parse_request
     */
    public function testParseRequestSetsDomainFromHttpHost(): void
    {
        $this->prepare_request_test();
        $this->prepare_request_data();

        $_SERVER['HTTP_HOST']   = 'www.http_post_domain.com';
        $_SERVER['SERVER_NAME'] = 'www.server_name_domain.com';

        $request = $this->class->parse_request();

        $this->assertIsArray($request);
        $this->assertArrayHasKey('base_url', $request);
        $this->assertEquals('http://www.http_post_domain.com/path/to/', $request['base_url']);

        $this->cleanup_request_test();
    }

    /**
     * Test that parse_request() sets domain from server name if http host not defined.
     *
     * @covers Lunr\Corona\WebRequestParser::parse_request
     */
    public function testParseRequestSetsDomainFromServerNameIfHttpHostNotDefined(): void
    {
        $this->prepare_request_test();
        $this->prepare_request_data();

        unset($_SERVER['HTTP_HOST']);
        $_SERVER['SERVER_NAME'] = 'www.server_name_domain.com';

        $request = $this->class->parse_request();

        $this->assertIsArray($request);
        $this->assertArrayHasKey('base_url', $request);
        $this->assertEquals('http://www.server_name_domain.com/path/to/', $request['base_url']);

        $this->cleanup_request_test();
    }

    /**
     * Test that parse_request() sets default http method.
     *
     * @covers Lunr\Corona\WebRequestParser::parse_request
     */
    public function testParseRequestSetsHttpMethod(): void
    {
        $this->prepare_request_test();
        $this->prepare_request_data();

        $_SERVER['REQUEST_METHOD'] = 'POST';

        $request = $this->class->parse_request();

        $this->assertIsArray($request);
        $this->assertArrayHasKey('action', $request);
        $this->assertEquals(HttpMethod::POST, $request['action']);

        $this->cleanup_request_test();
    }

}

?>
