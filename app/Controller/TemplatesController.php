<?php
/*
Templates controller Class
*/
class TemplatesController extends AppController{
  var $name = 'Templates';
  var $uses = array('Template');  
   
   
  /**
	* @Date: October 24, 2011
	* @Method : admin_manage_templates
	* @Purpose: This function is to show listing of templates.
	* @Param: none
	* @Return: none 
	**/
	function admin_manage_templates(){
		$this->helpers['Paginator'] = array('ajax' => 'Ajax');
  	if(isset($this->request->data['pagecount']) && !empty($this->request->data['pagecount'])){  	   
  	  $limit =  $this->request->data['pagecount'];
  	}else if(isset($this->request->params['named']['recCount']) && !empty($this->request->params['named']['recCount'])){
  	  $limit = $this->request->params['named']['recCount'];
    }else{
  	  $limit = 10;
    }
    $this->set('recCount',$limit);
   $this->Template->virtualFields =array(
      'themeCount'=>'count(TemplateTheme.id)'
   );
   $this->paginate = array(
                      'order' => array('Template.modified DESC'),
                      'joins'  => array(
                                        array(
                                          'table'     =>'template_themes',
                                          'alias'     => 'TemplateTheme',
                                          'type'      =>'LEFT',
                                          'conditions'=>array(
                                            'Template.id = TemplateTheme.template_id'
                                          )
                                        )
                                ),
                      'group' => array(
                              'Template.id'
                      ),
                      'limit' =>$limit
                    );	 
	 $template = $this->paginate('Template');
	 $this->set('template',$template);
	 if($this->RequestHandler->isAjax()){
	      $this->layout   = 'ajax';
				$this->viewPath = 'elements'.DS.'template';
				$this->render('list_template');
		}
    
  }//ef
    /**
	* @Date: October 24, 2011
	* @Method : admin_toggle_status
	* @Purpose: This function is to manage status of templates.
	* @Param: $status,$id
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
    $this->Template->save($update);
    $this->redirect(array('controller' => 'templates', 'action' => 'manage_templates','admin'=>true));
  }
    /**
	* @Date: October 24, 2011
	* @Method : admin_themes
	* @Purpose: This function is to list of themes of a template.
	* @Param: $status,$id
	* @Return: none 
	**/
  function admin_themes($template_id){
	
	if(isset($this->request->data['pagecount']) && !empty($this->request->data['pagecount'])){  	   
  	  $limit =  $this->request->data['pagecount'];
  	}else if(isset($this->request->params['named']['recCount']) && !empty($this->request->params['named']['recCount'])){
  	  $limit = $this->request->params['named']['recCount'];
    }else{
  	  $limit = 10;
    }
    $this->set('recCount',$limit);
	
    $this->set('template_id',$template_id);
    App::import('Model','TemplateTheme');
    $this->TemplateTheme = new TemplateTheme();
		$this->helpers['Paginator'] = array('ajax' => 'Ajax');
		$this->TemplateTheme->bindModel(
                            array(
                              'hasMany'=>array(
                                'NpoTemplate'=>array(
                                  'className' =>'NpoTemplate',
                                  'fields'     =>'count(NpoTemplate.id) as members'
                                )
                              )
                            ),false
                          );
		$this->TemplateTheme->bindModel(
                            array(
                              'belongsTo'=>array(
                                'Template'=>array(
                                  'className' =>'Template',
                                  'fields'     =>'Template.name'
                                )
                              )
                            ),false
                          );
    $this->paginate = array(
                          'order' => array('TemplateTheme.modified DESC'),
                          'conditions'=>array('TemplateTheme.template_id' => $template_id),
                          'limit' =>$limit
                      );	 
    $templateTheme = $this->paginate('TemplateTheme');
    //pr($templateTheme);die();
    $this->set('templateTheme',$templateTheme);
    if($this->RequestHandler->isAjax()){
	      $this->layout   = 'ajax';
				$this->viewPath = 'elements'.DS.'themes';
				$this->render('list_themes');
		}
   
  }//ef
   /**
	* @Date: October 24, 2011
	* @Method : admin_toggle_theme_status
	* @Purpose: This function is to manage status of templates.
	* @Param: $status,$id
	* @Return: none 
	**/
  function admin_toggle_theme_status($status,$id,$template_id){
    App::import('Model','TemplateTheme');
    $this->TemplateTheme = new TemplateTheme();
    $this->autoRender = false;
    $update = array();
    $update['id'] = $id;
    if($status ==='disable'){
      $update['status'] = 'Inactive';
    }else{
      $update['status'] = 'Active';
    }
    $this->TemplateTheme->save($update);
    $this->redirect(array('controller' => 'templates', 'action' => 'themes','admin'=>true,$template_id));
  }
}//ec
?>