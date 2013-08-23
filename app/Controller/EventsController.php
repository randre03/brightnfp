<?php
class EventsController extends AppController{
  var $name = 'Events';
  var $uses = array('Attribute'); 
  var $components  = array('Uploader.Uploader');
  var $helpers = array('PaypalIpn.Paypal');

    /**
	* @Date: November 23, 2011
	* @Method : index
	* @Purpose: This function is to manage Events listing.
	* @Param: none
	* @Return: none 
	**/
	function index(){
    $this->checkSession('Npo');  
    $this->layout = 'layout_inner'; 
		$this->helpers['Paginator'] = array('ajax' => 'Ajax');
    $npoId = $this->Session->read('SESSION_USER.Npo.id');
    if(isset($this->request->data['pagecount']) && !empty($this->request->data['pagecount'])){  	   
  	  $limit =  $this->request->data['pagecount'];
  	}else if(isset($this->request->params['named']['recCount']) && !empty($this->request->params['named']['recCount'])){
  	  $limit = $this->request->params['named']['recCount'];
    }else{
  	  $limit = 10;
    }
    $this->set('recCount',$limit);
    $condtions =  array('Attribute.status !='=>'Deleted','Attribute.type'=>'Event','Attribute.npo_id' =>$npoId);
    if(isset($this->request->data['Attribute']['searchElement']) && $this->request->data['Attribute']['searchElement'] !==''){
      $element = trim($this->request->data['Attribute']['searchElement']);
          if($this->request->data['Attribute']['searchType'] === 'title'){
            $condtions['OR']= array(
                                  'Attribute.title LIKE' =>'%'.$element.'%'
                              );
          }elseif($this->request->data['Attribute']['searchType'] === 'date'){
            $condtions['OR']= array(
                                  'Attribute.date LIKE'  =>'%'.date(Configure::read('MYSQL_DATE_FORMAT'),strtotime($element)).'%'
                              );
          }elseif($this->request->data['Attribute']['searchType'] === 'time'){          
            $condtions['OR']= array(
                                  'Attribute.time LIKE'  =>'%'.date(Configure::read('MYSQL_TIME_FORMAT'),strtotime($element)).'%'
                              );
          }else{         
            $condtions['OR']= array(
                                  'Attribute.description LIKE'  =>'%'.$element.'%'
                              );
          }
    }
    $this->paginate = array(
                              'conditions' => $condtions,
                              'fields'=>array('Attribute.id','Attribute.title','Attribute.date','Attribute.time'),
                              'order' => array('Attribute.modified DESC'),
                              'limit' =>$limit
                              );
    $eventsList = $this->paginate('Attribute');
    $this->set('eventsList',$eventsList);
    if($this->RequestHandler->isAjax()){
	      $this->layout = 'ajax';
				$this->viewPath = 'elements'.DS.'events';
				$this->render('listing');
		}
  }//ef
  
    /**
	* @Date: November 23, 2011
	* @Method : index
	* @Purpose: This function is to manage Events listing.
	* @Param: none
	* @Return: none 
	**/
  function deleteevents($id){
    $data = array();
    $data['id']     = $id;
    $data['status'] = 'Deleted';
    $this->Attribute->save($data);    
    $this->redirect(array('controller' => 'events', 'action' => 'index'));
  }//ef
  
  
  
