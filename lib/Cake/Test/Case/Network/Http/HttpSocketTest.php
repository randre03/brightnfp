<?php
/**
 * HttpSocketTest file
 *
 * PHP 5
 *
 * CakePHP(tm) Tests <http://book.cakephp.org/2.0/en/development/testing.html>
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://book.cakephp.org/2.0/en/development/testing.html CakePHP(tm) Tests
 * @package       Cake.Test.Case.Network.Http
 * @since         CakePHP(tm) v 1.2.0.4206
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('HttpSocket', 'Network/Http');
App::uses('HttpResponse', 'Network/Http');

/**
 * TestAuthentication class
 *
 * @package       Cake.Test.Case.Network.Http
 */
class TestAuthentication {

/**
 * authentication method
 *
 * @param HttpSocket $http
 * @param array $authInfo
 * @return void
 */
	public static function authentication(HttpSocket $http, &$authInfo) {
		$http->request['header']['Authorization'] = 'Test ' . $authInfo['user'] . '.' . $authInfo['pass'];
	}

/**
 * proxyAuthentication method
 *
 * @param HttpSocket $http
 * @param array $proxyInfo
 * @return void
 */
	public static function proxyAuthentication(HttpSocket $http, &$proxyInfo) {
		$http->request['header']['Proxy-Authorization'] = 'Test ' . $proxyInfo['user'] . '.' . $proxyInfo['pass'];
	}

}

/**
 * CustomResponse
 *
 */
class CustomResponse {

/**
 * First 10 chars
 *
 * @var string
 */
	public $first10;

/**
 * Constructor
 *
 */
	public function __construct($message) {
		$this->first10 = substr($message, 0, 10);
	}

}

/**
 * TestHttpSocket
 *
 */
class TestHttpSocket extends HttpSocket {

/**
 * Convenience method for testing protected method
 *
 * @param string|array $uri URI (see {@link _parseUri()})
 * @return array Current configuration settings
 */
	public function configUri($uri = null) {
		return parent::_configUri($uri);
	}

/**
 * Convenience method for testing protected method
 *
 * @param string|array $uri URI to parse
 * @param boolean|array $base If true use default URI config, otherwise indexed array to set 'scheme', 'host', 'port', etc.
 * @return array Parsed URI
 */
	public function parseUri($uri = null, $base = array()) {
		return parent::_parseUri($uri, $base);
	}

/**
 * Convenience method for testing protected method
 *
 * @param array $uri A $uri array, or uses $this->config if left empty
 * @param string $uriTemplate The Uri template/format to use
 * @return string A fully qualified URL formatted according to $uriTemplate
 */
	public function buildUri($uri = array(), $uriTemplate = '%scheme://%user:%pass@%host:%port/%path?%query#%fragment') {
		return parent::_buildUri($uri, $uriTemplate);
	}

/**
 * Convenience method for testing protected method
 *
 * @param array $header Header to build
 * @return string Header built from array
 */
	public function buildHeader($header, $mode = 'standard') {
		return parent::_buildHeader($header, $mode);
	}

/**
 * Convenience method for testing protected method
 *
 * @param string|array $query A query string to parse into an array or an array to return directly "as is"
 * @return array The $query parsed into a possibly multi-level array. If an empty $query is given, an empty array is returned.
 */
	public function parseQuery($query) {
		return parent::_parseQuery($query);
	}

/**
 * Convenience method for testing protected method
 *
 * @param array $request Needs to contain a 'uri' key. Should also contain a 'method' key, otherwise defaults to GET.
 * @param string $versionToken The version token to use, defaults to HTTP/1.1
 * @return string Request line
 */
	public function buildRequestLine($request = array(), $versionToken = 'HTTP/1.1') {
		return parent::_buildRequestLine($request, $versionToken);
	}

/**
 * Convenience method for testing protected method
 *
 * @param boolean $hex true to get them as HEX values, false otherwise
 * @return array Escape chars
 */
	public function tokenEscapeChars($hex = true, $chars = null) {
		return parent::_tokenEscapeChars($hex, $chars);
	}

/**
 * Convenience method for testing protected method
 *
 * @param string $token Token to escape
 * @return string Escaped token
 */
	public function escapeToken($token, $chars = null) {
		return parent::_escapeToken($token, $chars);
	}

}

/**
 * HttpSocketTest class
 *
 * @package       Cake.Test.Case.Network.Http
 */
