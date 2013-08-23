<?php
class UsersController extends AppController{
  var $name = 'Users';
  var $uses = array();  
	var $components = array('Email');
  var $helpers = array('PaypalIpn.Paypal');
   
   
  /**
	* @Date: Nov 21, 2011
	* @Method : index
	* @Purpose: This function is to show homepage.
	* @Param: none
	* @Return: none 
	**/  
  function index(){
  }//ef
     
  /**
	* @Date: Nov 21, 2011
	* @Method : login
	* @Purpose: This function is to login the user/NPO.
	* @Param: none
	* @Return: none 
	**/  
  
  function login(){
    $this->autoRender = false;  
    if(!empty($this->request->data)){
      App::import('Model','Npo');
      $this->Npo = new Npo();
      $username = mysql_real_escape_string($this->request->data['User']['username']); 
      $password = mysql_real_escape_string($this->request->data['User']['password']); 
      $npoDetail = $this->Npo->find('all',array('fields'=>array('Npo.email','Npo.title','Npo.id','Npo.status','Npo.address'),'conditions'=>array('Npo.email' => $username,'Npo.password' => $password)));
          
      if(count($npoDetail) === 1){
          if($npoDetail[0]['Npo']['status'] == 'Active'){
            $this->Session->write('SESSION_USER',$npoDetail[0]);
            $this->redirect(array('controller'=>'npo','action'=>'npodashboard'));
          }else{
            $this->Session->setFlash('<div class="fail">Your account is not active.</div>');
            $this->redirect('/');
          }
      }else{
        $this->Session->setFlash('<div class="fail">Incorrect Username/Password</div>');
        $this->redirect('/');
      }
    } 
    
  }//ef
  
  
  
  /**
	* @Date: Nov 21, 2011
	* @Method : forgotpassword
	* @Purpose: This function is to reterive forgotten passwords.
	* @Param: none
	* @Return: none 
	**/  
  function forgotpassword(){ 
    if(!empty($this->request->data)){
      App::import('Model','Npo');
      $this->Npo = new Npo();
      $username = $this->request->data['username'];
      $npoData = $this->Npo->find('first',array('fields'=>array('Npo.password','Npo.email'),'conditions'=>array('Npo.username' =>$username)));
     // pr($npoData);die();
      if(isset($npoData) && is_array($npoData) && !empty($npoData)){
        $email           = $npoData['Npo']['email'];
        $data            = 'Hello<br />Your username password are as follows:<br />Username:'.$username.'<br />Password:'.$npoData['Npo']['password'];
        $this->Email->to = $email;
				$this->Email->from = ADMIN_EMAIL;
				$this->Email->sendAs= 'html';
				$this->Email->subject = 'Forgot Password';
				$this->Email->text_body = $data;
          if($this->Email->send()){            
              $this->Session->setFlash('<div class="success">Your Credentials have been sent to '.$email.'</div>');
          }else{
              $this->Session->setFlash('<div class="fail">Error sending credentials</div>');
          }
      }else{
        $this->Session->setFlash('<div class="fail">Username '.$username.' does not exists.</div>');
      }
    } 
    
  }//ef
  
  /**
	* @Date: Nov 21, 2011
	* @Method : member_login
	* @Purpose: This function is for member login.
	* @Param: none
	* @Return: none 
	**/ 
  function member_login(){
  
    $this->autoRender = false;  
    if(!empty($this->request->data)){
      App::import('Model','Member');
      $this->Member = new Member();
      $username = mysql_real_escape_string($this->request->data['User']['username']); 
      $password = mysql_real_escape_string($this->request->data['User']['password']); 
      $npoDetail = $this->Member->find('all',array('fields'=>array('Member.email','Member.name','Member.id','Member.status'),'conditions'=>array('Member.email' => $username,'Member.password' => $password)));
      
      if(count($npoDetail) === 1){
          if($npoDetail[0]['Member']['status'] == 'Active'){
            $this->Session->write('SESSION_USER',$npoDetail[0]);
            $this->redirect(array('controller'=>'members','action'=>'memberdashboard'));
          }else{
            $this->Session->setFlash('<div class="fail">Your account is not active.</div>');
            $this->redirect('/');
          }
      }else{
        $this->Session->setFlash('<div class="fail">Incorrect Username/Password</div>');
        $this->redirect('/');
      }
    } 
  }//ef
  
  /**
	* @Date: Nov 21, 2011
	* @Method : logout
	* @Purpose: This function is to logout.
	* @Param: none
	* @Return: none 
	**/ 
	function logout(){
    $this->Session->delete('SESSION_USER');
    $this->Session->destroy();
    $this->Session->setFlash('<div class="success">Logout Successful</div>');
    $this->redirect('/');
    
  }   
  function subscribe(){
    App::import('Model','Subscriber');
    $this->Subscriber = new Subscriber();
    $data             = array();
    $data['email_id'] = $_REQUEST['payer_email'];
    $this->Subscriber->save($data);
    $this->Session->setFlash('<div class="success">Thank you,Please continue to register.</div>');
    $this->redirect('/');
  }
  
  #****************** This function is used to send request of forgot password request********************
  
	function admin_forgotpassword() {
	 if(!empty($this->request->data)){
		App::import('Model','Admin');
		$this->Admin = new Admin();
		$username = $this->request->data['Admin']['adminUserName'];
		$adminDetail = $this->Admin->find('first',array('fields'=>array('Admin.email','Admin.password')));
		$emailResult=$adminDetail['Admin']['email'];
		$passwordResult=$adminDetail['Admin']['password'];
       if(!empty($username) && ($username==$emailResult) ) {
      		$email           = $adminDetail['Admin']['email'];
		      $data            = 'Hello Admin<br />Your password is as follows:<br />Password:'.$adminDetail['Admin']['password'];
		      $this->Email->to = $email;
					$this->Email->from = ADMIN_EMAIL;
					$this->Email->sendAs= 'html';
					$this->Email->subject = 'Forgot Password';
					$this->Email->text_body = $data;
					if($this->Email->send()){
					$this->Session->setFlash('<div class="success">Your Credential has been sent to '.$email.'</div>');
				}else{
						$this->Session->setFlash('<div class="fail">Error sending credentials</div>');
					}
  		} else {
  			$this->Session->setFlash('<div class="fail">Please enter the correct Username</div>');
  		}
    }
	}
	
	
	
}//ec

?>