<?php
App::uses('PaypalIpnSource', 'PaypalIpn.Model/Datasource');
App::uses('HttpSocket', 'Network/Http');
App::uses('HttpResponse', 'Network/Http');

class PaypalIpnTestCase extends CakeTestCase {
  var $PaypalIpn = null;
  
  function setUp(){
  	//Mock::generatePartial('HttpSocket', 'MockHttpSocket', array('post'));
  	$this->PaypalIpn = new PaypalIpnSource(array());

      if (!class_exists('MockHttpSocket')) {
			//$this->getMock('TestHttpSocket', array('read', 'write', 'connect'), array(), 'MockHttpSocket');
			//$this->getMock('TestHttpSocket', array('read', 'write', 'connect', 'request'), array(), 'MockHttpSocketRequests');
    }
      
    $this->PaypalIpn->Http = new HttpSocket();
  }
  
  function testIsValidShouldBeFalse(){
  	$this->assertFalse($this->PaypalIpn->isValid(array()));
  }
  
  function testIsValid(){
  	$data = array(
    	'test' => 'string'
    );
    

    $this->once()->method('post')->with(array(
    	'https://www.paypal.com/cgi-bin/webscr',
    	array(
    		'test' => 'string',
    		'cmd' => '_notify-validate'
    	)));
    /*
    $this->PaypalIpn->Http->expectOnce('post', array(
    	'https://www.paypal.com/cgi-bin/webscr',
    	array(
    		'test' => 'string',
    		'cmd' => '_notify-validate'
    	)
    ));
    */
    $this->PaypalIpn->Http->setReturnValue('post', 'VERIFIED');
    $this->assertTrue($this->PaypalIpn->isValid($data));
  }
  
  function tearDown(){
    unset($this->PaypalIpn);
  }
}