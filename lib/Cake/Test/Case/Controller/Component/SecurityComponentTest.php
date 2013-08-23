<?php
/**
 * SecurityComponentTest file
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
 * @package       Cake.Test.Case.Controller.Component
 * @since         CakePHP(tm) v 1.2.0.5435
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('SecurityComponent', 'Controller/Component');
App::uses('Controller', 'Controller');

/**
 * TestSecurityComponent
 *
 * @package       Cake.Test.Case.Controller.Component
 */
class TestSecurityComponent extends SecurityComponent {

/**
 * validatePost method
 *
 * @param Controller $controller
 * @return boolean
 */
	public function validatePost(Controller $controller) {
		return $this->_validatePost($controller);
	}

}

/**
 * SecurityTestController
 *
 * @package       Cake.Test.Case.Controller.Component
 */
class SecurityTestController extends Controller {

/**
 * components property
 *
 * @var array
 */
	public $components = array('Session', 'TestSecurity');

/**
 * failed property
 *
 * @var boolean false
 */
	public $failed = false;

/**
 * Used for keeping track of headers in test
 *
 * @var array
 */
	public $testHeaders = array();

/**
 * fail method
 *
 * @return void
 */
	public function fail() {
		$this->failed = true;
	}

/**
 * redirect method
 *
 * @param string|array $url
 * @param mixed $code
 * @param mixed $exit
 * @return void
 */
	public function redirect($url, $status = null, $exit = true) {
		return $status;
	}

/**
 * Convenience method for header()
 *
 * @param string $status
 * @return void
 */
	public function header($status) {
		$this->testHeaders[] = $status;
	}

}

class BrokenCallbackController extends Controller {

	public $name = 'UncallableCallback';

	public $components = array('Session', 'TestSecurity');

	public function index() {
	}

	protected function _fail() {
	}

}

/**
 * SecurityComponentTest class
 *
 * @package       Cake.Test.Case.Controller.Component
 */
class SecurityComponentTest extends CakeTestCase {

/**
 * Controller property
 *
 * @var SecurityTestController
 */
	public $Controller;

/**
 * oldSalt property
 *
 * @var string
 */
	public $oldSalt;

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();

		$request = new CakeRequest('posts/index', false);
		$request->addParams(array('controller' => 'posts', 'action' => 'index'));
		$this->Controller = new SecurityTestController($request);
		$this->Controller->Components->init($this->Controller);
		$this->Controller->Security = $this->Controller->TestSecurity;
		$this->Controller->Security->blackHoleCallback = 'fail';
		$this->Security = $this->Controller->Security;
		$this->Security->csrfCheck = false;

		Configure::write('Security.salt', 'foo!');
	}

/**
 * Tear-down method. Resets environment state.
 *
 * @return void
 */
	public function tearDown() {
		parent::tearDown();
		$this->Controller->Session->delete('_Token');
		unset($this->Controller->Security);
		unset($this->Controller->Component);
		unset($this->Controller);
	}

/**
 * Test that requests are still blackholed when controller has incorrect
 * visibility keyword in the blackhole callback
 *
 * @expectedException BadRequestException
 */
	public function testBlackholeWithBrokenCallback() {
		$request = new CakeRequest('posts/index', false);
		$request->addParams(array(
			'controller' => 'posts', 'action' => 'index')
		);
		$this->Controller = new BrokenCallbackController($request);
		$this->Controller->Components->init($this->Controller);
		$this->Controller->Security = $this->Controller->TestSecurity;
		$this->Controller->Security->blackHoleCallback = '_fail';
		$this->Controller->Security->startup($this->Controller);
		$this->Controller->Security->blackHole($this->Controller, 'csrf');
	}

/**
 * Ensure that directly requesting the blackholeCallback as the controller
 * action results in an exception.
 *
 * @return void
 */
	public function testExceptionWhenActionIsBlackholeCallback() {
		$this->Controller->request->addParams(array(
			'controller' => 'posts',
			'action' => 'fail'
		));
		$this->assertFalse($this->Controller->failed);
		$this->Controller->Security->startup($this->Controller);
		$this->assertTrue($this->Controller->failed, 'Request was blackholed.');
	}

