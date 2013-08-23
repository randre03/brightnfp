<?php 
class NpoController extends AppController{
  var $name = 'Npo';
  var $uses = array('Npo');
  var $helpers = array('PaypalIpn.Paypal');
  var $components  = array('Uploader.Uploader');

    /**
	* @Date: October 17, 2011
	* @Method : admin_login
	* @Purpose: This function is to manage npos/churches listing.
	* @Param: none
	* @Return: none 
	**/
	function admin_manage_npo(){
    App::import('Model','NpoTemplate');	
    $this->NpoTemplate = new NpoTemplate();
  	
    if(isset($this->request->data['pagecount']) && !empty($this->request->data['pagecount'])){  	   
  	  $limit =  $this->request->data['pagecount'];
  	}else if(isset($this->request->params['named']['recCount']) && !empty($this->request->params['named']['recCount'])){
  	  $limit = $this->request->params['named']['recCount'];
    }else{
  	  $limit = 10;
    }
    $this->set('recCount',$limit);
		$this->helpers['Paginator'] = array('ajax' => 'Ajax');
		$this->Npo->recursive = 2;
		$this->Npo->bindmodel(
		              array(
		                'hasOne'=>array(
                      'NpoTemplate' =>array(
                          'className'=>'NpoTemplate'
                      )
                    )
                  ),false
                );
		$this->NpoTemplate->bindmodel(
		              array(
		                'belongsTo'=>array(
                      'Template' =>array(
                          'className'=>'Template',
                          'fields' =>'Template.name'
                      )
                    )
                  ),false
                );
    $this->paginate = array(
                              'conditions' => array('Npo.status !='=>'Deleted'),
                              'fields'=>array('Npo.id','Npo.title','Npo.email','Npo.created','Npo.modified','Npo.status'),
                              'order' => array('Npo.modified DESC'),
                              'limit' =>$limit
                              );
    $npoList = $this->paginate('Npo');
    $this->set('npoList',$npoList);
    if($this->RequestHandler->isAjax()) 
		{
	      $this->layout = 'ajax';
				$this->viewPath = 'elements'.DS.'npo';
				$this->render('npo_list');
		}
  }//ef
  
    /**
	* @Date: October 18, 2011
	* @Method : admin_toggle_status
	* @Purpose: This function is to manage status of npos/churches.
	* @Param: none
	* @Return: none 
	**/
  function admin_toggle_status($status,$id){
    $this->autoRender = false;
    $update = array();
    $update['id'] = $id;
    if($status ==='disable'){
      $update['status'] = 'Inactive';
    }else{
      $update['status'] = 'Active';
    }
    $this->Npo->save($update);
    $this->redirect(array('controller' => 'npo', 'action' => 'admin_manage_npo','admin'=>true));
  }
  
  /**
	* @Date: Nov 21, 2011
	* @Method : npo_dashboard
	* @Purpose: This function is to get to dashboard.
	* @Param: none
	* @Return: none 
	**/  
  
  function npodashboard(){
    $this->checkSession('Npo');
    $this->layout = 'layout_inner';
    $npoId = $this->Session->read('SESSION_USER.Npo.id');
    App::import('Model','NpoMember');
    $this->NpoMember = new NpoMember();
    $count = $this->NpoMember->find('count',array('conditions'=>array('NpoMember.npo_id'=>$npoId,'NpoMember.status'=>'Inactive','NpoMember.seen'=>'No'))); 
    if($count > 0){
      $this->Session->setFlash('<div class="success">'.$count.' new member request(s).</div>');
    }  
  }//ef
  
  /**
	* @Date: December 08, 2011
	* @Method : index
	* @Purpose: This function is to show listing of NPO/Churches.
	* @Param: none
	* @Return: none 
	**/  
  
