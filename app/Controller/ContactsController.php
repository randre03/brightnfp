<?php
class ContactsController extends AppController{
  var $name = 'Contacts';
  var $uses = array();  
var $components = array('Email');
   
  /**
	* @Date: Nov 21, 2011
	* @Method : index
	* @Purpose: This function is to show homepage.
	* @Param: none
	* @Return: none 
	**/  
  function index(){
  	 $this->layout = 'layout_inner';
	$email=$this->request->data['email'];
	$userName=$this->request->data['userName'];
	$message=$this->request->data['message'];
 if(!empty($email)) {
    $email=$this->request->data['email'];
    $data  = '<table border="0" width="80%"><tr><td>';
		$data .= '<b>Hello Admin,</b></td></tr><tr><td><b>Username:</b>'.$userName."</td></tr>";
		$data .= '<tr><td><b>Email:</b>'.$email."</td></tr>";
		$data .= '<tr><td><b>Message:</b>'.$message."</td></tr>";
		$data .='</table>';
		//$this->Email->to =ADMIN_EMAIL;
		$this->Email->to =$email;
					$this->Email->from = $email ;
					$this->Email->sendAs= 'html';
					$this->Email->subject = 'Contact Us';
					$this->Email->text_body = $data;
					if($this->Email->send()){
					$this->Session->setFlash('<div class="success">Your Information has been sent to '.$email.'</div>');
				}else{
						$this->Session->setFlash('<div class="fail">Error sending credentials</div>');
				}
		}
  }//ef
	
}//ec

?>