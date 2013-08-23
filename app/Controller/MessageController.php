<?php
class MessageController extends AppController{
  var $name = 'Message';
  var $uses = array('Npo','Message');
   /**
	* @Date: October 18, 2011
	* @Method : admin_compose
	* @Purpose: This function is to compose messages to npos/churches.
	* @Param: none
	* @Return: none 
	**/
  function admin_compose($id=''){ 
    $npos  = $this->Npo->find('list',array('fields'=>array('Npo.id','Npo.email'),'conditions'=>array('Npo.status !='=>'deleted')));
    $this->set('npos',$npos);
    if(!empty($this->request->data)){
      $this->Message->set($this->request->data);
      if($this->Message->validates()){
        $data['sender_id']     = $this->Session->read('SESSION_ADMIN.id');
        $data['reciever_id']   = $this->request->data['Message']['to'];
        $data['read']          = 'No';
        $data['sender']        = 'Admin';
        $data['subject']       = $this->request->data['Message']['subject'];
        $data['message']       = $this->request->data['Message']['message'];
        if($this->Message->save($data)){
          $this->Session->setFlash('<div class="success">'.__('MESSAGE_SENT_SUCCESFULLY').'</div>');
          $this->redirect(array('controller'=>'message','action'=>'compose','admin'=>true));
        }else{
          $this->Session->setFlash('<div class="fail">'.__('ERROR_SENDING_MESSAGE').'</div>');          
        }
      }else{
        $errors = $this->Message->validationErrors;
        $this->set('error',$errors);
      }
    }
     
  if($id !==''){
      $this->Message->bindModel(
    	       array(
    	         'belongsTo'=>array(
    	             'Npo'=>array(
    	               'className'  => 'Npo',
                     'foreignKey' => 'sender_id'
                   )          
               )
            )
        );
      $selected = $this->Message->find('first',array('fields'=>array('Message.subject,Npo.id'),'conditions'=>array('Message.id'=>$id)));
      $selectedNpo = $selected['Npo']['id'];
      $this->set('selectedNpo',$selectedNpo);
      $this->request->data['Message']['subject'] = 'Re: '.$selected['Message']['subject'];  
    }
    
  }//ef
  
    /**
	* @Date: October 18, 2011
	* @Method : admin_sent
	* @Purpose: This function is to check sent messages to npos/churches from admin.
	* @Param: none
	* @Return: none 
	**/
	function admin_sent(){
	  $userId     = $this->Session->read('SESSION_ADMIN.id');
		$this->helpers['Paginator'] = array('ajax' => 'Ajax');
    if(isset($this->request->data['pagecount']) && !empty($this->request->data['pagecount'])){  	   
  	  $limit =  $this->request->data['pagecount'];
  	}else if(isset($this->request->params['named']['recCount']) && !empty($this->request->params['named']['recCount'])){
  	  $limit = $this->request->params['named']['recCount'];
    }else{
  	  $limit = 10;
    }
    $this->set('recCount',$limit);
	  $this->Message->bindModel(
	       array(
	         'belongsTo'=>array(
	             'Npo'=>array(
	               'className'  => 'Npo',
                 'foreignKey' => 'reciever_id',
                 'fields'     => 'Npo.email'
               )          
           )
        ),false
    );
    $this->paginate = array('conditions'=>array('Message.sender_id'=>$userId,'Message.sender'=>'Admin','Message.admin_deleted' =>'No'),
                            'order'     => array('Message.modified DESC'),
                            'limit'     => $limit,
                            'fields'    =>'Message.id,Message.created,Message.modified,Message.subject,Message.message,Message.read,Npo.email'
                              );	 
    $sentMsg =  $this->paginate('Message');
   // pr($sentMsg);die();
    $this->set('sentMsg',$sentMsg);
    if($this->RequestHandler->isAjax()) 
		{
	      $this->layout = 'ajax';
				$this->viewPath = 'elements'.DS.'sent';
				$this->render('sent');
		}
  }//ef
  
  
    /**
	* @Date: October 19, 2011
	* @Method : admin_view_message
	* @Purpose: This function is to view messages of admin.
	* @Param: none
	* @Return: none 
	**/
  function admin_view_message($id,$type =''){
    $this->set('type',$type);    
	  $this->Message->bindModel(
	       array(
	         'belongsTo'=>array(
	             'Npo'=>array(
	               'className'  => 'Npo',
                 'foreignKey' => 'reciever_id',
                 'fields'     => 'Npo.email'
               )          
           )
        )
    );
    $fields     = array('Message.id,Message.subject,Message.message,Message.read,Message.created,Message.modified,Npo.email');
    $conditions = array('Message.id' => $id);
    $message    = $this->Message->find('first',array('conditions'=>$conditions,'fields'=>$fields));
   //pr($message);die();
    if($type ==='adminInbox'){
      $admin_user_id = $this->Session->read('SESSION_ADMIN.id');
      $data['id']   = $message['Message']['id'];
      $data['read'] = 'Yes';
      $this->Message->save($data);
      $unreadCount = $this->Message->find('count',array('conditions'=>array('Message.reciever_id'=>$admin_user_id,'Message.sender'=>'NPO','Message.read'=>'No','Message.admin_deleted'=>'No')));
		  $this->set('unreadCount',$unreadCount);
    }
    $this->set('message',$message);
    $this->set('type',$type);
  }//ef
  
  
    /**
	* @Date: October 19, 2011
	* @Method : admin_delete_message
	* @Purpose: This function is to delete messages of admin.
	* @Param: none
	* @Return: none 
	**/
  function admin_delete_message($id,$type=''){
    $this->autoRender     = false;
    $data                   = array();
    $data['id']             = $id;
    $data['admin_deleted']  = 'Yes';
    $this->Message->save($data);
    $userId     = $this->Session->read('SESSION_ADMIN.id');
    if($type==='adminInbox'){
      $action = 'inbox';
    }else{
      $action = 'sent';      
    }
    $this->redirect(array('controller'=>'message','action'=>$action,'admin'=>true));		
  }//ef
  
  
  