/**
 * test that initialize can set properties.
 *
 * @return void
 */
	public function testConstructorSettingProperties() {
		$settings = array(
			'requirePost' => array('edit', 'update'),
			'requireSecure' => array('update_account'),
			'requireGet' => array('index'),
			'validatePost' => false,
		);
		$Security = new SecurityComponent($this->Controller->Components, $settings);
		$this->Controller->Security->initialize($this->Controller, $settings);
		$this->assertEquals($Security->requirePost, $settings['requirePost']);
		$this->assertEquals($Security->requireSecure, $settings['requireSecure']);
		$this->assertEquals($Security->requireGet, $settings['requireGet']);
		$this->assertEquals($Security->validatePost, $settings['validatePost']);
	}

/**
 * testStartup method
 *
 * @return void
 */
	public function testStartup() {
		$this->Controller->Security->startup($this->Controller);
		$result = $this->Controller->params['_Token']['key'];
		$this->assertNotNull($result);
		$this->assertTrue($this->Controller->Session->check('_Token'));
	}

/**
 * testRequirePostFail method
 *
 * @return void
 */
	public function testRequirePostFail() {
		$_SERVER['REQUEST_METHOD'] = 'GET';
		$this->Controller->request['action'] = 'posted';
		$this->Controller->Security->requirePost(array('posted'));
		$this->Controller->Security->startup($this->Controller);
		$this->assertTrue($this->Controller->failed);
	}

/**
 * testRequirePostSucceed method
 *
 * @return void
 */
	public function testRequirePostSucceed() {
		$_SERVER['REQUEST_METHOD'] = 'POST';
		$this->Controller->request['action'] = 'posted';
		$this->Controller->Security->requirePost('posted');
		$this->Security->startup($this->Controller);
		$this->assertFalse($this->Controller->failed);
	}

/**
 * testRequireSecureFail method
 *
 * @return void
 */
	public function testRequireSecureFail() {
		$_SERVER['HTTPS'] = 'off';
		$_SERVER['REQUEST_METHOD'] = 'POST';
		$this->Controller->request['action'] = 'posted';
		$this->Controller->Security->requireSecure(array('posted'));
		$this->Controller->Security->startup($this->Controller);
		$this->assertTrue($this->Controller->failed);
	}

/**
 * testRequireSecureSucceed method
 *
 * @return void
 */
	public function testRequireSecureSucceed() {
		$_SERVER['REQUEST_METHOD'] = 'Secure';
		$this->Controller->request['action'] = 'posted';
		$_SERVER['HTTPS'] = 'on';
		$this->Controller->Security->requireSecure('posted');
		$this->Controller->Security->startup($this->Controller);
		$this->assertFalse($this->Controller->failed);
	}

/**
 * testRequireAuthFail method
 *
 * @return void
 */
	public function testRequireAuthFail() {
		$_SERVER['REQUEST_METHOD'] = 'AUTH';
		$this->Controller->request['action'] = 'posted';
		$this->Controller->request->data = array('username' => 'willy', 'password' => 'somePass');
		$this->Controller->Security->requireAuth(array('posted'));
		$this->Controller->Security->startup($this->Controller);
		$this->assertTrue($this->Controller->failed);

		$this->Controller->Session->write('_Token', array('allowedControllers' => array()));
		$this->Controller->request->data = array('username' => 'willy', 'password' => 'somePass');
		$this->Controller->request['action'] = 'posted';
		$this->Controller->Security->requireAuth('posted');
		$this->Controller->Security->startup($this->Controller);
		$this->assertTrue($this->Controller->failed);

		$this->Controller->Session->write('_Token', array(
			'allowedControllers' => array('SecurityTest'), 'allowedActions' => array('posted2')
		));
		$this->Controller->request->data = array('username' => 'willy', 'password' => 'somePass');
		$this->Controller->request['action'] = 'posted';
		$this->Controller->Security->requireAuth('posted');
		$this->Controller->Security->startup($this->Controller);
		$this->assertTrue($this->Controller->failed);
	}

