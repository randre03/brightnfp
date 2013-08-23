<?php
class NotificationsController extends AppController{
  var $name = 'Notification';
  var $uses = array();
  
  function index(){
    App::import('Model','Donation');
    $this->Donation = new Donation();
    
  }//ef
}//ec 
?>