    /**
	* @Date: October 19, 2011
	* @Method : admin_inbox
	* @Purpose: This function is to view inbox of admin.
	* @Param: none
	* @Return: none 
	**/
	function admin_inbox(){
    if(isset($this->request->data['pagecount']) && !empty($this->request->data['pagecount'])){  	   
  	  $limit =  $this->request->data['pagecount'];
  	}else if(isset($this->request->params['named']['recCount']) && !empty($this->request->params['named']['recCount'])){
  	  $limit = $this->request->params['named']['recCount'];
    }else{
  	  $limit = 10;
    }
    $this->set('recCount',$limit);
	  $userId     = $this->Session->read('SESSION_ADMIN.id');
		$this->helpers['Paginator'] = array('ajax' => 'Ajax');
    
	  $this->Message->bindModel(
	       array(
	         'belongsTo'=>array(
	             'Npo'=>array(
	               'className'  => 'Npo',
                 'foreignKey' => 'sender_id',
                 'fields'     => 'Npo.username'
               )          
           )
        ),false
    );
    $this->paginate = array('conditions'=>array('Message.reciever_id'=>$userId,'Message.sender'=>'NPO','Message.admin_deleted' =>'No'),
                            'order'     => array('Message.read DESC'),
                            'limit'     => $limit,
                            'fields'    =>'Message.id,Message.subject,Message.message,Message.created,Message.read,Npo.email'
                              );	 
    $inboxMsg =  $this->paginate('Message');
    //pr($inboxMsg);die();
    $this->set('inboxMsg',$inboxMsg);
    if($this->RequestHandler->isAjax()) 
		{
	      $this->layout = 'ajax';
				$this->viewPath = 'elements'.DS.'inbox';
				$this->render('inbox');
		}
    
  }//ef
  
  
    /**
	* @Date: October 19, 2011
	* @Method : admin_deleteall
	* @Purpose: This function is to view inbox of admin.
	* @Param: none
	* @Return: none 
	**/
	function admin_deleteall(){
    if(!empty($this->request->data)){
      foreach($this->request->data['Npo']['chkRec'] as $key=>$value){
        if($value != 0 && $value != '' && $key !='chkAll'){
          $data                   = array();
          $data['id']             = $value;
          $data['admin_deleted']  = 'Yes';
          $this->Message->save($data);
        }
      }
      $this->Session->setFlash('<div class="success">'.__('MSG_DELETED_SUCCESFULLY').'</div>');
      
      if($this->request->data['Npo']['type'] ==='inbox'){
        $action = 'inbox';
      }else{
        $action = 'sent';
      }
      $this->redirect(array('controller'=>'message','action'=>$action,'admin'=>true));
    }
  }//ef
  
  
    /**
	* @Date: November 25, 2011
	* @Method : compose
	* @Purpose: This function is to compose.
	* @Param: none
	* @Return: none 
	**/
  
