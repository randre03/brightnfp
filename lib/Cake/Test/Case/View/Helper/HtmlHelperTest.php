<?php
/**
 * HtmlHelperTest file
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
 * @package       Cake.Test.Case.View.Helper
 * @since         CakePHP(tm) v 1.2.0.4206
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('Controller', 'Controller');
App::uses('Helper', 'View');
App::uses('AppHelper', 'View/Helper');
App::uses('HtmlHelper', 'View/Helper');
App::uses('FormHelper', 'View/Helper');
App::uses('ClassRegistry', 'Utility');
App::uses('Folder', 'Utility');

if (!defined('FULL_BASE_URL')) {
	define('FULL_BASE_URL', 'http://cakephp.org');
}

/**
 * TheHtmlTestController class
 *
 * @package       Cake.Test.Case.View.Helper
 */
class TheHtmlTestController extends Controller {

/**
 * name property
 *
 * @var string
 */
	public $name = 'TheTest';

/**
 * uses property
 *
 * @var mixed null
 */
	public $uses = null;
}

class TestHtmlHelper extends HtmlHelper {

/**
 * expose a method as public
 *
 * @param string $options
 * @param string $exclude
 * @param string $insertBefore
 * @param string $insertAfter
 * @return void
 */
	public function parseAttributes($options, $exclude = null, $insertBefore = ' ', $insertAfter = null) {
		return $this->_parseAttributes($options, $exclude, $insertBefore, $insertAfter);
	}

/**
 * Get a protected attribute value
 *
 * @param string $attribute
 * @return mixed
 */
	public function getAttribute($attribute) {
		if (!isset($this->{$attribute})) {
			return null;
		}
		return $this->{$attribute};
	}

}

/**
 * Html5TestHelper class
 *
 * @package       Cake.Test.Case.View.Helper
 */
class Html5TestHelper extends TestHtmlHelper {

/**
 * Minimized
 *
 * @var array
 */
	protected $_minimizedAttributes = array('require', 'checked');

/**
 * Allow compact use in HTML
 *
 * @var string
 */
	protected $_minimizedAttributeFormat = '%s';

/**
 * Test to attribute format
 *
 * @var string
 */
	protected $_attributeFormat = 'data-%s="%s"';
}

/**
 * HtmlHelperTest class
 *
 * @package       Cake.Test.Case.View.Helper
 */
class HtmlHelperTest extends CakeTestCase {

/**
 * Regexp for CDATA start block
 *
 * @var string
 */
	public $cDataStart = 'preg:/^\/\/<!\[CDATA\[[\n\r]*/';

/**
 * Regexp for CDATA end block
 *
 * @var string
 */
	public $cDataEnd = 'preg:/[^\]]*\]\]\>[\s\r\n]*/';

/**
 * html property
 *
 * @var object
 */
	public $Html = null;

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->View = $this->getMock('View', array('append'), array(new TheHtmlTestController()));
		$this->Html = new TestHtmlHelper($this->View);
		$this->Html->request = new CakeRequest(null, false);
		$this->Html->request->webroot = '';

		App::build(array(
			'Plugin' => array(CAKE . 'Test' . DS . 'test_app' . DS . 'Plugin' . DS)
		));

		Configure::write('Asset.timestamp', false);
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		parent::tearDown();
		unset($this->Html, $this->View);
	}

/**
 * testDocType method
 *
 * @return void
 */
	public function testDocType() {
		$result = $this->Html->docType();
		$expected = '<!DOCTYPE html>';
		$this->assertEquals($expected, $result);

		$result = $this->Html->docType('html4-strict');
		$expected = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">';
		$this->assertEquals($expected, $result);

		$this->assertNull($this->Html->docType('non-existing-doctype'));
	}

