<?php
class MembersController extends AppController{
  var $name = 'Members';  
  var $uses = array('NpoMember','Member');
	var $components = array('Email'); 
    /**
	* @Date: November 30, 2011
	* @Method : index
	* @Purpose: This function is to retrieve the member list.
	* @Param: none
	* @Return: none 
	**/
  function index(){
    $this->checkSession('Npo');  
    $this->layout = 'layout_inner';
    
	  $npoId     = $this->Session->read('SESSION_USER.Npo.id');
		$this->NpoMember->updateAll(array('NpoMember.seen'=>'"Yes"'),array('NpoMember.npo_id'=>$npoId,'NpoMember.seen'=>'No'));  
    
    if(isset($this->request->data['pagecount']) && !empty($this->request->data['pagecount'])){  	   
      $limit =  $this->request->data['pagecount'];
    }else if(isset($this->request->params['named']['recCount']) && !empty($this->request->params['named']['recCount'])){
      $limit = $this->request->params['named']['recCount'];
    }else{
      $limit = 10;
    }
    
    $this->set('recCount',$limit);
		$this->helpers['Paginator'] = array('ajax' => 'Ajax');
    
	  $this->NpoMember->bindModel(
	       array(
	         'belongsTo'=>array(
	             'Member'=>array(
	               'className'  => 'Member',
                 'foreignKey' => 'member_id'
               )          
           )
        ),false
    );
    $this->NpoMember->bindModel(
	       array(
	         'belongsTo'=>array(
	             'Npo'=>array(
	               'className'  => 'Npo',
                 'foreignKey' => 'npo_id',
               )          
           )
        ),false
    );
    $this->paginate = array('conditions'=>array('NpoMember.npo_id'=>$npoId,'NpoMember.status !='=>'Deleted'),
                            'order'     => array('NpoMember.modified DESC'),
                            'fields'     => 'NpoMember.id,NpoMember.status,Member.email,Member.name,NpoMember.created',
                            'limit'     => $limit
                              );	 
    $npoMember =  $this->paginate('NpoMember');
    $this->set('npoMember',$npoMember);
    if($this->RequestHandler->isAjax()) 
		{
	      $this->layout = 'ajax';
				$this->viewPath = 'elements'.DS.'members';
				$this->render('listing');
		}
		
  }//ef
   /**
	* @Date: November 30, 2011
	* @Method : read
	* @Purpose: This function is to retrieve the member list.
	* @Param: none
	* @Return: none 
	**/
	function toggle_status($status,$id){
    $this->autoRender = false;
    $update = array();
    $update['id'] = $id;
    if($status ==='disable'){
      $update['status'] = 'Inactive';
    }else{
      $update['status'] = 'Active';
    }
    $this->NpoMember->save($update);
    $this->redirect(array('controller' => 'members', 'action' => 'index'));
  }
   /**
	* @Date: November 30, 2011
	* @Method : deletemember
	* @Purpose: This function is to delete the member.
	* @Param: none
	* @Return: none 
	**/
	function deletemember($id){
    $this->autoRender = false;
    $update = array();
    $update['id'] = $id;
    $update['status'] = 'Deleted';
    $this->NpoMember->save($update);
    $this->redirect(array('controller' => 'members', 'action' => 'index'));
    
  }//ef
   /**
	* @Date: November 30, 2011
	* @Method : addmember
	* @Purpose: This function is to add member.
	* @Param: none
	* @Return: none 
	**/
	function addmember(){
    $this->checkSession('Npo');  
    $this->layout = 'layout_inner';
    if(!empty($this->request->data)){
      $this->Member->set($this->request->data);
      if($this->Member->validates()){
        $data     = array();
        $data['email']    = $this->request->data['Member']['email']; 
        $data['name']     = $this->request->data['Member']['usrName']; 
        $data['password'] = $this->request->data['Member']['usrPassword']; 
        $data['status']   = 'Active';
        if($this->Member->save($data)){
          $memData              = array();
          $memData['npo_id']    = $this->Session->read('SESSION_USER.Npo.id');   
          $memData['member_id'] = $this->Member->getLastInsertID();
          $this->NpoMember->save($memData);
          $this->Session->setFlash('<div class="success">Member created successfully.</div>');
          $this->redirect(array('controller'=>'members','action'=>'index'));
        }else{
          $this->Session->setFlash('<div class="fail">Error saving the member.Please try again.</div>');
        } 
      }
    }
  }//ef
  
   /**
	* @Date: December 06, 2011
	* @Method : memberdashboard
	* @Purpose: This function is for member dashboard.
	* @Param: none
	* @Return: none 
	**/
	function memberdashboard(){
    $this->checkSession('Member');
    $this->layout = 'layout_inner';
  }//ef
  
    /**
	* @Date: December 15, 2011
	* @Method : sendmessage
	* @Purpose: This function is to send messages to member.
	* @Param: none
	* @Return: none 
	**/
	function sendmessage(){
    $this->checkSession('Npo');  
    $this->layout = 'layout_inner';
    if(isset($this->request->data['Member']['memEmail'])){
       $this->Member->set($this->request->data);
       if($this->Member->validates()){ 
        $arrEventIds = explode('#',$this->request->data['Member']['memEmail']);
        foreach($arrEventIds as $key=>$val){
          if($val != '0'){
              $data            = $this->request->data['Member']['msgEvent'];
              $this->Email->to = $val;
      				$this->Email->from = ADMIN_EMAIL;
      				$this->Email->sendAs= 'html';
      				$this->Email->subject = $this->request->data['Member']['subject'];
      				$this->Email->text_body = $data;
              $this->Email->send();
          }
        }
        $this->Session->setFlash('<div class="success">Message sent successfully to member(s)</div>');
        $this->redirect(array('controller'=>'members','action'=>'index'));
        }else{
          $this->set('memEmail',$this->request->data['Member']['memEmail']);       
        }
    }else{
          $memEmail = implode('#',$this->request->data['Message']['chkRec']);
          $this->set('memEmail',$memEmail);    
    }
  }//ef
}//ec
?>