  function index(){
    $this->checkSession('Member');
    $this->layout = 'layout_inner';
    $this->helpers['Paginator'] = array('ajax' => 'Ajax');
    if(isset($this->request->data['pagecount']) && !empty($this->request->data['pagecount'])){  	   
  	  $limit =  $this->request->data['pagecount'];
  	}else if(isset($this->request->params['named']['recCount']) && !empty($this->request->params['named']['recCount'])){
  	  $limit = $this->request->params['named']['recCount'];
    }else{
  	  $limit = 10;
    }
    $this->set('recCount',$limit);
		$this->helpers['Paginator'] = array('ajax' => 'Ajax');
		$memberId = $this->Session->read('SESSION_USER.Member.id');
		
	  App::import('Model','NpoMember');
    $this->NpoMember = new NpoMember();
    $arrNpoId = $this->NpoMember->find('all',array('fields'=>array('NpoMember.npo_id'),'conditions'=>array('NpoMember.member_id'=>$memberId)));
		//pr($arrNpoId);die();
		$memberIds = array();
		foreach($arrNpoId as $key=>$val){
		  $memberIds[] = $val['NpoMember']['npo_id'];		  
    }
    $conditions = array('Npo.status'=>'Active','NOT'=>array('Npo.id'=>$memberIds));
    if(isset($this->request->data['Npo']['searchElement']) && $this->request->data['Npo']['searchElement'] !=''){
      $searchedElement = $this->request->data['Npo']['searchElement'];
      $conditions[] = array(
                        'OR'=>array(
                          'Npo.title LIKE' => '%'.$searchedElement.'%',
                          'Npo.description LIKE' => '%'.$searchedElement.'%'
                        )
                      );
    }
		$this->paginate = array(
                              'conditions' => $conditions,
                              'fields'=>array('Npo.id','Npo.title','Npo.description','Npo.thumb'),
                              'order' => array('Npo.modified DESC'),
                              'limit' =>$limit
                              );
    $npoList = $this->paginate('Npo');
    $this->set('npoList',$npoList);
    if($this->RequestHandler->isAjax()){
	      $this->layout = 'ajax';
				$this->viewPath = 'elements'.DS.'npo';
				$this->render('frontend_npo_list');
		}
    
  }//ef
  
  /**
	* @Date: December 13, 2011
	* @Method : request
	* @Purpose: This function is to send request to NPO/Churches.
	* @Param: id
	* @Return: none 
	**/  
	function request(){
    $this->checkSession('Member');
    $this->autoRender = false;
	  App::import('Model','NpoMember');
    $this->NpoMember = new NpoMember();
    $data               = array();
    $data['npo_id']     = $this->request->params['url']['npoId']; 
    $data['member_id']  = $this->Session->read('SESSION_USER.Member.id'); 
    $data['status']     = 'Inactive';
    $data['seen']       = 'No';
    if($this->NpoMember->save($data)){
      echo 'success';exit;
    }else{
      echo 'fail';exit;
    }
  }//ef	
  
  /**
	* @Date: December 13, 2011
	* @Method : pendingnpo
	* @Purpose: This function is for pending NPO/Churches.
	* @Param: none
	* @Return: none 
	**/  
	function pendingnpo(){    
    $this->checkSession('Member');
    $this->layout = 'layout_inner';
    $this->helpers['Paginator'] = array('ajax' => 'Ajax');
    if(isset($this->request->data['pagecount']) && !empty($this->request->data['pagecount'])){  	   
  	  $limit =  $this->request->data['pagecount'];
  	}else if(isset($this->request->params['named']['recCount']) && !empty($this->request->params['named']['recCount'])){
  	  $limit = $this->request->params['named']['recCount'];
    }else{
  	  $limit = 10;
    } 
		$memberId = $this->Session->read('SESSION_USER.Member.id');
    $conditions = array('NpoMember.status'=>'Inactive','NpoMember.member_id'=>$memberId);
    if(isset($this->request->data['Npo']['searchElement']) && $this->request->data['Npo']['searchElement'] !=''){
      $searchedElement = $this->request->data['Npo']['searchElement'];
      $conditions[] = array(
                        'OR'=>array(
                          'Npo.title LIKE' => '%'.$searchedElement.'%',
                          'Npo.description LIKE' => '%'.$searchedElement.'%'
                        )
                      );
    }
    $this->set('recCount',$limit);
		$this->helpers['Paginator'] = array('ajax' => 'Ajax');
		
	  App::import('Model','NpoMember');
    $this->NpoMember = new NpoMember();
    
    $this->NpoMember->bindmodel(
		              array(
		                'belongsTo'=>array(
                      'Npo' =>array(
                          'className'=>'Npo'
                      )
                    )
                  ),false
                );
		$this->paginate = array(
                              'conditions' => $conditions,
                              'fields'=>array('Npo.id','Npo.title','Npo.description','Npo.thumb'),
                              'order' => array('Npo.modified DESC'),
                              'limit' =>$limit
                              );
    $npoList = $this->paginate('NpoMember');
   // pr($npoList);die();
    $this->set('npoList',$npoList);
    if($this->RequestHandler->isAjax()){
	      $this->layout = 'ajax';
				$this->viewPath = 'elements'.DS.'npo';
				$this->render('frontend_pending_npo_list');
		}
    
  }//ef
	  	