/**
 * testLink method
 *
 * @return void
 */
	public function testLink() {
		Router::connect('/:controller/:action/*');

		$this->Html->request->webroot = '';

		$result = $this->Html->link('/home');
		$expected = array('a' => array('href' => '/home'), 'preg:/\/home/', '/a');
		$this->assertTags($result, $expected);

		$result = $this->Html->link(array('action' => 'login', '<[You]>'));
		$expected = array(
			'a' => array('href' => '/login/%3C%5BYou%5D%3E'),
			'preg:/\/login\/&lt;\[You\]&gt;/',
			'/a'
		);
		$this->assertTags($result, $expected);

		Router::reload();

		$result = $this->Html->link('Posts', array('controller' => 'posts', 'action' => 'index', 'full_base' => true));
		$expected = array('a' => array('href' => FULL_BASE_URL . '/posts'), 'Posts', '/a');
		$this->assertTags($result, $expected);

		$result = $this->Html->link('Home', '/home', array('confirm' => 'Are you sure you want to do this?'));
		$expected = array(
			'a' => array('href' => '/home', 'onclick' => 'return confirm(&#039;Are you sure you want to do this?&#039;);'),
			'Home',
			'/a'
		);
		$this->assertTags($result, $expected);

		$result = $this->Html->link('Home', '/home', array('default' => false));
		$expected = array(
			'a' => array('href' => '/home', 'onclick' => 'event.returnValue = false; return false;'),
			'Home',
			'/a'
		);
		$this->assertTags($result, $expected);

		$result = $this->Html->link('Home', '/home', array('default' => false, 'onclick' => 'someFunction();'));
		$expected = array(
			'a' => array('href' => '/home', 'onclick' => 'someFunction(); event.returnValue = false; return false;'),
			'Home',
			'/a'
		);
		$this->assertTags($result, $expected);

		$result = $this->Html->link('Next >', '#');
		$expected = array(
			'a' => array('href' => '#'),
			'Next &gt;',
			'/a'
		);
		$this->assertTags($result, $expected);

		$result = $this->Html->link('Next >', '#', array('escape' => true));
		$expected = array(
			'a' => array('href' => '#'),
			'Next &gt;',
			'/a'
		);
		$this->assertTags($result, $expected);

		$result = $this->Html->link('Next >', '#', array('escape' => 'utf-8'));
		$expected = array(
			'a' => array('href' => '#'),
			'Next &gt;',
			'/a'
		);
		$this->assertTags($result, $expected);

		$result = $this->Html->link('Next >', '#', array('escape' => false));
		$expected = array(
			'a' => array('href' => '#'),
			'Next >',
			'/a'
		);
		$this->assertTags($result, $expected);

		$result = $this->Html->link('Next >', '#', array(
			'title' => 'to escape &#8230; or not escape?',
			'escape' => false
		));
		$expected = array(
			'a' => array('href' => '#', 'title' => 'to escape &#8230; or not escape?'),
			'Next >',
			'/a'
		);
		$this->assertTags($result, $expected);

		$result = $this->Html->link('Next >', '#', array(
			'title' => 'to escape &#8230; or not escape?',
			'escape' => true
		));
		$expected = array(
			'a' => array('href' => '#', 'title' => 'to escape &amp;#8230; or not escape?'),
			'Next &gt;',
			'/a'
		);
		$this->assertTags($result, $expected);

		$result = $this->Html->link('Original size', array(
			'controller' => 'images', 'action' => 'view', 3, '?' => array('height' => 100, 'width' => 200)
		));
		$expected = array(
			'a' => array('href' => '/images/view/3?height=100&amp;width=200'),
			'Original size',
			'/a'
		);
		$this->assertTags($result, $expected);

		Configure::write('Asset.timestamp', false);

		$result = $this->Html->link($this->Html->image('test.gif'), '#', array('escape' => false));
		$expected = array(
			'a' => array('href' => '#'),
			'img' => array('src' => 'img/test.gif', 'alt' => ''),
			'/a'
		);
		$this->assertTags($result, $expected);

		$result = $this->Html->image('test.gif', array('url' => '#'));
		$expected = array(
			'a' => array('href' => '#'),
			'img' => array('src' => 'img/test.gif', 'alt' => ''),
			'/a'
		);
		$this->assertTags($result, $expected);

		$result = $this->Html->link($this->Html->image('../favicon.ico'), '#', array('escape' => false));
		$expected = array(
			'a' => array('href' => '#'),
			'img' => array('src' => 'img/../favicon.ico', 'alt' => ''),
			'/a'
		);
		$this->assertTags($result, $expected);

		$result = $this->Html->image('../favicon.ico', array('url' => '#'));
		$expected = array(
			'a' => array('href' => '#'),
			'img' => array('src' => 'img/../favicon.ico', 'alt' => ''),
			'/a'
		);
		$this->assertTags($result, $expected);

		$result = $this->Html->link('http://www.example.org?param1=value1&param2=value2');
		$expected = array('a' => array('href' => 'http://www.example.org?param1=value1&amp;param2=value2'), 'http://www.example.org?param1=value1&amp;param2=value2', '/a');
		$this->assertTags($result, $expected);

		$result = $this->Html->link('alert', 'javascript:alert(\'cakephp\');');
		$expected = array('a' => array('href' => 'javascript:alert(&#039;cakephp&#039;);'), 'alert', '/a');
		$this->assertTags($result, $expected);

		$result = $this->Html->link('write me', 'mailto:example@cakephp.org');
		$expected = array('a' => array('href' => 'mailto:example@cakephp.org'), 'write me', '/a');
		$this->assertTags($result, $expected);

		$result = $this->Html->link('call me on 0123465-798', 'tel:0123465-798');
		$expected = array('a' => array('href' => 'tel:0123465-798'), 'call me on 0123465-798', '/a');
		$this->assertTags($result, $expected);

		$result = $this->Html->link('text me on 0123465-798', 'sms:0123465-798');
		$expected = array('a' => array('href' => 'sms:0123465-798'), 'text me on 0123465-798', '/a');
		$this->assertTags($result, $expected);

		$result = $this->Html->link('say hello to 0123465-798', 'sms:0123465-798?body=hello there');
		$expected = array('a' => array('href' => 'sms:0123465-798?body=hello there'), 'say hello to 0123465-798', '/a');
		$this->assertTags($result, $expected);

		$result = $this->Html->link('say hello to 0123465-798', 'sms:0123465-798?body=hello "cakephp"');
		$expected = array('a' => array('href' => 'sms:0123465-798?body=hello &quot;cakephp&quot;'), 'say hello to 0123465-798', '/a');
		$this->assertTags($result, $expected);
	}