/**
 * testRequireAuthSucceed method
 *
 * @return void
 */
	public function testRequireAuthSucceed() {
		$_SERVER['REQUEST_METHOD'] = 'AUTH';
		$this->Controller->request['action'] = 'posted';
		$this->Controller->Security->requireAuth('posted');
		$this->Controller->Security->startup($this->Controller);
		$this->assertFalse($this->Controller->failed);

		$this->Controller->Security->Session->write('_Token', array(
			'allowedControllers' => array('SecurityTest'), 'allowedActions' => array('posted')
		));
		$this->Controller->request['controller'] = 'SecurityTest';
		$this->Controller->request['action'] = 'posted';

		$this->Controller->request->data = array(
			'username' => 'willy', 'password' => 'somePass', '_Token' => ''
		);
		$this->Controller->action = 'posted';
		$this->Controller->Security->requireAuth('posted');
		$this->Controller->Security->startup($this->Controller);
		$this->assertFalse($this->Controller->failed);
	}

/**
 * testRequirePostSucceedWrongMethod method
 *
 * @return void
 */
	public function testRequirePostSucceedWrongMethod() {
		$_SERVER['REQUEST_METHOD'] = 'GET';
		$this->Controller->request['action'] = 'getted';
		$this->Controller->Security->requirePost('posted');
		$this->Controller->Security->startup($this->Controller);
		$this->assertFalse($this->Controller->failed);
	}

/**
 * testRequireGetFail method
 *
 * @return void
 */
	public function testRequireGetFail() {
		$_SERVER['REQUEST_METHOD'] = 'POST';
		$this->Controller->request['action'] = 'getted';
		$this->Controller->Security->requireGet(array('getted'));
		$this->Controller->Security->startup($this->Controller);
		$this->assertTrue($this->Controller->failed);
	}

/**
 * testRequireGetSucceed method
 *
 * @return void
 */
	public function testRequireGetSucceed() {
		$_SERVER['REQUEST_METHOD'] = 'GET';
		$this->Controller->request['action'] = 'getted';
		$this->Controller->Security->requireGet('getted');
		$this->Controller->Security->startup($this->Controller);
		$this->assertFalse($this->Controller->failed);
	}

/**
 * testRequireGetSucceedWrongMethod method
 *
 * @return void
 */
	public function testRequireGetSucceedWrongMethod() {
		$_SERVER['REQUEST_METHOD'] = 'POST';
		$this->Controller->request['action'] = 'posted';
		$this->Security->requireGet('getted');
		$this->Security->startup($this->Controller);
		$this->assertFalse($this->Controller->failed);
	}

/**
 * testRequirePutFail method
 *
 * @return void
 */
	public function testRequirePutFail() {
		$_SERVER['REQUEST_METHOD'] = 'POST';
		$this->Controller->request['action'] = 'putted';
		$this->Controller->Security->requirePut(array('putted'));
		$this->Controller->Security->startup($this->Controller);
		$this->assertTrue($this->Controller->failed);
	}

/**
 * testRequirePutSucceed method
 *
 * @return void
 */
	public function testRequirePutSucceed() {
		$_SERVER['REQUEST_METHOD'] = 'PUT';
		$this->Controller->request['action'] = 'putted';
		$this->Controller->Security->requirePut('putted');
		$this->Controller->Security->startup($this->Controller);
		$this->assertFalse($this->Controller->failed);
	}

/**
 * testRequirePutSucceedWrongMethod method
 *
 * @return void
 */
	public function testRequirePutSucceedWrongMethod() {
		$_SERVER['REQUEST_METHOD'] = 'POST';
		$this->Controller->request['action'] = 'posted';
		$this->Controller->Security->requirePut('putted');
		$this->Controller->Security->startup($this->Controller);
		$this->assertFalse($this->Controller->failed);
	}

/**
 * testRequireDeleteFail method
 *
 * @return void
 */
	public function testRequireDeleteFail() {
		$_SERVER['REQUEST_METHOD'] = 'POST';
		$this->Controller->request['action'] = 'deleted';
		$this->Controller->Security->requireDelete(array('deleted', 'other_method'));
		$this->Controller->Security->startup($this->Controller);
		$this->assertTrue($this->Controller->failed);
	}

