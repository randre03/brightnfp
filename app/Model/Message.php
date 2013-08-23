<?php
/*
*
Message model class
*
*/
class Message extends AppModel{
  var $name = 'Message';
  
  function __construct(){
    		$this->validate = array(
			 'to' =>array(
				'empty'=>array(
					'rule' => array('notEmpty'),
					'message' => __('PLEASE_SELECT_RECIEVER_OF_MESSAGE')
				)
			),
			'subject' =>array(
				'empty' => array(
					'rule'    =>array('notEmpty'),
					'message' =>__('PLEASE_ENTER_SUBJECT'),
				)
				),
			'message' =>array(
				'empty' => array(
					'rule'    =>array('notEmpty'),
					'message' =>__('PLEASE_ENTER_MESSAGE'),
				)
		  )
		);
		parent::__construct();
		
	}
}//ec

?>