/**
 * testImageTag method
 *
 * @return void
 */
	public function testImageTag() {
		$this->Html->request->webroot = '';

		$result = $this->Html->image('test.gif');
		$this->assertTags($result, array('img' => array('src' => 'img/test.gif', 'alt' => '')));

		$result = $this->Html->image('http://google.com/logo.gif');
		$this->assertTags($result, array('img' => array('src' => 'http://google.com/logo.gif', 'alt' => '')));

		$result = $this->Html->image(array('controller' => 'test', 'action' => 'view', 1, 'ext' => 'gif'));
		$this->assertTags($result, array('img' => array('src' => '/test/view/1.gif', 'alt' => '')));

		$result = $this->Html->image('/test/view/1.gif');
		$this->assertTags($result, array('img' => array('src' => '/test/view/1.gif', 'alt' => '')));

		$result = $this->Html->image('test.gif?one=two&three=four');
		$this->assertTags($result, array('img' => array('src' => 'img/test.gif?one=two&amp;three=four', 'alt' => '')));
	}

/**
 * Test that image() works with fullBase and a webroot not equal to /
 *
 * @return void
 */
	public function testImageWithFullBase() {
		$result = $this->Html->image('test.gif', array('fullBase' => true));
		$here = $this->Html->url('/', true);
		$this->assertTags($result, array('img' => array('src' => $here . 'img/test.gif', 'alt' => '')));

		$result = $this->Html->image('sub/test.gif', array('fullBase' => true));
		$here = $this->Html->url('/', true);
		$this->assertTags($result, array('img' => array('src' => $here . 'img/sub/test.gif', 'alt' => '')));

		$request = $this->Html->request;
		$request->webroot = '/myproject/';
		$request->base = '/myproject';
		Router::setRequestInfo($request);

		$result = $this->Html->image('sub/test.gif', array('fullBase' => true));
		$here = $this->Html->url('/', true);
		$this->assertTags($result, array('img' => array('src' => $here . 'img/sub/test.gif', 'alt' => '')));
	}

/**
 * test image() with Asset.timestamp
 *
 * @return void
 */
	public function testImageWithTimestampping() {
		Configure::write('Asset.timestamp', 'force');

		$this->Html->request->webroot = '/';
		$result = $this->Html->image('cake.icon.png');
		$this->assertTags($result, array('img' => array('src' => 'preg:/\/img\/cake\.icon\.png\?\d+/', 'alt' => '')));

		Configure::write('debug', 0);
		Configure::write('Asset.timestamp', 'force');

		$result = $this->Html->image('cake.icon.png');
		$this->assertTags($result, array('img' => array('src' => 'preg:/\/img\/cake\.icon\.png\?\d+/', 'alt' => '')));

		$this->Html->request->webroot = '/testing/longer/';
		$result = $this->Html->image('cake.icon.png');
		$expected = array(
			'img' => array('src' => 'preg:/\/testing\/longer\/img\/cake\.icon\.png\?[0-9]+/', 'alt' => '')
		);
		$this->assertTags($result, $expected);
	}

