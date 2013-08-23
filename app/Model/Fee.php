<?php
class Fee extends AppModel{
  var $name = 'Fee';
  
  function __construct(){
    		$this->validate = array(
			 'amount' =>array(
  				'empty'=>array(
  					'rule' => array('notEmpty'),
  					'message' => __('PLEASE_ENTER_USERNAME')
  				),
  				'format'=>array(
            'rule'=>array('money'),
            'message' => __('VALID_MONETARY_AMOUNT')
          )
			)
		);
		parent::__construct();
		
	}
}//ec
?>