    /**
	* @Date: November 24, 2011
	* @Method : addevents
	* @Purpose: This function is to add events.
	* @Param: none
	* @Return: none 
	**/
  function addevents(){
    $this->checkSession('Npo');  
    $this->layout = 'layout_inner';
      if(!empty($this->request->data)){
        $this->Attribute->set($this->request->data);
        if($this->Attribute->validates()){
          $npoId = $this->Session->read('SESSION_USER.Npo.id'); 
          $data  = array(); 
          if($this->request->data['Attribute']['image']['error'] === 0){      
              $this->Uploader->uploadDir = str_replace('{id}',$npoId,Configure::read('npoEventDirectory'));
            if($imgData = $this->Uploader->upload('image')){
                $data['image_name'] = $imgData['name'];
                $thumb = $this->Uploader->resize(array('width' => thumbWidth ,'height'=> thumbHeight));
                $arrThumb = explode('/',$thumb);
                $data['thumb_name']  = $arrThumb[5];
              }else{
                $this->Session->setFlash('<div class="fail">Error saving Image.</div>');            
              } 
            }
              $data['title']       = $this->request->data['Attribute']['title']; 
              $data['date']        =  date(Configure::read('MYSQL_DATE_FORMAT'),strtotime($this->request->data['Attribute']['date']));
              $data['time']        =  date(Configure::read('MYSQL_TIME_FORMAT'),strtotime($this->request->data['Attribute']['time']));
              //$data['is_donate']   =  $this->request->data['Attribute']['donate'];
              $data['description'] =  $this->request->data['Attribute']['fullDesc'];
              $data['npo_id']      =  $npoId;
              $data['type']        =  'Event';
              $data['status']      =  'Active';
              if($this->Attribute->save($data)){
                $this->Session->setFlash('<div class="success">Event saved successfully.</div>');
              }else{
                $this->Session->setFlash('<div class="fail">Error saving event.</div>');
              }              
          
                $this->redirect(array('controller'=>'events','action'=>'index'));         
        }
      } 
  }//ef
  
  
    /**
	* @Date: November 25, 2011
	* @Method : editevent
	* @Purpose: This function is to edit event.
	* @Param: none
	* @Return: none 
	**/
  function editevents($id=''){
    
    $this->checkSession('Npo');  
    $this->layout = 'layout_inner';
    $npoId = $this->Session->read('SESSION_USER.Npo.id'); 
    $this->set('npoId',$npoId);
    if(!empty($this->request->data)){     
        $this->Attribute->set($this->request->data);
          if($this->Attribute->validates()){
            $data  = array();
            if($this->request->data['Attribute']['image']['error'] === 0){ 
                //echo str_replace('{id}',$npoId,Configure::read('npoEventDirectory'));die();                      
                $this->Uploader->uploadDir = str_replace('{id}',$npoId,Configure::read('npoEventDirectory'));
                if($imgData = $this->Uploader->upload('image')){
                    $data['image_name'] = $imgData['name'];
                    $thumb = $this->Uploader->resize(array('width' => thumbWidth ,'height'=> thumbHeight));
                    $arrThumb = explode('/',$thumb);
                    $data['thumb_name'] = $arrThumb[5];
                }else{
                  $this->Session->setFlash('<div class="fail">Error saving image.Please try again</div>');
                }              
            }
            $data['id']          = $this->request->data['Attribute']['id'];
            $data['title']       = $this->request->data['Attribute']['title']; 
            $data['date']        =  date(Configure::read('MYSQL_DATE_FORMAT'),strtotime($this->request->data['Attribute']['date']));
            $data['time']        =  date(Configure::read('MYSQL_TIME_FORMAT'),strtotime($this->request->data['Attribute']['time']));
            
            //$data['is_donate']   =  $this->request->data['Attribute']['donate'];
            $data['description'] =  $this->request->data['Attribute']['fullDesc'];
            $data['npo_id']      =  $npoId;
            $data['type']        =  'Event';
            $data['status']      =  'Active';
            $this->Attribute->save($data);
            $this->Session->setFlash('<div class="success">Event saved successfully.</div>');
            $this->redirect(array('controller'=>'events','action'=>'index')); 
          }
    }else{
      $eventsData = $this->Attribute->find('first',array('fields'=>array('Attribute.thumb_name','Attribute.title','Attribute.description','Attribute.date','Attribute.time','Attribute.is_donate'),'conditions'=>array('id'=>$id)));
      //pr($newsData);die();
      $this->request->data['Attribute']['date']          = date(Configure::read('npoDateFormat'),strtotime($eventsData['Attribute']['date'])); 
      $this->request->data['Attribute']['time']          = date(Configure::read('npoTimeFormat'),strtotime($eventsData['Attribute']['time'])); 
      $this->request->data['Attribute']['fullDesc']      = $eventsData['Attribute']['description'];  
      $this->request->data['Attribute']['title']         = $eventsData['Attribute']['title'];  
      $this->request->data['Attribute']['donate']        = $eventsData['Attribute']['is_donate'];
      $this->request->data['Attribute']['thumb_name']    = $eventsData['Attribute']['thumb_name'];
      $this->request->data['Attribute']['id']            = $id;
    } 
  }//ef
  
  
    /**
	* @Date: November 25, 2011
	* @Method : eventmessage
	* @Purpose: This function is to send messages to event.
	* @Param: none
	* @Return: none 
	**/
  