/**
 * Tests creation of an image tag using a theme and asset timestamping
 *
 * @return void
 */
	public function testImageTagWithTheme() {
		$this->skipIf(!is_writable(WWW_ROOT), 'Cannot write to webroot.');
		$themeExists = is_dir(WWW_ROOT . 'theme');

		App::uses('File', 'Utility');

		$testfile = WWW_ROOT . 'theme' . DS . 'test_theme' . DS . 'img' . DS . '__cake_test_image.gif';
		new File($testfile, true);

		App::build(array(
			'View' => array(CAKE . 'Test' . DS . 'test_app' . DS . 'View' . DS)
		));
		Configure::write('Asset.timestamp', true);
		Configure::write('debug', 1);

		$this->Html->request->webroot = '/';
		$this->Html->theme = 'test_theme';
		$result = $this->Html->image('__cake_test_image.gif');
		$this->assertTags($result, array(
			'img' => array(
				'src' => 'preg:/\/theme\/test_theme\/img\/__cake_test_image\.gif\?\d+/',
				'alt' => ''
		)));

		$this->Html->request->webroot = '/testing/';
		$result = $this->Html->image('__cake_test_image.gif');

		$this->assertTags($result, array(
			'img' => array(
				'src' => 'preg:/\/testing\/theme\/test_theme\/img\/__cake_test_image\.gif\?\d+/',
				'alt' => ''
		)));

		$dir = new Folder(WWW_ROOT . 'theme' . DS . 'test_theme');
		$dir->delete();
		if (!$themeExists) {
			$dir = new Folder(WWW_ROOT . 'theme');
			$dir->delete();
		}
	}

/**
 * test theme assets in main webroot path
 *
 * @return void
 */
	public function testThemeAssetsInMainWebrootPath() {
		App::build(array(
			'View' => array(CAKE . 'Test' . DS . 'test_app' . DS . 'View' . DS)
		));
		$webRoot = Configure::read('App.www_root');
		Configure::write('App.www_root', CAKE . 'Test' . DS . 'test_app' . DS . 'webroot' . DS);

		$this->Html->theme = 'test_theme';
		$result = $this->Html->css('webroot_test');
		$expected = array(
			'link' => array('rel' => 'stylesheet', 'type' => 'text/css', 'href' => 'preg:/.*theme\/test_theme\/css\/webroot_test\.css/')
		);
		$this->assertTags($result, $expected);

		$this->Html->theme = 'test_theme';
		$result = $this->Html->css('theme_webroot');
		$expected = array(
			'link' => array('rel' => 'stylesheet', 'type' => 'text/css', 'href' => 'preg:/.*theme\/test_theme\/css\/theme_webroot\.css/')
		);
		$this->assertTags($result, $expected);

		Configure::write('App.www_root', $webRoot);
	}

/**
 * testStyle method
 *
 * @return void
 */
	public function testStyle() {
		$result = $this->Html->style('display: none;');
		$this->assertEquals('display: none;', $result);

		$result = $this->Html->style(array('display' => 'none', 'margin' => '10px'));
		$expected = 'display:none; margin:10px;';
		$this->assertRegExp('/^display\s*:\s*none\s*;\s*margin\s*:\s*10px\s*;?$/', $expected);

		$result = $this->Html->style(array('display' => 'none', 'margin' => '10px'), false);
		$lines = explode("\n", $result);
		$this->assertRegExp('/^\s*display\s*:\s*none\s*;\s*$/', $lines[0]);
		$this->assertRegExp('/^\s*margin\s*:\s*10px\s*;?$/', $lines[1]);
	}

