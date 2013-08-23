<?php 
class AdminController extends AppController{
  var $name = 'Admin';
  var $uses = array('Admin');
  
  /**
	* @Date: October 17, 2011
	* @Method : admin_login
	* @Purpose: This function is to login admin.
	* @Param: none
	* @Return: none 
	**/
  function admin_login(){
  
		$user_id = $this->Session->read('SESSION_ADMIN.id');
		if(!empty($user_id))
			$this->redirect('/admin/admin/dashboard');
			
        if(!empty($this->request->data))
    		{
    			$this->Admin->set($this->request->data);
    				
    				if($this->Admin->validates())
    				{				
    				$user_name = mysql_real_escape_string($this->request->data['Admin']['adminUserName']);
    				$user_password  = mysql_real_escape_string($this->request->data['Admin']['adminPassword']);
    				$userinfo = $this->Admin->find('first',array('conditions'=>array("Admin.username"=>$user_name,"Admin.password"=>$user_password,'Admin.status'=>'Active')));
    			
            if(!empty($userinfo)){
            //pr($userinfo); die;				
    					$this->Session->write('SESSION_ADMIN', $userinfo['Admin']);
    			    $this->redirect('/admin/admin/dashboard');
    				} else {
    					$this->Session->setFlash('<div class="fail">'.__('USERNAME_PASSWORD_INCORRECT').'</div>');
    				}
    			} else  {
    				$this->set('error', true);
    			}
      }
  }//ef
  
  
  /**
	* @Date: October 17, 2011
	* @Method : admin_dashboard
	* @Purpose: This function is for admin dashboard.
	* @Param: none
	* @Return: none 
	**/
	
	function admin_dashboard(){
  
  }//ef
  
  
  /**
	* @Date: October 17, 2011
	* @Method : admin_logout
	* @Purpose: This function is for admin logout.
	* @Param: none
	* @Return: none 
	**/
  
  function admin_logout() {
		if(!empty($_SESSION)){
			foreach($_SESSION AS $session_index => $session_variable){
				if($session_index == 'SESSION_ADMIN'){
					$this->Session->delete($session_index);
				}
			}
		}
		$this->Session->setFlash('<div class="success">'.__('LOGOUT_SUCESSFULL').'</div>');
    $this->redirect("/admin/");
	}//ef
  
  
  
  /**
	* @Date: November 08, 2011
	* @Method : admin_fee
	* @Purpose: This function is for fee management.
	* @Param: none
	* @Return: none 
	**/
	function admin_fee(){
    App::import('Model','Fee');
    $this->Fee = new Fee();
    $fee = $this->Fee->find('first',array('fields'=>array('Fee.amount','Fee.id')));
    $this->set('fee',$fee);
    if(!empty($this->request->data)){
      $this->Fee->set($this->request->data);
      if($this->Fee->validates()){
        $data           = array();
        $data['id']     = $fee['Fee']['id'];
        $data['amount'] = $this->request->data['Fee']['amount'];
        $this->Fee->set($data);        
        if($this->Fee->save($data))
          $this->Session->setFlash('<div class="success">'.__('AMOUNT_SAVED_SUCCESSFULLY').'</div>');
          $this->redirect(array('controller'=>'admin','action'=>'fee','admin'=>true));
      }else{
        $this->set('errors',true);
      }
    }
    
  }//ef
  
}//ec

?>