  function compose($id=''){
    $this->checkSession('Npo');  
    $this->layout = 'layout_inner';
    App::import('Model','Message');
    $this->Message = new Message();
    if(!empty($this->request->data)){
      $data             = array();
      $data['subject']      = $this->request->data['Message']['subject'];
      $data['message']      = $this->request->data['Message']['msgEvent'];
      $data['reciever_id']  = 1;
      $data['sender_id']    = $this->Session->read('SESSION_USER.Npo.id');
      $data['sender']    =  'NPO';
      if($this->Message->save($data)){
        $this->Session->setFlash('<div class="success">Message sent succesfully.</div>');
        $this->redirect(array('controller'=>'npo','action'=>'npodashboard'));
      }else{
        $this->Session->setFlash('<div class="fail">Error sending message.</div>');
      }
    }elseif($id !==''){
      $msg_detail = $this->Message->find('first',array('fields'=>array('Message.subject'),'conditions'=>array('Message.id' =>$id)));
      $this->request->data['Message']['subject'] = 'Re '.$msg_detail['Message']['subject'];
    }
  }//ef
  
  
  
    /**
	* @Date: November 26, 2011
	* @Method : inbox
	* @Purpose: This function is for inbox.
	* @Param: none
	* @Return: none 
	**/
	function inbox(){
    $this->checkSession('Npo');  
    $this->layout = 'layout_inner';
    $userId = $this->Session->read('SESSION_USER.Npo.id');    
    if(isset($this->request->data['pagecount']) && !empty($this->request->data['pagecount'])){  	   
  	  $limit =  $this->request->data['pagecount'];
  	}else if(isset($this->request->params['named']['recCount']) && !empty($this->request->params['named']['recCount'])){
  	  $limit = $this->request->params['named']['recCount'];
    }else{
  	  $limit = 10;
    }
    $this->set('recCount',$limit);
		$this->helpers['Paginator'] = array('ajax' => 'Ajax');
		$conditions = array('Message.reciever_id'=>$userId,'Message.sender'=>'Admin','Message.npo_deleted' =>'No');
    if(isset($this->request->data['Npo']['searchElement']) && $this->request->data['Npo']['searchElement'] !==''){
      $element = trim($this->request->data['Npo']['searchElement']);
          if($this->request->data['Npo']['searchType'] === 'message'){
            $conditions['OR']= array(
                                  'Message.message LIKE' =>'%'.$element.'%'
                              );
          }elseif($this->request->data['Npo']['searchType'] === 'subject'){
            $conditions['OR']= array(
                                  'Message.subject LIKE'  =>'%'.$element.'%'
                              );
          }else{          
            $conditions['OR']= array(
                                  'Message.created LIKE'  =>'%'.date(Configure::read('MYSQL_DATE_FORMAT'),strtotime($element)).'%'
                              );
          }
    }
    $this->paginate = array('conditions'=>array($conditions),
                            'order'     => array('Message.read DESC'),
                            'limit'     => $limit,
                            'fields'    =>'Message.id,Message.subject,Message.message,Message.created,Message.read'
                              );	 
    $inboxMsg =  $this->paginate('Message');
    //pr($inboxMsg);die();
    $this->set('inboxMsg',$inboxMsg);
    if($this->RequestHandler->isAjax()) 
		{
	      $this->layout = 'ajax';
				$this->viewPath = 'elements'.DS.'inbox';
				$this->render('listing');
		}
    
  }//ef
  
  
  