/**
 * testCssLink method
 *
 * @return void
 */
	public function testCssLink() {
		Configure::write('Asset.filter.css', false);

		$result = $this->Html->css('screen');
		$expected = array(
			'link' => array('rel' => 'stylesheet', 'type' => 'text/css', 'href' => 'preg:/.*css\/screen\.css/')
		);
		$this->assertTags($result, $expected);

		$result = $this->Html->css('screen.css');
		$this->assertTags($result, $expected);

		CakePlugin::load('TestPlugin');
		$result = $this->Html->css('TestPlugin.style', null, array('plugin' => false));
		$expected['link']['href'] = 'preg:/.*css\/TestPlugin\.style\.css/';
		$this->assertTags($result, $expected);
		CakePlugin::unload('TestPlugin');

		$result = $this->Html->css('my.css.library');
		$expected['link']['href'] = 'preg:/.*css\/my\.css\.library\.css/';
		$this->assertTags($result, $expected);

		$result = $this->Html->css('screen.css?1234');
		$expected['link']['href'] = 'preg:/.*css\/screen\.css\?1234/';
		$this->assertTags($result, $expected);

		$result = $this->Html->css('screen.css?with=param&other=param');
		$expected['link']['href'] = 'css/screen.css?with=param&amp;other=param';
		$this->assertTags($result, $expected);

		$result = $this->Html->css('http://whatever.com/screen.css?1234');
		$expected['link']['href'] = 'preg:/http:\/\/.*\/screen\.css\?1234/';
		$this->assertTags($result, $expected);

		Configure::write('Asset.filter.css', 'css.php');
		$result = $this->Html->css('cake.generic');
		$expected['link']['href'] = 'preg:/.*ccss\/cake\.generic\.css/';
		$this->assertTags($result, $expected);

		$result = $this->Html->css('//example.com/css/cake.generic.css');
		$expected['link']['href'] = 'preg:/.*example\.com\/css\/cake\.generic\.css/';
		$this->assertTags($result, $expected);

		Configure::write('Asset.filter.css', false);

		$result = explode("\n", trim($this->Html->css(array('cake.generic', 'vendor.generic'))));
		$expected['link']['href'] = 'preg:/.*css\/cake\.generic\.css/';
		$this->assertTags($result[0], $expected);
		$expected['link']['href'] = 'preg:/.*css\/vendor\.generic\.css/';
		$this->assertTags($result[1], $expected);
		$this->assertEquals(2, count($result));

		$this->View->expects($this->at(0))
			->method('append')
			->with('css', $this->matchesRegularExpression('/css_in_head.css/'));

		$this->View->expects($this->at(1))
			->method('append')
			->with('css', $this->matchesRegularExpression('/more_css_in_head.css/'));

		$result = $this->Html->css('css_in_head', null, array('inline' => false));
		$this->assertNull($result);

		$result = $this->Html->css('more_css_in_head', null, array('inline' => false));
		$this->assertNull($result);
	}

/**
 * testCssWithFullBase method
 *
 * @return void
 */
	public function testCssWithFullBase() {
		Configure::write('Asset.filter.css', false);
		$here = $this->Html->url('/', true);

		$result = $this->Html->css('screen', null, array('fullBase' => true));
		$expected = array(
			'link' => array('rel' => 'stylesheet', 'type' => 'text/css', 'href' => $here . 'css/screen.css')
		);
		$this->assertTags($result, $expected);
	}

/**
 * testPluginCssLink method
 *
 * @return void
 */
	public function testPluginCssLink() {
		Configure::write('Asset.filter.css', false);
		CakePlugin::load('TestPlugin');

		$result = $this->Html->css('TestPlugin.test_plugin_asset');
		$expected = array(
			'link' => array('rel' => 'stylesheet', 'type' => 'text/css', 'href' => 'preg:/.*test_plugin\/css\/test_plugin_asset\.css/')
		);
		$this->assertTags($result, $expected);

		$result = $this->Html->css('TestPlugin.test_plugin_asset.css');
		$this->assertTags($result, $expected);

		$result = $this->Html->css('TestPlugin.my.css.library');
		$expected['link']['href'] = 'preg:/.*test_plugin\/css\/my\.css\.library\.css/';
		$this->assertTags($result, $expected);

		$result = $this->Html->css('TestPlugin.test_plugin_asset.css?1234');
		$expected['link']['href'] = 'preg:/.*test_plugin\/css\/test_plugin_asset\.css\?1234/';
		$this->assertTags($result, $expected);

		Configure::write('Asset.filter.css', 'css.php');
		$result = $this->Html->css('TestPlugin.test_plugin_asset');
		$expected['link']['href'] = 'preg:/.*test_plugin\/ccss\/test_plugin_asset\.css/';
		$this->assertTags($result, $expected);

		Configure::write('Asset.filter.css', false);

		$result = explode("\n", trim($this->Html->css(array('TestPlugin.test_plugin_asset', 'TestPlugin.vendor.generic'))));
		$expected['link']['href'] = 'preg:/.*test_plugin\/css\/test_plugin_asset\.css/';
		$this->assertTags($result[0], $expected);
		$expected['link']['href'] = 'preg:/.*test_plugin\/css\/vendor\.generic\.css/';
		$this->assertTags($result[1], $expected);
		$this->assertEquals(2, count($result));

		CakePlugin::unload('TestPlugin');
	}