  function eventsmessage(){ 
    App::import('Model','AttributeMessage');
    $this->AttributeMessage  = new AttributeMessage(); 
    $this->checkSession('Npo');  
    $this->layout = 'layout_inner';
    if(isset($this->request->data['AttributeMessage']['eventIds'])){
       $this->AttributeMessage->set($this->request->data);
       if($this->AttributeMessage->validates()){ 
        $arrEventIds = explode('-',$this->request->data['AttributeMessage']['eventIds']);
        foreach($arrEventIds as $key=>$val){
          if($val > 0){
              $data                 = array();
              $data['id']           = ''; 
              $data['attribute_id'] = $val; 
              $data['message']      = $this->request->data['AttributeMessage']['msgEvent']; 
              $this->AttributeMessage->save($data);
          }
        }
        $this->Session->setFlash('<div class="success">Message sent successfully to event(s)</div>');
        $this->redirect(array('controller'=>'events','action'=>'index'));
        }else{
          $this->set('eventIds',$this->request->data['AttributeMessage']['eventIds']);       
        }
    }else{
          $eventIds = implode('-',$this->request->data['Attribute']['chkRec']);
          $this->set('eventIds',$eventIds);    
    }
  
  }//ef
  
  
    /**
	* @Date: December 13, 2011
	* @Method : npoevent
	* @Purpose: This function is to show events of npo.
	* @Param: $npoId
	* @Return: none 
	**/
	function npoevent($npoId){
    $this->checkSession('Member');  
    $this->layout = 'layout_inner'; 
	  $this->helpers['Paginator'] = array('ajax' => 'Ajax');
	  App::import('Model','Npo');
	  $this->Npo = new Npo();
	  
	  $arrNpo = $this->Npo->find('first',array('fields'=>array('Npo.title'),'conditions'=>array('Npo.id'=>$npoId)));
	  //pr($arrNpo);die();
	  $this->set('npoTitle',$arrNpo['Npo']['title']);
	  $this->set('npoId',$npoId);
    if(isset($this->request->data['pagecount']) && !empty($this->request->data['pagecount'])){  	   
  	  $limit =  $this->request->data['pagecount'];
  	}else if(isset($this->request->params['named']['recCount']) && !empty($this->request->params['named']['recCount'])){
  	  $limit = $this->request->params['named']['recCount'];
    }else{
  	  $limit = 10;
    }
    $this->set('recCount',$limit);
    
	 	$this->paginate = array('conditions'=>array('Attribute.npo_id'=>$npoId,'Attribute.type'=>'Event','Attribute.status'=>'Active'),
                            'order'     => array('Attribute.modified DESC'),
                            'fields'     => 'Attribute.id,Attribute.title,Attribute.description,Attribute.thumb_name,Attribute.is_donate',
                            'limit'     => $limit
                              );	 
    $eventList =  $this->paginate('Attribute');
    $this->set('eventList',$eventList);
   //pr($eventList);die();
   if($this->RequestHandler->isAjax()){
	      $this->layout = 'ajax';
				$this->viewPath = 'elements'.DS.'events';
				$this->render('frontend_event_list');
		}
    
  }//ef
  
