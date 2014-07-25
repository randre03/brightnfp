<?php
App::uses('Core', 'Controller');
class AppController extends Controller{
	
	var $components = array('Session','RequestHandler');
	var $helpers =  array('Text','Html', 'Form','Ajax','Javascript','Session','PaypalIpn.Paypal');
  /*
    Before filter
  */
  function beforeFilter(){
    App::import('Model','Fee');
    $this->Fee = new Fee();
    $fee = $this->Fee->find('first',array('fields'=>array('Fee.amount')));
    $this->set('fee',$fee['Fee']['amount']); 
    $options = array('10'=>'10','20'=>'20','50'=>'50','100'=>'100');
    $this->set('options',$options);
		$admin_user_id = $this->Session->read('SESSION_ADMIN.id');
		if(isset($admin_user_id)){
        App::import('Model','Message');
        $this->Message = new Message();
        $unreadCount = $this->Message->find('count',array('conditions'=>array('Message.reciever_id'=>$admin_user_id,'Message.sender'=>'NPO','Message.read'=>'No','Message.admin_deleted'=>'No')));
    		$this->set('unreadCount',$unreadCount);
		}
		$npo_id =  $this->Session->read('SESSION_USER.Npo.id');
		if(isset($npo_id)){
        App::import('Model','Message');
        $this->Message = new Message();
        $innerUnreadCount = $this->Message->find('count',array('conditions'=>array('Message.reciever_id'=>$npo_id,'Message.sender'=>'Admin','Message.read'=>'No','Message.npo_deleted'=>'No')));
    		
        $this->set('innerUnreadCount',$innerUnreadCount);
		}
    $this->set('admin_user_id',$admin_user_id);
    if(isset($this->request->params['prefix']) && $this->request->params['prefix'] !==''){
      if($this->request->params['prefix'] === 'admin'){
        $this->layout = 'layout_admin';
      }
      if(isset($this->request->params['prefix']) && $this->request->params['prefix'] !=='' && $this->request->params['action'] !=='admin_login' && $this->request->params['action'] !=='admin_forgotpassword'){
        $this->checkSession('Admin');
      }
    }else{
        $this->layout = 'home_page';
    }
  }//ef
    /**
	* @Date: October 18, 2011
	* @Method : checkSession
	* @Purpose: This function is to check session of user/admin.
	* @Param: $type
	* @Return: none 
	**/
  function checkSession($type){
    if($type === 'Admin'){
		  $admin_user = $this->Session->read('SESSION_ADMIN');
      if(empty($admin_user)){
        $this->Session->setFlash('<div class="fail">'.__('PLEASE_LOGIN_FIRST').'</div>');
        $this->redirect(array('controller'=>'admin','action'=>'admin_login'));
      }
    }elseif($type === 'Npo'){
      $npoData = $this->Session->read('SESSION_USER.Npo');
      if(empty($npoData)){
        $this->Session->setFlash('<div class="fail">'.__('PLEASE_LOGIN_FIRST').'</div>');
        $this->redirect('/');
      }
    }elseif($type === 'Member'){
      $memberData =  $this->Session->read('SESSION_USER.Member');
      if(empty($memberData)){
        $this->Session->setFlash('<div class="fail">'.__('PLEASE_LOGIN_FIRST').'</div>');
        $this->redirect('/');
      }
    }
  }//ef
    /**
	* @Date: Nov 03, 2011
	* @Method : afterPaypalNotification
	* @Purpose: This function is to handle the post effects of a transaction.
	* @Param: $type
	* @Return: none 
	**/
  function afterPaypalNotification($txnId){
    //Here is where you can implement code to apply the transaction to your app.
    //for example, you could now mark an order as paid, a subscription, or give the user premium access.
    //retrieve the transaction using the txnId passed and apply whatever logic your site needs.
    
    $transaction = ClassRegistry::init('PaypalIpn.InstantPaymentNotification')->findById($txnId);
    $this->log($transaction['InstantPaymentNotification']['id'], 'paypal');

    //Tip: be sure to check the payment_status is complete because failure transactions 
    //     are also saved to your database for review.

    if($transaction['InstantPaymentNotification']['payment_status'] == 'Completed'){
      echo 'TXN Successfull';
      //Yay!  We have monies!
    } else {
     echo 'TXN Failed';
      //Oh no, better look at this transaction to determine what to do; like email a decline letter.
    }
  } 
  /**
	* @Date: Nov 15, 2011
	* @Method : checkSubscription
	* @Purpose: This function is to check if email is subscribed.
	* @Param: $value
	* @Return: none 
	**/
  function checkSubscription($value){
    App::import('Model','Subscriber');
    $this->Subscriber = new Subscriber();
    $count = $this->Subscriber->find('count',array('conditions'=>array('Subscriber.email_id'=>$value)));
    if($count < 1){
      echo 'Not'; exit;
    }  
  }//ef
  