/**
 * test use of css() and timestamping
 *
 * @return void
 */
	public function testCssTimestamping() {
		Configure::write('debug', 2);
		Configure::write('Asset.timestamp', true);

		$expected = array(
			'link' => array('rel' => 'stylesheet', 'type' => 'text/css', 'href' => '')
		);

		$result = $this->Html->css('cake.generic');
		$expected['link']['href'] = 'preg:/.*css\/cake\.generic\.css\?[0-9]+/';
		$this->assertTags($result, $expected);

		Configure::write('debug', 0);

		$result = $this->Html->css('cake.generic');
		$expected['link']['href'] = 'preg:/.*css\/cake\.generic\.css/';
		$this->assertTags($result, $expected);

		Configure::write('Asset.timestamp', 'force');

		$result = $this->Html->css('cake.generic');
		$expected['link']['href'] = 'preg:/.*css\/cake\.generic\.css\?[0-9]+/';
		$this->assertTags($result, $expected);

		$this->Html->request->webroot = '/testing/';
		$result = $this->Html->css('cake.generic');
		$expected['link']['href'] = 'preg:/\/testing\/css\/cake\.generic\.css\?[0-9]+/';
		$this->assertTags($result, $expected);

		$this->Html->request->webroot = '/testing/longer/';
		$result = $this->Html->css('cake.generic');
		$expected['link']['href'] = 'preg:/\/testing\/longer\/css\/cake\.generic\.css\?[0-9]+/';
		$this->assertTags($result, $expected);
	}

/**
 * test use of css() and timestamping with plugin syntax
 *
 * @return void
 */
	public function testPluginCssTimestamping() {
		CakePlugin::load('TestPlugin');

		Configure::write('debug', 2);
		Configure::write('Asset.timestamp', true);

		$expected = array(
			'link' => array('rel' => 'stylesheet', 'type' => 'text/css', 'href' => '')
		);

		$result = $this->Html->css('TestPlugin.test_plugin_asset');
		$expected['link']['href'] = 'preg:/.*test_plugin\/css\/test_plugin_asset\.css\?[0-9]+/';
		$this->assertTags($result, $expected);

		Configure::write('debug', 0);

		$result = $this->Html->css('TestPlugin.test_plugin_asset');
		$expected['link']['href'] = 'preg:/.*test_plugin\/css\/test_plugin_asset\.css/';
		$this->assertTags($result, $expected);

		Configure::write('Asset.timestamp', 'force');

		$result = $this->Html->css('TestPlugin.test_plugin_asset');
		$expected['link']['href'] = 'preg:/.*test_plugin\/css\/test_plugin_asset\.css\?[0-9]+/';
		$this->assertTags($result, $expected);

		$this->Html->request->webroot = '/testing/';
		$result = $this->Html->css('TestPlugin.test_plugin_asset');
		$expected['link']['href'] = 'preg:/\/testing\/test_plugin\/css\/test_plugin_asset\.css\?[0-9]+/';
		$this->assertTags($result, $expected);

		$this->Html->request->webroot = '/testing/longer/';
		$result = $this->Html->css('TestPlugin.test_plugin_asset');
		$expected['link']['href'] = 'preg:/\/testing\/longer\/test_plugin\/css\/test_plugin_asset\.css\?[0-9]+/';
		$this->assertTags($result, $expected);

		CakePlugin::unload('TestPlugin');
	}

/**
 * test timestamp enforcement for script tags.
 *
 * @return void
 */
	public function testScriptTimestamping() {
		$this->skipIf(!is_writable(JS), 'webroot/js is not Writable, timestamp testing has been skipped.');

		Configure::write('debug', 2);
		Configure::write('Asset.timestamp', true);

		touch(WWW_ROOT . 'js' . DS . '__cake_js_test.js');
		$timestamp = substr(strtotime('now'), 0, 8);

		$result = $this->Html->script('__cake_js_test', array('inline' => true, 'once' => false));
		$this->assertRegExp('/__cake_js_test.js\?' . $timestamp . '[0-9]{2}"/', $result, 'Timestamp value not found %s');

		Configure::write('debug', 0);
		Configure::write('Asset.timestamp', 'force');
		$result = $this->Html->script('__cake_js_test', array('inline' => true, 'once' => false));
		$this->assertRegExp('/__cake_js_test.js\?' . $timestamp . '[0-9]{2}"/', $result, 'Timestamp value not found %s');
		unlink(WWW_ROOT . 'js' . DS . '__cake_js_test.js');
		Configure::write('Asset.timestamp', false);
	}