    /**
	* @Date: December 13, 2011
	* @Method : npoevent
	* @Purpose: This function is to show events of npo.
	* @Param: $npoId
	* @Return: none 
	**/
	function viewevent($id,$npoId){	   
    $this->checkSession('Member');  
    $this->layout = 'layout_inner';
    $this->Attribute->bindModel(
       array(
         'hasMany'=>array(
             'AttributeMessage'=>array(
               'className'  => 'AttributeMessage',
               'conditions' => array('AttributeMessage.status'=>'Active'),
               'fields'     =>array('AttributeMessage.message,AttributeMessage.created')
             )          
         )
      ),false
    );
	  $npoList = $this->Attribute->find('first',array('fields'=>array('Attribute.id,Attribute.image_name,Attribute.title,Attribute.time,Attribute.date,Attribute.description'),'conditions'=>array('Attribute.id'=>$id)));
    //pr($npoList);die();
    $this->set('npoId',$npoId);
    $this->set('npoList',$npoList);
    
  }//ef
  
  
  
    /**
	* @Date: December 26, 2011
	* @Method : events
	* @Purpose: This function is to show event of the user.
	* @Param: $user
	* @Return: none 
	**/
	function events($user){
	  $this->helpers['Paginator'] = array('ajax' => 'Ajax');
    if(isset($this->request->data['pagecount']) && !empty($this->request->data['pagecount'])){  	   
  	  $limit =  $this->request->data['pagecount'];
  	}else if(isset($this->request->params['named']['recCount']) && !empty($this->request->params['named']['recCount'])){
  	  $limit = $this->request->params['named']['recCount'];
    }else{
  	  $limit = 10;
    }
    $this->set('recCount',$limit);
    $this->Attribute->bindmodel(
		              array(
		                'belongsTo'=>array(
                      'Npo' =>array(
                          'className'=>'Npo',
                          'fields'   =>'Npo.id'
                      )                      
                    ),
                    'hasOne'=>array(
                      'NpoTemplate'=>array(
                        'className'=>'NpoTemplate',
                         'foreignKey'=>false,
                        'conditions'=>array(
                          'NpoTemplate.npo_id = Attribute.npo_id'
                        )
                      ),
                      'TemplateTheme'=>array(
                        'className'=>'TemplateTheme',
                         'foreignKey'=>false,
                        'conditions'=>'TemplateTheme.id = NpoTemplate.template_theme_id'
                      ),
                      'NpoContent'=>array(
                        'className'=>'NpoContent',
                         'foreignKey'=>false,
                        'conditions'=>'Attribute.npo_id = NpoContent.npo_id'
                      )
                    )
                  ),false
                );
                
    $this->paginate = array(
                              'conditions' => array('Attribute.type'=>'Event','Attribute.status'=>'Active','Npo.address'=>$user),
                              'fields'=>array('NpoContent.image,NpoContent.first_title,NpoContent.first_desc,NpoContent.window_title,NpoContent.page_title,TemplateTheme.event_html,TemplateTheme.name,TemplateTheme.layout_name,Attribute.id,Attribute.thumb_name,Attribute.title,Attribute.description,Npo.id'),
                              'order' => array('Attribute.modified DESC'),
                              'limit' =>$limit
                              );                              
    
    $events = $this->paginate('Attribute');
  //pr($events);die();
      if(isset($events) && !empty($events)){
          $this->layout = $events[0]['TemplateTheme']['layout_name'];
          $this->set('npoId',$events[0]['Npo']['id']);
          $this->set('address',$user);
          $this->set('title1',$events[0]['NpoContent']['first_title']);
          $this->set('desc1',$events[0]['NpoContent']['first_desc']);
          $this->set('theme',$events[0]['TemplateTheme']['name']);
          $this->set('title',$events[0]['NpoContent']['window_title']);
          $this->set('pageTitle',$events[0]['NpoContent']['page_title']);
          $this->set('events',$events);
          $this->set('menu',$this->generateMenu($user));
          $imgUrl = str_replace('{id}',$events[0]['Npo']['id'],Configure::read('CHURCH_IMAGE_URL')).$events[0]['NpoContent']['image'];
          $this->set('imgUrl',$imgUrl);
        if($this->RequestHandler->isAjax()){
    	      $this->layout = 'ajax';
    				$this->viewPath = 'elements'.DS.'events';
    				$this->render('site_event_listing');
    		}
      }else{
          $this->Session->setFlash('<div class="fail">No event present for this Organization</div>');
          $this->redirect('/site/'.$user);
      }
    
  }//ef
  
  
    /**
	* @Date: December 27, 2011
	* @Method : eventdetail
	* @Purpose: This function is to show event detail.
	* @Param: $id
	* @Return: none 
	**/
	function eventdetail($npoId,$id){	
	  App::import('Model','NpoContent');
	  $this->NpoContent = new NpoContent();
	  $this->NpoContent->bindmodel(
        array(
          'hasOne'=>array(
            'NpoTemplate'=>array(
                'className'=>'NpoTemplate',
                'foreignKey'=>false,
                'conditions'=>array(
                  'NpoContent.npo_id = NpoTemplate.npo_id'
                )
            ),
            'Npo'=>array(
                'className'=>'Npo',
                'foreignKey'=>false,
                'conditions'=>array(
                  'NpoContent.npo_id = Npo.id'
                )                
            ),
            'TemplateTheme'=>array(
                'className'=>'TemplateTheme',
                'foreignKey'=>false,
                'conditions'=>array(
                  'NpoTemplate.template_theme_id = TemplateTheme.id'
                )                
            )
          )
        ),false
    );
	  $layoutContent = $this->NpoContent->find('first',array('fields'=>array('NpoContent.image,NpoContent.first_title,NpoContent.first_desc,Npo.address,TemplateTheme.name,TemplateTheme.layout_name,NpoContent.window_title,NpoContent.page_title'),'conditions'=>array('NpoContent.npo_id'=>$npoId)));
	// pr($layoutContent);die();
    $this->layout = $layoutContent['TemplateTheme']['layout_name'];
    $this->Attribute->bindModel(
       array(
         'hasMany'=>array(
             'AttributeMessage'=>array(
               'className'  => 'AttributeMessage',
               'conditions' => array('AttributeMessage.status'=>'Active'),
               'fields'     =>array('AttributeMessage.message,AttributeMessage.created')
             )          
         )
      ),false
    );
	  $npoList = $this->Attribute->find('first',array('fields'=>array('Attribute.id,Attribute.image_name,Attribute.title,Attribute.time,Attribute.date,Attribute.description'),'conditions'=>array('Attribute.id'=>$id)));
    //pr($npoList);die();
    $this->set('title1',$layoutContent['NpoContent']['first_title']);
    $this->set('desc1',$layoutContent['NpoContent']['first_desc']);
    $imgUrl = str_replace('{id}',$npoId,Configure::read('CHURCH_IMAGE_URL')).$layoutContent['NpoContent']['image'];
    $this->set('imgUrl',$imgUrl);
    $this->set('theme',$layoutContent['TemplateTheme']['name']);
    $this->set('title',$layoutContent['NpoContent']['window_title']);
    $this->set('pageTitle',$layoutContent['NpoContent']['page_title']);
    $this->set('npoId',$npoId);
    $this->set('npoList',$npoList);
    $this->set('menu',$this->generateMenu($layoutContent['Npo']['address']));
    
  }//ef
}//ec 
?>