  /**
	* @Date: Nov 15, 2011
	* @Method : chkSubscribed
	* @Purpose: This function is to check if email is subscribed.
	* @Param: $value
	* @Return: none 
	**/
	function chkSubscribed($value){
    App::import('Model','Subscriber');
    $this->Subscriber = new Subscriber();
    $count = $this->Subscriber->find('count',array('conditions'=>array('Subscriber.email_id'=>$value)));
    if($count == 1){
      return true;
    }else{
      return false;
    }  
  
  }//ef
    /**
	* @Date: Nov 15, 2011
	* @Method : chkDuplicate
	* @Purpose: This function is to check duplicate values for ajax call.
	* @Param: $type
	* @Return: none 
	**/
  function chkDuplicate(){
    $value = trim($this->request->params['url']['value']); 
    $field = trim($this->request->params['url']['field']); 
    $model = $this->request->params['url']['model'];
    if($field == 'email' && $model =='Npo'){
      $this->checkSubscription($value);
    }
    App::import('Model',$model);
    $this->$model = new $model();
    $result = $this->$model->find('count',array('conditions'=>array("$model.$field" =>$value)));
    if($result === 0){
      echo 'ok';
    }else{
      echo 'exists';
    }
    exit;
  }//ef 
  
  
    /**
	* @Date: Nov 15, 2011
	* @Method : chkDuplicateFields
	* @Purpose: This function is to check duplicate values for server side.
	* @Param: $type
	* @Return: none 
	**/
  function chkDuplicateFields($value,$field,$model){
    App::import('Model',$model);
    $this->$model = new $model();
    $result = $this->$model->find('count',array('conditions'=>array("$model.$field" =>$value)));
    if($result === 0){
      return true;
    }else{
      return false;
    }
    exit;
  }//ef 
  
  
  
  
    /**
	* @Date: November 23, 2011
	* @Method : has_site
	* @Purpose: This function is to check site of user.
	* @Param: $user
	* @Return: none 
	**/
  function has_site($user){
    App::import('Model','NpoTemplate');
    $this->NpoTemplate = new NpoTemplate();
		$this->Npo->recursive = 3;
    $this->NpoTemplate->bindmodel(
		              array(
		                'belongsTo'=>array(
                      'TemplateTheme' =>array(
                          'className'=>'TemplateTheme',
                          'fields'   =>'TemplateTheme.html,TemplateTheme.layout_name,TemplateTheme.name'
                      ),
                      'Npo' =>array(
                          'className'=>'Npo',
                          'fields'   =>'Npo.id'
                      )
                      
                    ),
                    'hasOne'=>array(
                        'NpoContent'=>array(
                          'className'=>'NpoContent',
                          'foreignKey'=>false,
                          'conditions'=>array('NpoContent.npo_id = NpoTemplate.npo_id')
                        )
                    )
                  ),false
                );
    $arrUserSite = $this->NpoTemplate->find('first',array('conditions'=>array('Npo.address'=>$user)));
    //pr($arrUserSite);die();
    if(isset($arrUserSite) && !empty($arrUserSite)){
      return $arrUserSite;
    }else{
      return false;
    }      
  }//ef
  
    /**
	* @Date: December 28, 2011
	* @Method : generateMenu
	* @Purpose: This function is to generate Site Menu.
	* @Param: $user
	* @Return: none 
	**/
  function generateMenu($user){
      $menu = '<li><a href="/site/events/'.$user.'">Events</li><li><a href="/site/news/'.$user.'">News</a></li>';
      return $menu;
  }
  
    /**
	* @Date: December 28, 2011
	* @Method : getCaptcha
	* @Purpose: This function is to set captcha.
	* @Param: $user
	* @Return: none 
	**/
	function captcha(){
	    $this->autoRender = false;
      $aResponse['error'] = false;
      $this->Session->write('iQaptcha',false);	
      	
      if(isset($_POST['action']))
      {
      	if(htmlentities($_POST['action'], ENT_QUOTES, 'UTF-8') == 'qaptcha')
      	{
          $this->Session->write('iQaptcha',true);
          $session = 	$this->Session->read('iQaptcha');
      		if($session){
      			echo json_encode($aResponse);
      		}else
      		{
      			$aResponse['error'] = true;
      			echo json_encode($aResponse);
      		}
      	}
      	else
      	{
      		$aResponse['error'] = true;
      		echo json_encode($aResponse);
      	}
      }
      else
      {
      	$aResponse['error'] = true;
      	echo json_encode($aResponse);
      }
  }//ef
  
  
}//ec