    /**
	* @Date: November 28, 2011
	* @Method : read
	* @Purpose: This function is to read the message.
	* @Param: id
	* @Return: none 
	**/
  function read($id,$type=''){
    $this->checkSession('Npo');  
    $this->layout = 'layout_inner';
    if($type =='inbox'){
      $update         = array();
      $update['id']   = $id;
      $update['read'] = 'Yes';
      $this->Message->save($update);
    }
		$npo_id =  $this->Session->read('SESSION_USER.Npo.id');
    $innerUnreadCount = $this->Message->find('count',array('conditions'=>array('Message.reciever_id'=>$npo_id,'Message.sender'=>'Admin','Message.read'=>'No','Message.admin_deleted'=>'No')));
		$this->set('innerUnreadCount',$innerUnreadCount);
    $msg_detail = $this->Message->find('first',array('fields'=>array('Message.id,Message.subject,Message.message,Message.created'),'conditions'=>array('Message.id'=>$id)));
    $this->set('msg_detail',$msg_detail);
    $this->set('type',$type);
  }//ef
  
  
    /**
	* @Date: November 28, 2011
	* @Method : sent
	* @Purpose: This function is for the sent items.
	* @Param: none
	* @Return: none 
	**/
	function sent(){    
    $this->checkSession('Npo');  
    $this->layout = 'layout_inner';
    $userId = $this->Session->read('SESSION_USER.Npo.id');    
    if(isset($this->request->data['pagecount']) && !empty($this->request->data['pagecount'])){  	   
  	  $limit =  $this->request->data['pagecount'];
  	}else if(isset($this->request->params['named']['recCount']) && !empty($this->request->params['named']['recCount'])){
  	  $limit = $this->request->params['named']['recCount'];
    }else{
  	  $limit = 10;
    }
    $this->set('recCount',$limit);
		$this->helpers['Paginator'] = array('ajax' => 'Ajax');
		$conditions = array('Message.sender_id'=>$userId,'Message.sender'=>'Npo','Message.npo_deleted' =>'No');
    if(isset($this->request->data['Npo']['searchElement']) && $this->request->data['Npo']['searchElement'] !==''){
      $element = trim($this->request->data['Npo']['searchElement']);
          if($this->request->data['Npo']['searchType'] === 'message'){
            $conditions['OR']= array(
                                  'Message.message LIKE' =>'%'.$element.'%'
                              );
          }elseif($this->request->data['Npo']['searchType'] === 'subject'){
            $conditions['OR']= array(
                                  'Message.subject LIKE'  =>'%'.$element.'%'
                              );
          }else{          
            $conditions['OR']= array(
                                  'Message.created LIKE'  =>'%'.date(Configure::read('MYSQL_DATE_FORMAT'),strtotime($element)).'%'
                              );
          }
    }
    $this->paginate = array('conditions'=>array($conditions),
                            'order'     => array('Message.read DESC'),
                            'limit'     => $limit,
                            'fields'    =>'Message.id,Message.subject,Message.message,Message.created,Message.read'
                              );	 
    $sentMsg =  $this->paginate('Message');
    $this->set('sentMsg',$sentMsg);
    if($this->RequestHandler->isAjax()) 
		{
	      $this->layout = 'ajax';
				$this->viewPath = 'elements'.DS.'sent';
				$this->render('listing');
		}
  }//ef
  
  
    /**
	* @Date: November 30, 2011
	* @Method : deletemessage
	* @Purpose: This function is for deleting the message.
	* @Param: id
	* @Return: none 
	**/
	function deletemessage($id ='',$type){ 
	 $this->autoRender     = false;
    $data                   = array();
    $data['id']             = $id;
    $data['npo_deleted']  = 'Yes';
    $this->Message->save($data);
    $userId     = $this->Session->read('SESSION_USER.Npo.id');
    if($type==='inbox'){
      $action = 'inbox';
    }else{
      $action = 'sent';      
    }
    $this->redirect(array('controller'=>'message','action'=>$action));
  }//ef
  
    /**
	* @Date: November 30, 2011
	* @Method : deleteallmessage
	* @Purpose: This function is for deleting the message.
	* @Param: id
	* @Return: none 
	**/
	function deleteallmessage($id =''){	 
    if(!empty($this->request->data)){
      foreach($this->request->data['Message']['chkRec'] as $key=>$value){
        if($value != 0 && $value != '' && $key !='chkAll'){
          $data                   = array();
          $data['id']             = $value;
          $data['npo_deleted']  = 'Yes';
          $this->Message->save($data);
        }
      }
      $this->Session->setFlash('<div class="success">'.__('MSG_DELETED_SUCCESFULLY').'</div>');
      
      if($this->request->data['Message']['type'] ==='inbox'){
        $action = 'inbox';
      }else{
        $action = 'sent';
      }
      $this->redirect(array('controller'=>'message','action'=>$action));
    }
  }//ef
}//ec
?>