<?php
class Admin extends AppModel{
  var $name = 'Admin';
  
  function __construct(){
    		$this->validate = array(
			'adminUserName' =>array(
				'empty'=>array(
					'rule' => array('notEmpty'),
					'message' => __('PLEASE_ENTER_USERNAME')
				)
			),
			'adminPassword' =>array(
				'empty' => array(
					'rule'    =>array('notEmpty'),
					'message' =>__('PLEASE_ENTER_PASSWORD')
				)
		)
		);
		parent::__construct();
		
	}
}//ec 
?>