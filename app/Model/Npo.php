<?php
class Npo extends AppModel{
  var $name = 'Npo';
  
  function __construct(){
    		$this->validate = array(
    			 'email' =>array(
      				'empty'=>array(
      					'rule' => array('email'),
      					'message' => 'Please enter a valid email address'
      				 )
    			     ),
      				'password'=>array(
                'rule'=>array('notEmpty'),
                'message' => 'Please enter password'
              ),
      				'confirmPassword'=>array(
                'rule'=>array('notEmpty'),
                'message' => 'Please enter confirm password'
              ),
      				'siteAddress'=>array(
                'rule'=>array('notEmpty'),
                'message' => 'Please enter site address'
              ),
      				'title'=>array(
                'rule'=>array('notEmpty'),
                'message' => 'Please enter title'
              ),
      				'description'=>array(
                'rule'=>array('notEmpty'),
                'message' => 'Please enter description'
              ),
        			 'image' =>array(
          				'empty'=>array(
          					'rule' => 'valid_image',
          					'message' => 'Please enter a jpeg,png or gif file.'
          				)
        			)
		);
		parent::__construct();
		
	}
	/**
	* @Date: December 05, 2011
	* @Method : valid_image
	* @Purpose: This function is to check if image extension
	* @author     Himanshu Sharma
	* @Param: none
	* @Return: none 
	**/
	function valid_image(){
		if(isset($this->data['Npo']['image']) && $this->data['Npo']['image']['name'] !=''){
			if(is_array($this->data['Npo']['image'])){
			    $file_details = pathinfo($this->data['Npo']['image']['name']);
          $extension    = strtolower($file_details['extension']);
				if($extension !='jpeg' && $extension !='png' &&  $extension !='gif' &&  $extension !='jpg'){
					return false;
				}else{
					return true;
				}
			}else{
				return true;
			}
		}else{
			return true;
		}
	}//ef
}//ec
?>