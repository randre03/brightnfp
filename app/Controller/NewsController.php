<?php
class NewsController extends AppController{
  var $name = 'News';
  var $uses = array('Attribute'); 
  var $components  = array('Uploader.Uploader');
  var $helpers = array('PaypalIpn.Paypal');

    /**
	* @Date: November 23, 2011
	* @Method : index
	* @Purpose: This function is to manage news listing.
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
    $conditions = array('Attribute.status !='=>'Deleted','Attribute.type'=>'News','Attribute.npo_id' =>$npoId);
    if(isset($this->request->data['Attribute']['searchElement']) && $this->request->data['Attribute']['searchElement'] !==''){
      $element = trim($this->request->data['Attribute']['searchElement']);
          if($this->request->data['Attribute']['searchType'] === 'shortdescription'){
            $conditions['OR']= array(
                                  'Attribute.short_description LIKE' =>'%'.$element.'%'
                              );
          }elseif($this->request->data['Attribute']['searchType'] === 'description'){
            $conditions['OR']= array(
                                  'Attribute.description LIKE'  =>'%'.$element.'%'
                              );
          }else{          
            $conditions['OR']= array(
                                  'Attribute.created LIKE'  =>'%'.date(Configure::read('MYSQL_DATE_FORMAT'),strtotime($element)).'%'
                              );
          }
    }
    $this->paginate = array(
                              'conditions' => $conditions,
                              'fields'=>array('Attribute.id','Attribute.short_description','Attribute.created'),
                              'order' => array('Attribute.modified DESC'),
                              'limit' =>$limit
                              );
    $newsList = $this->paginate('Attribute');
    $this->set('newsList',$newsList);
   // pr($this->RequestHandler);die();
    if($this->RequestHandler->isAjax()){
	      $this->layout = 'ajax';
				$this->viewPath = 'elements'.DS.'news';
				$this->render('listing');
		}
  }//ef
  
    /**
	* @Date: November 23, 2011
	* @Method : index
	* @Purpose: This function is to manage news listing.
	* @Param: none
	* @Return: none 
	**/
  function deletenews($id){
    $data = array();
    $this->Attribute->delete($id);    
    $this->redirect(array('controller' => 'news', 'action' => 'index'));
  }//ef
  
  
    /**
	* @Date: November 24, 2011
	* @Method : addnews
	* @Purpose: This function is to add news.
	* @Param: none
	* @Return: none 
	**/
  function addnews(){
    $this->checkSession('Npo');  
    $this->layout = 'layout_inner';
      if(!empty($this->request->data)){
        $this->Attribute->set($this->request->data);
        if($this->Attribute->validates()){
          $npoId = $this->Session->read('SESSION_USER.Npo.id'); 
          $data  = array();  
           // echo str_replace('{id}',$npoId,Configure::read('npoNewsDirectory'));   die();              
          
            if($this->request->data['Attribute']['image']['error'] === 0){  
                $this->Uploader->uploadDir = str_replace('{id}',$npoId,Configure::read('npoNewsDirectory'));
          
                if($imgData = $this->Uploader->upload('image')){
                    $data['image_name'] = $imgData['name'];
                    $thumb = $this->Uploader->resize(array('width' => thumbWidth ,'height'=> thumbHeight));
                    $arrThumb = explode('/',$thumb);
                    $data['thumb_name'] = $arrThumb[5];                          
                }else{
                  $this->Session->setFlash('<div class="fail">Error saving image.Please try again</div>');
                }  
              }
              $data['short_description'] = $this->request->data['Attribute']['shortDesc']; 
              $data['description'] =  $this->request->data['Attribute']['fullDesc'];
              //$data['is_donate']   =  $this->request->data['Attribute']['donate'];
              $data['title']       =  $this->request->data['Attribute']['title'];
              $data['npo_id']      =  $npoId;
              $data['type']        =  'News';
              $data['status']      = 'Active';
              if($this->Attribute->save($data)){
                $this->Session->setFlash('<div class="success">News saved successfully.</div>');
              }else{
                $this->Session->setFlash('<div class="fail">Error saving news.</div>');
              }   
                $this->redirect(array('controller'=>'news','action'=>'index'));         
        }
      } 
  }
  
