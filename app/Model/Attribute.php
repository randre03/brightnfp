<?php
class Attribute extends AppModel{
  var $name = 'Attribute'; 
  
  function __construct(){
    		$this->validate = array(
			 'shortDesc' =>array(
  				'empty'=>array(
  					'rule' => array('notEmpty'),
  					'message' => 'Please enter short description.'
  				)
			),
			 'title' =>array(
  				'empty'=>array(
  					'rule' => array('notEmpty'),
  					'message' => 'Please enter title.'
  				)
			),
			 'fullDesc' =>array(
  				'empty'=>array(
  					'rule' => array('notEmpty'),
  					'message' => 'Please enter full description.'
  				)
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
		if(isset($this->data['Attribute']['image']) && $this->data['Attribute']['image']['name'] !=''){
			if(is_array($this->data['Attribute']['image'])){
			    $file_details = pathinfo($this->data['Attribute']['image']['name']);
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