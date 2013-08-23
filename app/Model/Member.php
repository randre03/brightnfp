<?php
/*
Member model class
*/ 
class Member extends AppModel{
  var $name = 'Member'; 
 
  
  function __construct(){
    		$this->validate = array(
    			 'email' =>array(
      				'empty'=>array(
      					'rule' => array('email'),
      					'message' => 'Please enter a valid email address'
      				 )
    			     ),
      				'usrName'=>array(
                'rule'=>array('notEmpty'),
                'message' => 'Please enter name'
              ),
      				'usrPassword'=>array(
                'rule'=>array('notEmpty'),
                'message' => 'Please enter password'
              ),
      				'confPassword'=>array(
                'rule'=>array('notEmpty'),
                'message' => 'Please enter confirm password'
              ),
      				'subject'=>array(
                'rule'=>array('notEmpty'),
                'message' => 'Please enter subject.'
              ),
      				'msgEvent'=>array(
                'rule'=>array('notEmpty'),
                'message' => 'Please enter message.'
              )
		);
		parent::__construct();
		
	} 
}//ec
?>