    /**
	* @Date: November 24, 2011
	* @Method : editnews
	* @Purpose: This function is to edit news.
	* @Param: id
	* @Return: none 
	**/
	function editnews($id= ''){
    $this->checkSession('Npo');  
    $this->layout = 'layout_inner';
    $npoId = $this->Session->read('SESSION_USER.Npo.id'); 
    $this->set('npoId',$npoId);
    if(!empty($this->request->data)){
        $this->Attribute->set($this->request->data);
          if($this->Attribute->validates()){
            $data  = array();
            if($this->request->data['Attribute']['image']['error'] === 0){  
           // echo str_replace('{id}',$npoId,Configure::read('npoNewsDirectory'));   die();                   
                $this->Uploader->uploadDir = str_replace('{id}',$npoId,Configure::read('npoNewsDirectory'));
                if($imgData = $this->Uploader->upload('image')){
                    $data['image_name'] = $imgData['name'];
                    $thumb = $this->Uploader->resize(array('width' => thumbWidth ,'height'=> thumbHeight));
                    $arrThumb = explode('/',$thumb);
                    $data['thumb_name'] = $arrThumb[5];
                }else{
                  $this->Session->setFlash('<div class="fail">Error saving image.Please try again</div>');
                }              
            }
            $data['short_description']   = $this->request->data['Attribute']['shortDesc'];
            $data['description']         = $this->request->data['Attribute']['fullDesc'];
            $data['title']               = $this->request->data['Attribute']['title'];
            //$data['is_donate']           = $this->request->data['Attribute']['donate'];
            $data['id']                  = $this->request->data['Attribute']['id'];
            $this->Attribute->save($data);
            $this->Session->setFlash('<div class="success">News saved successfully.</div>');
            $this->redirect(array('controller'=>'news','action'=>'index')); 
          }
    }else{
      $newsData = $this->Attribute->find('first',array('fields'=>array('Attribute.thumb_name','Attribute.title','Attribute.short_description','Attribute.description','Attribute.is_donate'),'conditions'=>array('id'=>$id)));
      //pr($newsData);die();
      $this->request->data['Attribute']['shortDesc']     = $newsData['Attribute']['short_description']; 
      $this->request->data['Attribute']['fullDesc']      = $newsData['Attribute']['description'];  
      $this->request->data['Attribute']['title']         = $newsData['Attribute']['title'];  
      $this->request->data['Attribute']['donate']        = $newsData['Attribute']['is_donate'];
      $this->request->data['Attribute']['thumb_name']    = $newsData['Attribute']['thumb_name'];
      $this->request->data['Attribute']['id']            = $id;
    } 
  }//ef
  /**
	* @Date: December 13, 2011
	* @Method : nponews
	* @Purpose: This function is to get npo news.
	* @Param: none
	* @Return: none 
	**/
	function nponews($npoId){
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
    
	 	$this->paginate = array('conditions'=>array('Attribute.npo_id'=>$npoId,'Attribute.type'=>'News','Attribute.status'=>'Active'),
                            'order'     => array('Attribute.modified DESC'),
                            'fields'     => 'Attribute.id,Attribute.title,Attribute.time,Attribute.date,Attribute.description,Attribute.image_name,Attribute.thumb_name',
                            'limit'     => $limit
                              );	 
    $eventList =  $this->paginate('Attribute');
    $this->set('eventList',$eventList);
   //pr($eventList);die();
   if($this->RequestHandler->isAjax()){
	      $this->layout = 'ajax';
				$this->viewPath = 'elements'.DS.'news';
				$this->render('frontend_news_list');
		}
    
  }//ef  
    /**
	* @Date: December 13, 2011
	* @Method : viewnews
	* @Purpose: This function is to view news.
	* @Param: id,npoId
	* @Return: none 
	**/
	function viewnews($id,$npoId){
    $this->checkSession('Member');  
    $this->layout = 'layout_inner'; 
	  $npoList = $this->Attribute->find('first',array('fields'=>array('Attribute.id,Attribute.image_name,Attribute.title,Attribute.short_description,Attribute.description,Attribute.created'),'conditions'=>array('Attribute.id'=>$id)));
    //pr($npoList);die();
    $this->set('npoId',$npoId);
    $this->set('npoList',$npoList);
  }//ef
  