  /**
	* @Date: December 13, 2011
	* @Method : mynpos
	* @Purpose: This function is for members NPO/Churches.
	* @Param: none
	* @Return: none 
	**/  
	function mynpos(){	    
    $this->checkSession('Member');
    $this->layout = 'layout_inner';
    $this->helpers['Paginator'] = array('ajax' => 'Ajax');
    if(isset($this->request->data['pagecount']) && !empty($this->request->data['pagecount'])){  	   
  	  $limit =  $this->request->data['pagecount'];
  	}else if(isset($this->request->params['named']['recCount']) && !empty($this->request->params['named']['recCount'])){
  	  $limit = $this->request->params['named']['recCount'];
    }else{
  	  $limit = 10;
    }
    $this->set('recCount',$limit);
		$this->helpers['Paginator'] = array('ajax' => 'Ajax');
		$memberId = $this->Session->read('SESSION_USER.Member.id');
		
    $conditions = array('NpoMember.status'=>'Active','NpoMember.member_id'=>$memberId);
    if(isset($this->request->data['Npo']['searchElement']) && $this->request->data['Npo']['searchElement'] !=''){
      $searchedElement = $this->request->data['Npo']['searchElement'];
      $conditions[] = array(
                        'OR'=>array(
                          'Npo.title LIKE' => '%'.$searchedElement.'%',
                          'Npo.description LIKE' => '%'.$searchedElement.'%'
                        )
                      );
    }
	  App::import('Model','NpoMember');
    $this->NpoMember = new NpoMember();
    
    $this->NpoMember->bindmodel(
		              array(
		                'belongsTo'=>array(
                      'Npo' =>array(
                          'className'=>'Npo'
                      )
                    )
                  ),false
                );
		$this->paginate = array(
                              'conditions' => $conditions,
                              'fields'=>array('Npo.id','Npo.title','Npo.description','Npo.thumb'),
                              'order' => array('Npo.modified DESC'),
                              'limit' =>$limit
                              );
    $npoList = $this->paginate('NpoMember');
   // pr($npoList);die();
    $this->set('npoList',$npoList);
    if($this->RequestHandler->isAjax()){
	      $this->layout = 'ajax';
				$this->viewPath = 'elements'.DS.'npo';
				$this->render('frontend_my_npo_list');
		}
    
  }//ef
  
  
  /**
	* @Date: December 13, 2011
	* @Method : admin_detail
	* @Purpose: This function is for id detail of NPO/Churches.
	* @Param: none
	* @Return: none 
	**/  
	function admin_detail($id){
	  $this->layout='';
	  App::import('Model','Npo');
    $this->Npo = new Npo();
    $detail = $this->Npo->find('first',array('fields'=>array('Npo.taxid,Npo.corporate_name,Npo.corporate_address'),'conditions'=>array('Npo.id'=>$id)));
    //pr($detail);die();
    $this->set('detail',$detail);
  }//ef	
  
  
  /**
	* @Date: December 13, 2011
	* @Method : viewnpo
	* @Purpose: This function is for detail of NPO/Churches.
	* @Param: none
	* @Return: none 
	**/  
  function viewnpo($id){
    $this->checkSession('Member');  
    $this->layout = 'layout_inner';
    $npoList = $this->Npo->find('first',array('fields'=>array('Npo.id,Npo.title,Npo.image,Npo.description'),'conditions'=>array('Npo.id'=>$id)));
    //pr($npoList);die();
    $this->set('npoList',$npoList);
  }//ef
  
