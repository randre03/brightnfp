<?php
App::uses('DataSource', 'Model/Datasource');
App::uses('HttpSocket', 'Network/Http');

class PaypalIpnSource extends DataSource {

  /**
    * Http is the HttpSocket Object.
    * @access public
    * @var object
    */
  var $Http = null;

  /**
    * constructer.  Load the HttpSocket into the Http var.
    */
  function __construct(){
    $this->Http =& new HttpSocket();
  }

  /**
  	* Strip slashes
  	* @param string value
  	* @return string
  	*/
  static function clearSlash($value){
  	return get_magic_quotes_runtime() ? stripslashes($value) : $value;
  }

  /**
    * verifies POST data given by the paypal instant payment notification
    * @param array $data Most likely directly $_POST given by the controller.
    * @return boolean true | false depending on if data received is actually valid from paypal and not from some script monkey
    */
  function isValid($data, $test = false){
    if (env('SERVER_ADDR') === remote_ip() ||
        preg_match('/paypal\.com$/', gethostbyaddr(remote_ip()))
    ) {

      $server = $test
        ? 'https://www.sandbox.paypal.com/cgi-bin/webscr?cmd=_notify-validate'
        : 'https://www.paypal.com/cgi-bin/webscr?cmd=_notify-validate';

      $response = $this->Http->post($server, $data);

      if($response == "VERIFIED"){
        return true;
      }

      if(!$response){
        $this->log('HTTP Error in PaypalIpnSource::isValid while posting back to PayPal', 'paypal');
      }
    } else {
      $this->log('IPN Notification comes from unknown IP: '.remote_ip(), 'paypal');
    }

    return false;
  }
}