/**
 * testRequireDeleteSucceed method
 *
 * @return void
 */
	public function testRequireDeleteSucceed() {
		$_SERVER['REQUEST_METHOD'] = 'DELETE';
		$this->Controller->request['action'] = 'deleted';
		$this->Controller->Security->requireDelete('deleted');
		$this->Controller->Security->startup($this->Controller);
		$this->assertFalse($this->Controller->failed);
	}

/**
 * testRequireDeleteSucceedWrongMethod method
 *
 * @return void
 */
	public function testRequireDeleteSucceedWrongMethod() {
		$_SERVER['REQUEST_METHOD'] = 'POST';
		$this->Controller->request['action'] = 'posted';
		$this->Controller->Security->requireDelete('deleted');
		$this->Controller->Security->startup($this->Controller);
		$this->assertFalse($this->Controller->failed);
	}

/**
 * Simple hash validation test
 *
 * @return void
 */
	public function testValidatePost() {
		$this->Controller->Security->startup($this->Controller);

		$key = $this->Controller->request->params['_Token']['key'];
		$fields = 'a5475372b40f6e3ccbf9f8af191f20e1642fd877%3AModel.valid';
		$unlocked = '';

		$this->Controller->request->data = array(
			'Model' => array('username' => 'nate', 'password' => 'foo', 'valid' => '0'),
			'_Token' => compact('key', 'fields', 'unlocked')
		);
		$this->assertTrue($this->Controller->Security->validatePost($this->Controller));
	}

/**
 * Test that validatePost fails if you are missing the session information.
 *
 * @return void
 */
	public function testValidatePostNoSession() {
		$this->Controller->Security->startup($this->Controller);
		$this->Controller->Session->delete('_Token');

		$key = $this->Controller->params['_Token']['key'];
		$fields = 'a5475372b40f6e3ccbf9f8af191f20e1642fd877%3AModel.valid';

		$this->Controller->data = array(
			'Model' => array('username' => 'nate', 'password' => 'foo', 'valid' => '0'),
			'_Token' => compact('key', 'fields')
		);
		$this->assertFalse($this->Controller->Security->validatePost($this->Controller));
	}

/**
 * test that validatePost fails if any of its required fields are missing.
 *
 * @return void
 */
	public function testValidatePostFormHacking() {
		$this->Controller->Security->startup($this->Controller);
		$key = $this->Controller->params['_Token']['key'];
		$unlocked = '';

		$this->Controller->request->data = array(
			'Model' => array('username' => 'nate', 'password' => 'foo', 'valid' => '0'),
			'_Token' => compact('key', 'unlocked')
		);
		$result = $this->Controller->Security->validatePost($this->Controller);
		$this->assertFalse($result, 'validatePost passed when fields were missing. %s');
	}

/**
 * Test that objects can't be passed into the serialized string. This was a vector for RFI and LFI
 * attacks. Thanks to Felix Wilhelm
 *
 * @return void
 */
	public function testValidatePostObjectDeserialize() {
		$this->Controller->Security->startup($this->Controller);
		$key = $this->Controller->request->params['_Token']['key'];
		$fields = 'a5475372b40f6e3ccbf9f8af191f20e1642fd877';
		$unlocked = '';

		// a corrupted serialized object, so we can see if it ever gets to deserialize
		$attack = 'O:3:"App":1:{s:5:"__map";a:1:{s:3:"foo";s:7:"Hacked!";s:1:"fail"}}';
		$fields .= urlencode(':' . str_rot13($attack));

		$this->Controller->request->data = array(
			'Model' => array('username' => 'mark', 'password' => 'foo', 'valid' => '0'),
			'_Token' => compact('key', 'fields', 'unlocked')
		);
		$result = $this->Controller->Security->validatePost($this->Controller);
		$this->assertFalse($result, 'validatePost passed when key was missing. %s');
	}

/**
 * Tests validation of checkbox arrays
 *
 * @return void
 */
	public function testValidatePostArray() {
		$this->Controller->Security->startup($this->Controller);

		$key = $this->Controller->request->params['_Token']['key'];
		$fields = 'f7d573650a295b94e0938d32b323fde775e5f32b%3A';
		$unlocked = '';

		$this->Controller->request->data = array(
			'Model' => array('multi_field' => array('1', '3'