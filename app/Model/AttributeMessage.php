<?php
class AttributeMessage extends AppModel{
  var $name = 'AttributeMessage';
  
  function __construct(){
    		$this->validate = array(
			 'msgEvent' =>array(
  				'empty'=>array(
  					'rule' => array('notEmpty'),
  					'message' => 'Please enter message'
  				)
			)
		);
		parent::__construct();
		
	}
}//ec
?>