  /**
	* @Date: December 13, 2011
	* @Method : viewmynpo
	* @Purpose: This function is for detail of member NPO/Churches.
	* @Param: none
	* @Return: none 
	**/  
  function viewmynpo($id){
    $this->checkSession('Member');  
    $this->layout = 'layout_inner';
    $npoList = $this->Npo->find('first',array('fields'=>array('Npo.id,Npo.title,Npo.image,Npo.description'),'conditions'=>array('Npo.id'=>$id)));
    //pr($npoList);die();
    $this->set('npoList',$npoList);
  }//ef
  /**
	* @Date: December 13, 2011
	* @Method : viewpendingnpo
	* @Purpose: This function is for detail of pending member request for NPO/Churches.
	* @Param: none
	* @Return: none 
	**/  
  function viewpendingnpo($id){
    $this->checkSession('Member');  
    $this->layout = 'layout_inner';
    $npoList = $this->Npo->find('first',array('fields'=>array('Npo.id,Npo.title,Npo.image,Npo.description'),'conditions'=>array('Npo.id'=>$id)));
    //pr($npoList);die();
    $this->set('npoList',$npoList);
  }//ef
  
  /**
	* @Date: December 20, 2011
	* @Method : managesite
	* @Purpose: This function is for adding/editing NPO/Churches site content.
	* @Param: none
	* @Return: none 
	**/ 
	function managesite(){
    $this->checkSession('Npo');  
    $this->layout = 'layout_inner';
    App::import('Model','NpoContent');
    $this->NpoContent = new NpoContent();
    $npoId = $this->Session->read('SESSION_USER.Npo.id');
    if(!empty($this->request->data)){
      $data = array();
      if($this->request->data['Npo']['id'] > 0){
        $data['id'] = $this->request->data['Npo']['id'];
      }
      if($this->request->data['Npo']['image']['error'] == 0){
        $this->Uploader->uploadDir = str_replace('{id}',$npoId,Configure::read('npoImageDirectory'));
        if($imgData = $this->Uploader->upload('image')){
          App::import('Model','NpoTemplate');
          $this->NpoTemplate = new NpoTemplate();
          $this->NpoTemplate->bindModel(
                    array(
                      'belongsTo'=>array(
                          'Template' =>array(
                              'className'=>'Template',
                          )
                      )
                    )
          );
          $template = $this->NpoTemplate->find('first',array('fields'=>array('Template.name'),'conditions'=>array('NpoTemplate.npo_id'=>$npoId)));
          if($template['Template']['name'] == 'template1'){
            $thumb = $this->Uploader->resize(array('width' => '219' ,'height'=> '218'));
            $arrThumb = explode('/',$thumb);
            
            $data['image'] = $arrThumb[5];
          }else{
            $data['image'] = $imgData['name'];
          }
        }else{
          $this->Session->setFlash('<div class="fail">Error saving image</div>');
        }
      }
      $data['npo_id']     = $npoId;
      $data['window_title'] = $this->request->data['Npo']['winTitle'];
      $data['page_title'] = $this->request->data['Npo']['pageTitle'];
      $data['first_title'] = $this->request->data['Npo']['firstTitle'];
      $data['first_desc'] = $this->request->data['Npo']['firstDesc'];
      $data['second_title'] = $this->request->data['Npo']['secondTitle'];
      $data['second_desc'] = $this->request->data['Npo']['secondDesc'];
      $data['third_title'] = $this->request->data['Npo']['thirdTitle'];
      $data['third_desc'] = $this->request->data['Npo']['thirdDesc'];
      $data['fourth_title'] = $this->request->data['Npo']['fourthTitle'];
      $data['fourth_desc'] = $this->request->data['Npo']['fourthDesc'];
      $data['fifth_title'] = $this->request->data['Npo']['fifthTitle'];
      $data['fifth_desc'] = $this->request->data['Npo']['fifthDesc'];
      if($this->NpoContent->save($data)){
        $this->Session->setFlash('<div class="success">Site data saved successfully.</div>');
      }else{
        $this->Session->setFlash('<div class="fail">Error saving Site data.</div>');
      }
    }else{
      $arrContent = $this->NpoContent->find('first',array('fields'=>array('NpoContent.id,NpoContent.window_title,NpoContent.page_title,NpoContent.first_title,NpoContent.first_desc,NpoContent.second_title,NpoContent.second_desc,NpoContent.third_title,NpoContent.third_desc,NpoContent.fourth_title,NpoContent.fourth_desc,NpoContent.fifth_title,NpoContent.fifth_desc'),'conditions'=>array('NpoContent.npo_id'=>$npoId)));
      if(isset($arrContent) && !empty($arrContent)){
        $this->request->data['Npo']['id'] = $arrContent['NpoContent']['id'];
        $this->request->data['Npo']['winTitle'] =  $arrContent['NpoContent']['window_title'];
        $this->request->data['Npo']['pageTitle'] =  $arrContent['NpoContent']['page_title'];
        $this->request->data['Npo']['firstTitle'] =  $arrContent['NpoContent']['first_title'];
        $this->request->data['Npo']['firstDesc'] =  $arrContent['NpoContent']['first_desc'];
        $this->request->data['Npo']['secondTitle'] =  $arrContent['NpoContent']['second_title'];
        $this->request->data['Npo']['secondDesc'] =  $arrContent['NpoContent']['second_desc'];
        $this->request->data['Npo']['thirdTitle'] =  $arrContent['NpoContent']['third_title'];
        $this->request->data['Npo']['thirdDesc'] =  $arrContent['NpoContent']['third_desc'];
        $this->request->data['Npo']['fourthTitle'] =  $arrContent['NpoContent']['fourth_title'];
        $this->request->data['Npo']['fourthDesc'] =  $arrContent['NpoContent']['fourth_desc'];
        $this->request->data['Npo']['fifthTitle'] =  $arrContent['NpoContent']['fifth_title'];
        $this->request->data['Npo']['fifthDesc'] =  $arrContent['NpoContent']['fifth_desc'];
      }else{
        $this->request->data['Npo']['id'] = 0;
        $this->request->data['Npo']['winTitle'] =  'Lorem Ipsum';
        $this->request->data['Npo']['pageTitle'] =  'Lorem <span>Ipsum</span>';
        $this->request->data['Npo']['firstTitle'] =  'Lorem Ipsum comes from sections';
        $this->request->data['Npo']['firstDesc'] =  "<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>";
        $this->request->data['Npo']['secondTitle'] =  'Lorem Ipsum comes from sections';
        $this->request->data['Npo']['secondDesc'] =  "<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
        <p>dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>";
        $this->request->data['Npo']['thirdTitle'] =  'Lorem Ipsum comes from sections';
        $this->request->data['Npo']['thirdDesc'] =  "<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
        <p>dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>";
        $this->request->data['Npo']['fourthTitle'] =  'Lorem Ipsum comes from sections';
        $this->request->data['Npo']['fourthDesc'] =  "<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
        <p>dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>";
        $this->request->data['Npo']['fifthTitle'] =  'Lorem Ipsum comes from sections';
        $this->request->data['Npo']['fifthDesc'] =  "<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
        <p>dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>";
      }
    }
  }//ef   
}//ec
?>