/**
 * test timestamp enforcement for script tags with plugin syntax.
 *
 * @return void
 */
	public function testPluginScriptTimestamping() {
		CakePlugin::load('TestPlugin');

		$pluginPath = App::pluginPath('TestPlugin');
		$pluginJsPath = $pluginPath . 'webroot/js';
		$this->skipIf(!is_writable($pluginJsPath), $pluginJsPath . ' is not Writable, timestamp testing has been skipped.');

		Configure::write('debug', 2);
		Configure::write('Asset.timestamp', true);

		touch($pluginJsPath . DS . '__cake_js_test.js');
		$timestamp = substr(strtotime('now'), 0, 8);

		$result = $this->Html->script('TestPlugin.__cake_js_test', array('inline' => true, 'once' => false));
		$this->assertRegExp('/test_plugin\/js\/__cake_js_test.js\?' . $timestamp . '[0-9]{2}"/', $result, 'Timestamp value not found %s');

		Configure::write('debug', 0);
		Configure::write('Asset.timestamp', 'force');
		$result = $this->Html->script('TestPlugin.__cake_js_test', array('inline' => true, 'once' => false));
		$this->assertRegExp('/test_plugin\/js\/__cake_js_test.js\?' . $timestamp . '[0-9]{2}"/', $result, 'Timestamp value not found %s');
		unlink($pluginJsPath . DS . '__cake_js_test.js');
		Configure::write('Asset.timestamp', false);

		CakePlugin::unload('TestPlugin');
	}

/**
 * test that scripts added with uses() are only ever included once.
 * test script tag generation
 *
 * @return void
 */
	public function testScript() {
		$result = $this->Html->script('foo');
		$expected = array(
			'script' => array('type' => 'text/javascript', 'src' => 'js/foo.js')
		);
		$this->assertTags($result, $expected);

		$result = $this->Html->script(array('foobar', 'bar'));
		$expected = array(
			array('script' => array('type' => 'text/javascript', 'src' => 'js/foobar.js')),
			'/script',
			array('script' => array('type' => 'text/javascript', 'src' => 'js/bar.js')),
			'/script',
		);
		$this->assertTags($result, $expected);

		$result = $this->Html->script('jquery-1.3');
		$expected = array(
			'script' => array('type' => 'text/javascript', 'src' => 'js/jquery-1.3.js')
		);
		$this->assertTags($result, $expected);

		$result = $this->Html->script('test.json');
		$expected = array(
			'script' => array('type' => 'text/javascript', 'src' => 'js/test.json.js')
		);
		$this->assertTags($result, $expected);

		$result = $this->Html->script('http://example.com/test.json');
		$expected = array(
			'script' => array('type' => 'text/javascript', 'src' => 'http://example.com/test.json')
		);
		$this->assertTags($result, $expected);

		$result = $this->Html->script('/plugin/js/jquery-1.3.2.js?someparam=foo');
		$expected = array(
			'script' => array('type' => 'text/javascript', 'src' => '/plugin/js/jquery-1.3.2.js?someparam=foo')
		);
		$this->assertTags($result, $expected);

		$result = $this->Html->script('test.json.js?foo=bar');
		$expected = array(
			'script' => array('type' => 'text/javascript', 'src' => 'js/test.json.js?foo=bar')
		);
		$this->assertTags($result, $expected);

		$result = $this->Html->script('test.json.js?foo=bar&other=test');
		$expected = array(
			'script' => array('type' => 'text/javascript', 'src' => 'js/test.json.js?foo=bar&amp;other=test')
		);
		$this->assertTags($result, $expected);

		$result = $this->Html->script('foo');
		$this->assertNull($result, 'Script returned upon duplicate inclusion %s');

		$result = $this->Html->script(array('foo', 'bar', 'baz'));
		$this->assertNotRegExp('/foo.js/', $result);

		$result = $this->Html->script('foo', array('inline' => true, 'once' => false));
		$this->assertNotNull($result);

		$result = $this->Html->script('jquery-1.3.2', array('defer' => true, 'encoding' => 'utf-8'));
		$expected = array(
			'script' => array('type' => 'text/javascript', 'src' => 'js/jquery-1.3.2.js', 'defer' => 'defer', 'encoding' => 'utf-8')
		);
		$this->assertTags($result, $expected);
	}

