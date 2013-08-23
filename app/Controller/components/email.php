<?php 
/**
 * This is a component to send email from CakePHP using PHPMailer
 * @link http://bakery.cakephp.org/articles/view/94
 * @see http://bakery.cakephp.org/articles/view/94
 */
 
class EmailComponent
{
  /**
   * Send email using SMTP Auth by default.
   */
    var $from         = ADMIN_EMAIL;
    var $fromName     = ADMIN_FROM_NAME;
    
	//For smartData server
    var $smtpUserName = 'testid@smartdatainc.net';  // SMTP username//testsdei
    var $smtpPassword = 'testid'; // SMTP password//sdeichd
    var $smtpHostNames= "mail.smartdatainc.net";  //mail.smartdatainc.net specify main and backup server -   67.228.225.209
    
    //For THB Live server
    //var $smtpUserName = 'admin+techhotbed.com';  // SMTP username//testsdei
    //var $smtpPassword = 're$#9&v2010'; // SMTP password//sdeichd
    //var $smtpHostNames= "mail.techhotbed.com";  //mail.smartdatainc.net specify main and backup server -   67.228.225.209
    
    var $text_body = null;
    var $html_body = null;
    var $to = null;
    var $toName = null;
    var $subject = null;
    var $message = null;
    var $cc = null;
    var $ccName = null;
    var $bcc = null;
    var $template = null;
    var $attachments = null;
 
    var $controller;
 
    function startup( &$controller ) {
      $this->controller = &$controller;
    }
 
    function bodyText() {
    /** This is the body in plain text for non-HTML mail clients
     */
      ob_start();
      $temp_layout = $this->controller->layout;
      $this->controller->layout = '';  // Turn off the layout wrapping
      $this->controller->render($this->template . '_text'); 
      $mail = ob_get_clean();
      $this->controller->layout = $temp_layout; // Turn on layout wrapping again
      return $mail;
    }
 
    function bodyHTML() {
    /** This is HTML body text for HTML-enabled mail clients
     */
 //echo __FILE__.'<br>';
     // echo $this->template . '_html';die;
   ob_start();
      $temp_layout = $this->controller->layout;
      $this->controller->layout = 'email';  //  HTML wrapper for my html email in /app/views/layouts
      $this->controller->render($this->template . '_html'); 
      $mail = ob_get_clean();
      $this->controller->layout = $temp_layout; // Turn on layout wrapping again
      return $mail;
    }
 
    function attach($filename, $asfile = '') {
      if (empty($this->attachments)) {
        $this->attachments = array();
        $this->attachments[0]['filename'] = $filename;
        $this->attachments[0]['asfile'] = $asfile;
      } else {
        $count = count($this->attachments);
        $this->attachments[$count+1]['filename'] = $filename;
        $this->attachments[$count+1]['asfile'] = $asfile;
      }
    }
 

    function send()
    {
 //App::import('Vendor','phpmailer'.DS.'class.phpmailer');
 //vendor('phpmailer'.DS.'class.phpmailer'); 
 
    App::import('Vendor', 'phpmailer/phpmailer');
 $mail =& new PHPMailer();
 ob_start();
    $mail->IsSMTP();            // set mailer to use SMTP
    $mail->SMTPAuth = true;     // turn on SMTP authentication
    $mail->Host   = $this->smtpHostNames;
    $mail->Username = $this->smtpUserName;
    $mail->Password = $this->smtpPassword;
 
	$mail->From     = $this->from;
	$mail->FromName = $this->fromName;
	//$mail->AddAddress($this->to, $this->toName);
    //$mail->AddReplyTo($this->from, $this->fromName );
 
	if(is_array($this->to)){
			for($i=0;$i<count($this->to);$i++){
		      		$mail->AddAddress($this->to[$i], $this->toName[$i] );
				$mail->AddReplyTo($this->from[$i], $this->fromName[$i] );	
			}
	}else{
		$mail->AddAddress($this->to, $this->toName );
		$mail->AddReplyTo($this->from, $this->fromName );
	}
   	if (!empty($this->cc)) {
		if(is_array($this->cc)){
				for($i=0;$i<count($this->cc);$i++){
					$mail->AddCC($this->cc[$i],$this->toName[$i]);
					$mail->AddReplyTo($this->from[$i], $this->fromName[$i] );
				}
		}else{
			$mail->AddCC($this->cc);
			$mail->AddReplyTo($this->from, $this->fromName );
		}
 	}
   	 $mail->CharSet  = 'UTF-8';
   	 $mail->WordWrap = 50;  // set word wrap to 50 characters
 
    if (!empty($this->attachments)) { 
      foreach ($this->attachments as $attachment) { pr($attachment);
        if (empty($attachment['asfile'])) {
          $mail->AddAttachment($attachment['filename']);
        } else {
          $mail->AddAttachment($attachment['filename'], $attachment['asfile']);
        }
      }
    }
 
    $mail->IsHTML(true);  // set email format to HTML
    $mail->Subject = $this->subject;
	$mail->Body    = $this->text_body;//$this->message;
	
//    $mail->Body    = $this->bodyHTML();
 //$mail->AltBody = $this->bodyText();
	$result = $mail->Send();
	if($result == false ) $result = $mail->ErrorInfo;
 //echo $result;
 //exit; 
    return $result;
    } 
}
?>