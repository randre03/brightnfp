<?php
/**
 * SmtpTransportTest file
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
 * @package       Cake.Test.Case.Network.Email
 * @since         CakePHP(tm) v 2.0.0
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('CakeEmail', 'Network/Email');
App::uses('AbstractTransport', 'Network/Email');
App::uses('SmtpTransport', 'Network/Email');

/**
 * Help to test SmtpTransport
 *
 */
class SmtpTestTransport extends SmtpTransport {

/**
 * Helper to change the socket
 *
 * @param object $socket
 * @return void
 */
	public function setSocket(CakeSocket $socket) {
		$this->_socket = $socket;
	}

/**
 * Helper to change the CakeEmail
 *
 * @param object $cakeEmail
 * @return void
 */
	public function setCakeEmail($cakeEmail) {
		$this->_cakeEmail = $cakeEmail;
	}

/**
 * Disabled the socket change
 *
 * @return void
 */
	protected function _generateSocket() {
	}

/**
 * Magic function to call protected methods
 *
 * @param string $method
 * @param string $args
 * @return mixed
 */
	public function __call($method, $args) {
		$method = '_' . $method;
		return $this->$method();
	}

}

/**
 * Test case
 *
 */
class SmtpTransportTest extends CakeTestCase {

/**
 * Setup
 *
 * @return void
 */
	public function setUp() {
		if (!class_exists('MockSocket')) {
			$this->getMock('CakeSocket', array('read', 'write', 'connect', 'enableCrypto'), array(), 'MockSocket');
		}
		$this->socket = new MockSocket();

		$this->SmtpTransport = new SmtpTestTransport();
		$this->SmtpTransport->setSocket($this->socket);
		$this->SmtpTransport->config(array('client' => 'localhost'));
	}

/**
 * testConnectEhlo method
 *
 * @return void
 */
	public function testConnectEhlo() {
		$this->socket->expects($this->any())->method('connect')->will($this->returnValue(true));
		$this->socket->expects($this->at(0))->method('read')->will($this->returnValue(false));
		$this->socket->expects($this->at(1))->method('read')->will($this->returnValue("220 Welcome message\r\n"));
		$this->socket->expects($this->at(2))->method('write')->with("EHLO localhost\r\n");
		$this->socket->expects($this->at(3))->method('read')->will($this->returnValue(false));
		$this->socket->expects($this->at(4))->method('read')->will($this->returnValue("250 Accepted\r\n"));
		$this->SmtpTransport->connect();
	}

/**
 * testConnectEhloTls method
 *
 * @return void
 */
	public function testConnectEhloTls() {
		$this->SmtpTransport->config(array('tls' => true));
		$this->socket->expects($this->any())->method('connect')->will($this->returnValue(true));
		$this->socket->expects($this->at(0))->method('read')->will($this->returnValue(false));
		$this->socket->expects($this->at(1))->method('read')->will($this->returnValue("220 Welcome message\r\n"));
		$this->socket->expects($this->at(2))->method('write')->with("EHLO localhost\r\n");
		$this->socket->expects($this->at(3))->method('read')->will($this->returnValue(false));
		$this->socket->expects($this->at(4))->method('read')->will($this->returnValue("250 Accepted\r\n"));
		$this->socket->expects($this->at(5))->method('write')->with("STARTTLS\r\n");
		$this->socket->expects($this->at(6))->method('read')->will($this->returnValue(false));
		$this->socket->expects($this->at(7))->method('read')->will($this->returnValue("220 Server ready\r\n"));
		$this->socket->expects($this->at(8))->method('other')->with('tls')->will($this->returnValue(true));
		$this->socket->expects($this->at(9))->method('write')->with("EHLO localhost\r\n");
		$this->socket->expects($this->at(10))->method('read')->will($this->returnValue(false));
		$this->socket->expects($this->at(11))->method('read')->will($this->returnValue("250 Accepted\r\n"));
		$this->SmtpTransport->connect();
	}

/**
 * testConnectEhloTlsOnNonTlsServer method
 *
 * @expectedException SocketException
 * @return void
 */
	public function testConnectEhloTlsOnNonTlsServer() {
		$this->SmtpTransport->config(array('tls' => true));
		$this->socket->expects($this->any())->method('connect')->will($this->returnValue(true));
		$this->socket->expects($this->at(0))->method('read')->will($this->returnValue(false));
		$this->socket->expects($this->at(1))->method('read')->will($this->returnValue("220 Welcome message\r\n"));
		$this->socket->expects($this->at(2))->method('write')->with("EHLO localhost\r\n");
		$this->socket->expects($this->at(3))->method('read')->will($this->returnValue(false));
		$this->socket->expects($this->at(4))->method('read')->will($this->returnValue("250 Accepted\r\n"));
		$this->socket->expects($this->at(5))->method('write')->with("STARTTLS\r\n");
		$this->socket->expects($this->at(6))->method('read')->will($this->returnValue(false));
		$this->socket->expects($this->at(7))->method('read')->will($this->returnValue("500 5.3.3 Unrecognized command\r\n"));
		$this->SmtpTransport->connect();
	}

/**
 * testConnectEhloNoTlsOnRequiredTlsServer method
 *
 * @expectedException SocketException
 * @return void
 */
	public function testConnectEhloNoTlsOnRequiredTlsServer() {
		$this->SmtpTransport->config(array('tls' => false, 'username' => 'user', 'password' => 'pass'));
		$this->socket->expects($this->any())->method('connect')->will($this->returnValue(true));
		$this->socket->expects($this->at(0))->method('read')->will($this->returnValue(false));
		$this->socket->expects($this->at(1))->method('read')->will($this->returnValue("220 Welcome message\r\n"));
		$this->socket->expects($this->at(2))->method('write')->with("EHLO localhost\r\n");
		$this->socket->expects($this->at(3))->method('read')->will($this->returnValue(false));
		$this->socket->expects($this->at(4))->method('read')->will($this->returnValue("250 Accepted\r\n"));
		$this->socket->expects($this->at(5))->method('read')->with("AUTH LOGIN\r\n");
		$this->socket->expects($this->at(6))->method('read')->will($this->returnValue(false));
		$this->socket->expects($this->at(7))->method('read')->will($this->returnValue("504 5.7.4 Unrecognized authentication type\r\n"));
		$this->SmtpTransport->connect();
		$this->SmtpTransport->auth();
	}

/**
 * testConnectHelo method
 *
 * @return void
 */
	public function testConnectHelo() {
		$this->socket->expects($this->any())->method('connect')->will($this->returnValue(true));
		$this->socket->expects($this->at(0))->method('read')->will($this->returnValue(false));
		$this->socket->expects($this->at(1))->method('read')->will($this->returnValue("220 Welcome message\r\n"));
		$this->socket->expects($this->at(2))->method('write')->with("EHLO localhost\r\n");
		$this->socket->expects($this->at(3))->method('read')->will($this->returnValue(false));
		$this->socket->expects($this->at(4))->method('read')->will($this->returnValue("200 Not Accepted\r\n"));
		$this->socket->expects($this->at(5))->metho