/**
 * test that plugin scripts added with uses() are only ever included once.
 * test script tag generation with plugin syntax
 *
 * @return void
 */
	public function testPluginScript() {
		CakePlugin::load('TestPlugin');

		$result = $this->Html->script('TestPlugin.foo');
		$expected = array(
			'script' => array('type' => 'text/javascript', 'src' => 'test_plugin/js/foo.js')
		);
		$this->assertTags($result, $expected);

		$result = $this->Html->script(array('TestPlugin.foobar', 'TestPlugin.bar'));
		$expected = array(
			array('script' => array('type' => 'text/javascript', 'src' => 'test_plugin/js/foobar.js')),
			'/script',
			array('script' => array('type' => 'text/javascript', 'src' => 'test_plugin/js/bar.js')),
			'/script',
		);
		$this->assertTags($result, $expected);

		$result = $this->Html->script('TestPlugin.jquery-1.3');
		$expected = array(
			'script' => array('type' => 'text/javascript', 'src' => 'test_plugin/js/jquery-1.3.js')
		);
		$this->assertTags($result, $expected);

		$result = $this->Html->script('TestPlugin.test.json');
		$expected = array(
			'script' => array('type' => 'text/javascript', 'src' => 'test_plugin/js/test.json.js')
		);
		$this->assertTags($result, $expected);

		$result = $this->Html->script('TestPlugin./jquery-1.3.2.js?someparam=foo');
		$expected = array(
			'script' => array('type' => 'text/javascript', 'src' => 'test_plugin/jquery-1.3.2.js?someparam=foo')
		);
		$this->assertTags($result, $expected);

		$result = $this->Html->script('TestPlugin.test.json.js?foo=bar');
		$expected = array(
			'script' => array('type' => 'text/javascript', 'src' => 'test_plugin/js/test.json.js?foo=bar')
		);
		$this->assertTags($result, $expected);

		$result = $this->Html->script('TestPlugin.foo');
		$this->assertNull($result, 'Script returned upon duplicate inclusion %s');

		$result = $this->Html->script(array('TestPlugin.foo', 'TestPlugin.bar', 'TestPlugin.baz'));
		$this->assertNotRegExp('/test_plugin\/js\/foo.js/', $result);

		$result = $this->Html->script('TestPlugin.foo', array('inline' => true, 'once' => false));
		$this->assertNotNull($result);

		$result = $this->Html->script('TestPlugin.jquery-1.3.2', array('defer' => true, 'encoding' => 'utf-8'));
		$expected = array(
			'script' => array('type' => 'text/javascript', 'src' => 'test_plugin/js/jquery-1.3.2.js', 'defer' => 'defer', 'encoding' => 'utf-8')
		);
		$this->assertTags($result, $expected);

		CakePlugin::unload('TestPlugin');
	}

/**
 * test that script() works with blocks.
 *
 * @return void
 */
	public function testScriptWithBlocks() {
		$this->View->expects($this->at(0))
			->method('append')
			->with('script', $this->matchesRegularExpression('/script_in_head.js/'));

		$this->View->expects($this->at(1))
			->method('append')
			->with('script', $this->matchesRegularExpression('/bool_false.js/'));

		$this->View->expects($this->at(2))
			->method('append')
			->with('headScripts', $this->matchesRegularExpression('/second_script.js/'));

		$result = $this->Html->script('script_in_head', array('inline' => false));
		$this->assertNull($result);

		$result = $this->Html->script('bool_false', false);
		$this->assertNull($result);

		$result = $this->Html->script('second_script', array('block' => 'headScripts'));
		$this->assertNull($result);
	}

/**
 * Test that Asset.filter.js works.
 *
 * @return void
 */
	public function testScriptAssetFilter() {
		Configure::write('Asset.filter.js', 'js.php');

		$result = $this->Html->script('jquery-1.3');
		$expected = array(
			'script' => array('type' => 'text/javascript', 'src' => 'cjs/jquery-1.3.js')
		);
		$this->assertTags($result, $expected);

		$result = $this->Html->script('//example.com/js/jquery-1.3.js');
		$expected = array(
			'script' => array('type' => 'text/javascript', 'src' => '//example.com/js/jquery-1.3.js')
		);
		$this->assertTags($result, $expected);
	}

/**
 * testScriptWithFullBase method
 *
 * @return void
 */
	public function testScriptWithFullBase() {
		$here = $this->Html->url('/', true);

		$result = $this->Html->script('foo', array('fullBase' => true));
		$expected = array(
			'script' => array('type' => 'text/javascript', 'src' => $here . 'js/foo.js')
		);
		$this->assertTags($result, $expected);

		$result = $this->Html->script(array('foobar', 'bar'), array('fullBase' => true));
		$expected = array(
			array('script' => array('type' => 'text/javascript', 'src' => $here . 'js/foobar.js')),
			'/script',
			array('script' => array('type' => 'text/javascript', 'src' => $here . 'js/bar.js')),
			'/script