class HttpSocketTest extends CakeTestCase {

/**
 * Socket property
 *
 * @var mixed null
 */
	public $Socket = null;

/**
 * RequestSocket property
 *
 * @var mixed null
 */
	public $RequestSocket = null;

/**
 * This function sets up a TestHttpSocket instance we are going to use for testing
 *
 * @return void
 */
	public function setUp() {
		if (!class_exists('MockHttpSocket')) {
			$this->getMock('TestHttpSocket', array('read', 'write', 'connect'), array(), 'MockHttpSocket');
			$this->getMock('TestHttpSocket', array('read', 'write', 'connect', 'request'), array(), 'MockHttpSocketRequests');
		}

		$this->Socket = new MockHttpSocket();
		$this->RequestSocket = new MockHttpSocketRequests();
	}

/**
 * We use this function to clean up after the test case was executed
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Socket, $this->RequestSocket);
	}

/**
 * Test that HttpSocket::__construct does what one would expect it to do
 *
 * @return void
 */
	public function testConstruct() {
		$this->Socket->reset();
		$baseConfig = $this->Socket->config;
		$this->Socket->expects($this->never())->method('connect');
		$this->Socket->__construct(array('host' => 'foo-bar'));
		$baseConfig['host'] = 'foo-bar';
		$baseConfig['protocol'] = getprotobyname($baseConfig['protocol']);
		$this->assertEquals($this->Socket->config, $baseConfig);

		$this->Socket->reset();
		$baseConfig = $this->Socket->config;
		$this->Socket->__construct('http://www.cakephp.org:23/');
		$baseConfig['host'] = $baseConfig['request']['uri']['host'] = 'www.cakephp.org';
		$baseConfig['port'] = $baseConfig['request']['uri']['port'] = 23;
		$baseConfig['request']['uri']['scheme'] = 'http';
		$baseConfig['protocol'] = getprotobyname($baseConfig['protocol']);
		$this->assertEquals($this->Socket->config, $baseConfig);

		$this->Socket->reset();
		$this->Socket->__construct(array('request' => array('uri' => 'http://www.cakephp.org:23/')));
		$this->assertEquals($this->Socket->config, $baseConfig);
	}

/**
 * Test that HttpSocket::configUri works properly with different types of arguments
 *
 * @return void
 */
	public function testConfigUri() {
		$this->Socket->reset();
		$r = $this->Socket->configUri('https://bob:secret@www.cakephp.org:23/?query=foo');
		$expected = array(
			'persistent' => false,
			'host' => 'www.cakephp.org',
			'protocol' => 'tcp',
			'port' => 23,
			'timeout' => 30,
			'ssl_verify_peer' => true,
			'ssl_verify_depth' => 5,
			'ssl_verify_host' => true,
			'request' => array(
				'uri' => array(
					'scheme' => 'https',
					'host' => 'www.cakephp.org',
					'port' => 23
				),
				'redirect' => false,
				'cookies' => array(),
			)
		);
		$this->assertEquals($expected, $this->Socket->config);
		$this->assertTrue($r);
		$r = $this->Socket->configUri(array('host' => 'www.foo-bar.org'));
		$expected['host'] = 'www.foo-bar.org';
		$expected['request']['uri']['host'] = 'www.foo-bar.org';
		$this->assertEquals($expected, $this->Socket->config);
		$this->assertTrue($r);

		$r = $this->Socket->configUri('http://www.foo.com');
		$expected = array(
			'persistent' => false,
			'host' => 'www.foo.com',
			'protocol' => 'tcp',
			'port' => 80,
			'timeout' => 30,
			'ssl_verify_peer' => true,
			'ssl_verify_depth' => 5,
			'ssl_verify_host' => true,
			'request' => array(
				'uri' => array(
					'scheme' => 'http',
					'host' => 'www.foo.com',
					'port' => 80
				),
				'redirect' => false,
				'cookies' => array(),
			)
		);
		$this->assertEquals($expected, $this->Socket->config);
		$this->assertTrue($r);

		$r = $this->Socket->configUri('/this-is-broken');
		$this->assertEquals($expected, $this->Socket->config);
		$this->assertFalse($r);

		$r = $this->Socket->configUri(false);
		$this->assertEquals($expected, $this->Socket->config);
		$this->assertFalse($r);
	}

/**
 * Tests that HttpSocket::request (the heart of the HttpSocket) is working properly.
 *
 * @return void
 */
	public function testRequest() {
		$this->Socket->reset();

		$response = $this->Socket->request(true);
		$this->assertFalse($response);

		$context = array(
			'ssl' => array(
				'verify_peer' => true,
				'verify_depth' => 5,
				'CN_match' => 'www.cakephp.org',
				'cafile' => CAKE . 'Config' . DS . 'cacert.pem'
			)
		);

		$tests = array(
			array(
				'request' => 'http://www.cakephp.org/?foo=bar',
				'expectation' => array(
					'config' => array(
						'persistent' => false,
						'host' => 'www.cakephp.org',
						'protocol' => 'tcp',
						'port' => 80,
						'timeout' => 30,
						'context' => $context,
						'request' => array(
							'uri' => array(
								'scheme' => 'http',
								'host' => 'www.cakephp.org',
								'port' => 80
							),
							'redirect' => false,
							'cookies' => array()
						)
					),
					'request' => array(
						'method' => 'GET',
						'uri' => array(
							'scheme' => 'http',
							'host' => 'www.cakephp.org',
							'port' => 80,
							'user' => null,
							'pass' => null,
							'path' => '/',
							'query' => array('foo' => 'bar'),
							'fragment' => null
						),
						'version' => '1.1',
						'body' => '',
						'line' => "GET /?foo=bar HTTP/1.1\r\n",
						'header' => "Host: www.cakephp.org\r\nConnection: close\r\nUser-Agent: CakePHP\r\n",
						'raw' => "",
						'redirect' => false,
						'cookies' => array(),
						'proxy' => array(),
						'auth' => array()
					)
				)
			),
			array(
				'request' => array(
					'uri' => array(
						'host' => 'www.cakephp.org',
						'query' => '?foo=bar'
					)
				)
			),
			array(
				'request' => 'www.cakephp.org/?foo=bar'
			),
			array(
				'request' => array(
					'host' => '192.168.0.1',
					'uri' => 'http://www.cakephp.org/?foo=bar'
				),
				'expectation' => array(
					'request' => array(
						'uri' => array('host' => 'www.cakephp.org')
					),
					'config' => array(
						'request' => array(
							'uri' => array('host' => 'www.cakephp.org')
						),
						'host' => '192.168.0.1'
					)
				)
			),
			'reset4' => array(
				'request.uri.query' => array()
			),
			array(
				'request' => array(
					'header' => array('Foo@woo' => 'bar-value')
				),
				'expectation' => array(
					'request' => array(
						'header' => "Host: www.cakephp.org\r\nConnection: close\r\nUser-Agent: CakePHP\r\nFoo\"@\"woo: bar-value\r\n",
						'line' => "GET / HTTP/1.1\r\n"
					)
				)
			),
			array(
				'request' => array('header' => array('Foo@woo' => 'bar-value', 'host' => 'foo.com'), 'uri' => 'http://www.cakephp.org/'),
				'expectation' => array(
					'request' => array(
						'header' => "Host: foo.com\r\nConnection: close\r\nUser-Agent: CakePHP\r\nFoo\"@\"woo: bar-value\r\n"
					),
					'config' => array(
						'host' => 'www.cakephp.org'
					)
				)
			),
			array(
				'request' => array('header' => "Foo: bar\r\n"),
				'expectation' => array(
					'request' => array(
						'header' => "Foo: bar\r\n"
					)
				)
			),
			array(
				'request' => array('header' => "Foo: bar\r\n", 'uri' => 'http://www.cakephp.org/search?q=http_socket#ignore-me'),
				'expectation' => array(
					'request' => array(
						'uri' => array(
							'path' => '/search',
							'query' => array('q' => 'http_socket'),
							'fragment' => 'ignore-me'
						),
						'line' => "GET /search?q=http_socket HTTP/1.1\r\n"
					)
				)
			),
			'reset8' => array(
				'request.uri.query' => array()
			),
			array(
				'request' => array(
					'method' => 'POST',
					'uri' => 'http://www.cakephp.org/posts/add',
					'body' => array(
						'name' => 'HttpSocket-is-released',
						'date' => 'today'
					)
				),
				'expectation' => array(
					'request' => array(
						'method' => 'POST',
						'uri' => array(
							'path' => '/posts/add',
							'fragment' => null
						),
						'body' => "name=HttpSocket-is-released&date=today",
						'line' => "POST /posts/add HTTP/1.1\r\n",
						'header' => "Host: www.cakephp.org\r\nConnection: close\r\nUser-Agent: CakePHP\r\nContent-Type: application/x-www-form-urlencoded\r\nContent-Length: 38\r\n",
						'raw' => "name=HttpSocket-is-released&date=today"
					)
				)
			),
			array(
				'request' => array(
					'method' => 'POST',
					'uri' => 'http://www.cakephp.org:8080/posts/add',
					'body' => array(
						'name' => 'HttpSocket-is-released',
						'date' => 'today'
					)
				),
				'expectation' => array(
					'config' => array(
						'port' => 8080,
						'request' => array(
							'uri' => array(
								'port' => 8080
							)
						)
					),
					'request' => array(
						'uri' => array(
							'port' => 8080
						),
						'header' => "Host: www.cakephp.org:8080\r\nConnection: close\r\nUser-Agent: CakePHP\r\nContent-Type: application/x-www-form-urlencoded\r\nContent-Length: 38\r\n"
					)
				)
			),
			array(
				'request' => array(
					'method' => 'POST',
					'uri' => 'https://www.cakephp.org/posts/add',
					'body' => array(
						'name' => 'HttpSocket-is-released',
						'date' => 'today'
					)
				),
				'expectation' => array(
					'config' => array(
						'port' => 443,
						'request' => array(
							'uri' => array(
								'scheme' => 'https',
								'port' => 443
							)
						)
					),
					'request' => array(
						'uri' => array(
							'scheme' => 'https',
							'port' => 443
						),
						'header' => "Host: www.cakephp.org\r\nConnection: close\r\nUser-Agent: CakePHP\r\nContent-Type: application/x-www-form-urlencoded\r\nContent-Length: 38\r\n"
					)
				)
			),
			array(
				'request' => array(
					'method' => 'POST',
					'uri' => 'https://www.cakephp.org/posts/add',
					'body' => array('name' => 'HttpSocket-is-released', 'date' => 'today'),
					'cookies' => array('foo' => array('value' => 'bar'))
				),
				'expectation' => array(
					'request' => array(
						'header' => "Host: www.cakephp.org\r\nConnection: close\r\nUser-Agent: CakePHP\r\nContent-Type: application/x-www-form-urlencoded\r\nContent-Length: 38\r\nCookie: foo=bar\r\n",
						'cookies' => array(
							'foo' => array('value' => 'bar'),
						)
					)
				)
			)
		);

		$expectation = array();
		foreach ($tests as $i => $test) {
			if (strpos($i, 'reset') === 0) {
				foreach ($test as $path => $val) {
					$expectation = Hash::insert($expectation, $path, $val);
				}
				continue;
			}

			if (isset($test['expectation'])) {
				$expectation = Hash::merge($expectation, $test['expectation']);
			}
			$this->Socket->request($test['request']);

			$raw = $expectation['request']['raw'];
			$expectation['request']['raw'] = $expectation['request']['line'] . $expectation['request']['header'] . "\r\n" . $raw;

			$r = array('config' => $this->Socket->config, 'request' => $this->Socket->request);
			$this->assertEquals($r, $expectation, 'Failed test #' . $i . ' ');
			$expectation['request']['raw'] = $raw;
		}

		$this->Socket->reset();
		$request = array('method' => 'POST', 'uri' => 'http://www.cakephp.org/posts/add', 'body' => array('name' => 'HttpSocket-is-released', 'date' => 'today'));
		$response = $this->Socket->request($request);
		$this->assertEquals("name=HttpSocket-is-released&date=today", $this->Socket->request['body']);
	}

/**
 * Test the scheme + port keys
 *
 * @return void
 */
	public function testGetWithSchemeAndPort() {
		$this->Socket->reset();
		$request = array(
			'uri' => array(
				'scheme' => 'http',
				'host' => 'cakephp.org',
				'port' => 8080,
				'path' => '/',
			),
			'method' => 'GET'
		);
		$this->Socket->request($request);
		$this->assertContains('Host: cakephp.org:8080', $this->Socket->request['header']);
	}

/**
 * Test URLs like http://cakephp.org/index.php?somestring without key/value pair for query
 *
 * @return void
 */
	public function testRequestWithStringQuery() {
		$this->Socket->reset();
		$request = array(
			'uri' => array(
				'scheme' => 'http',
				'host' => 'cakephp.org',
				'path' => 