  /**
	* @Date: December 28, 2011
	* @Method : news
	* @Purpose: This function is to show event of the user.
	* @Param: $user
	* @Return: none 
	**/
	function news($user){
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
                              'conditions' => array('Attribute.type'=>'News','Attribute.status'=>'Active','Npo.address'=>$user),
                              'fields'=>array('NpoContent.first_title,NpoContent.first_desc,NpoContent.image,NpoContent.window_title,NpoContent.page_title,TemplateTheme.news_html,TemplateTheme.name,TemplateTheme.layout_name,Attribute.id,Attribute.thumb_name,Attribute.title,Attribute.description,Npo.id'),
                              'order' => array('Attribute.modified DESC'),
                              'limit' =>$limit
                              );                              
    
    $news = $this->paginate('Attribute');
   // pr($news);die();
      if(isset($news) && !empty($news)){
          $this->layout = $news[0]['TemplateTheme']['layout_name'];
          $this->set('npoId',$news[0]['Npo']['id']);
          $this->set('address',$user);
          $this->set('theme',$news[0]['TemplateTheme']['name']);
          $this->set('title',$news[0]['NpoContent']['window_title']);
          $this->set('pageTitle',$news[0]['NpoContent']['page_title']);
          $this->set('news',$news);
          $this->set('menu',$this->generateMenu($user));         
          $this->set('title1',$news[0]['NpoContent']['first_title']);
          $this->set('desc1',$news[0]['NpoContent']['first_desc']);
          $imgUrl = str_replace('{id}',$news[0]['Npo']['id'],Configure::read('CHURCH_IMAGE_URL')).$news[0]['NpoContent']['image']; 
          $this->set('imgUrl',$imgUrl);
        if($this->RequestHandler->isAjax()){
    	      $this->layout = 'ajax';
    				$this->viewPath = 'elements'.DS.'news';
    				$this->render('site_news_listing');
    		}
      }else{
          $this->Session->setFlash('<div class="fail">No news present for this Organization</div>');
          $this->redirect('/site/'.$user);
      }
    
  }//ef
  
  
    /**
	* @Date: December 27, 2011
	* @Method : newsdetail
	* @Purpose: This function is to show event detail.
	* @Param: $id
	* @Return: none 
	**/
	function newsdetail($npoId,$id){	
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
	  $layoutContent = $this->NpoContent->find('first',array('fields'=>array('NpoContent.first_title,NpoContent.first_desc,NpoContent.first_title,NpoContent.image,Npo.address,TemplateTheme.name,TemplateTheme.layout_name,NpoContent.window_title,NpoContent.page_title'),'conditions'=>array('NpoContent.npo_id'=>$npoId)));
	// pr($layoutContent);die();
    $this->layout = $layoutContent['TemplateTheme']['layout_name'];
	  $npoList = $this->Attribute->find('first',array('fields'=>array('Attribute.id,Attribute.image_name,Attribute.title,Attribute.short_description,Attribute.description,Attribute.created'),'conditions'=>array('Attribute.id'=>$id)));
    //pr($npoList);die();
    $this->set('theme',$layoutContent['TemplateTheme']['name']);
    $this->set('title',$layoutContent['NpoContent']['window_title']);
    $this->set('pageTitle',$layoutContent['NpoContent']['page_title']);
    $this->set('npoId',$npoId);
    $this->set('npoList',$npoList);
    $this->set('menu',$this->generateMenu($layoutContent['Npo']['address']));          
    $this->set('title1',$layoutContent['NpoContent']['first_title']);
    $this->set('desc1',$layoutContent['NpoContent']['first_desc']);
    $imgUrl = str_replace('{id}',$npoId,Configure::read('CHURCH_IMAGE_URL')).$layoutContent['NpoContent']['image'];
    $this->set('imgUrl',$imgUrl);
    
  }//ef
}//ec 
?>