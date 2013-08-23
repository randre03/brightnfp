<?php
class SitesController extends AppController{
  var $name = 'Sites';
  var $uses = array();
  
    /**
	* @Date: November 23, 2011
	* @Method : view
	* @Purpose: This function is to show site of user.
	* @Param: $user
	* @Return: none 
	**/
  function view($user){
    $userSite = $this->has_site($user);
    if(isset($userSite) && is_array($userSite)){
      $this->layout = $userSite['TemplateTheme']['layout_name'];
      $viewHtml = $userSite['TemplateTheme']['html'];
      $this->set('theme',$userSite['TemplateTheme']['name']);
      $this->set('title',$userSite['NpoContent']['window_title']);
      $this->set('pageTitle',$userSite['NpoContent']['page_title']);
      $imgUrl = str_replace('{id}',$userSite['NpoTemplate']['npo_id'],Configure::read('CHURCH_IMAGE_URL')).$userSite['NpoContent']['image'];
      $viewHtml = str_replace(array('{title1}','{desc1}','{title2}','{desc2}','{title3}','{desc3}','{title4}','{desc4}','{title5}','{desc5}','{source}'),array($userSite['NpoContent']['first_title'],$userSite['NpoContent']['first_desc'],$userSite['NpoContent']['second_title'],$userSite['NpoContent']['second_desc'],$userSite['NpoContent']['third_title'],$userSite['NpoContent']['third_desc'],$userSite['NpoContent']['fourth_title'],$userSite['NpoContent']['fourth_desc'],$userSite['NpoContent']['fifth_title'],$userSite['NpoContent']['fifth_desc'],$imgUrl),$viewHtml);
      $this->set('menu',$this->generateMenu($user));
      $this->set('imgUrl',$imgUrl);
      $this->set('title1',$userSite['NpoContent']['first_title']);
      $this->set('desc1',$userSite['NpoContent']['first_desc']);
      $this->set('viewHtml',$viewHtml);
      
    }else{
      $this->redirect(array('controller'=>'noController','action'=>'index'));
    }
  }//ef
}//ec
?>