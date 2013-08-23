<?php
class ReportsController extends AppController{
  var $name = 'Reports';
  var $uses = array();  
  var $components = array('Session');
   
  /**
	* @Date: Dec 29, 2011
	* @Method : timeFrame
	* @Purpose: This function is to show the result between two given dates.
	* @Param: none
	* @Return: none 
	**/  
  function timeFrame(){
    $this->checkSession('Npo');  
    $this->layout = 'layout_inner';
    $userId=$this -> Session -> read('SESSION_USER.Npo.id');
    App::import('Model','Donation');
    $this->Donation = new Donation();
    $startDate=date(Configure::read('MYSQL_DATE_FORMAT'),strtotime($this->request->data['date']) );
    $endDate=date(Configure::read('MYSQL_DATE_FORMAT'), strtotime($this->request->data['enddate']) );
    
    if(!empty($startDate)) {
       $dateCond = " date(Donation.created ) BETWEEN '$startDate' AND '$endDate' ";
     	 $donationData = $this->Donation->find('all',array( 'fields'=>array('sum(Donation.amount) as total','Donation.payer_email'),'conditions'=>array('Donation.npo_id' =>$userId, $dateCond),'group' => 'Donation.payer_email'));
	     //pr($donationData);die();
       $this->set('donationData', $donationData);
	     
	 }
  }//ef
  function index() {
   $this->checkSession('Npo');  
	$this->layout = 'layout_inner';
	$userId=$this -> Session -> read('SESSION_USER.Npo.id');
  }
  	function lastDonation() {  		
      $this->checkSession('Npo');  
      $userId=$this -> Session -> read('SESSION_USER.Npo.id');
      $this->layout = 'layout_inner';
      App::import('Model','Donation');
      $this->Donation = new Donation();
      
      $lastdonationData = $this->Donation->find('first',array('conditions'=>array('Donation.npo_id' =>$userId),'order'=>'Donation.id DESC'));
      //pr($lastdonationData);die();
      $this->set('lastdonationData', $lastdonationData);
  	
  	}
  # *************** This function is used to show the donation amount of type Event  ********	
  	function eventDonation() { 		
      $this->checkSession('Npo');  
      $this->layout = 'layout_inner';
      $userId=$this -> Session -> read('SESSION_USER.Npo.id');
      App::import('Model','Donation');
      $this->Donation = new Donation();
      $dataMem=$this->Donation->bindModel(
      		array(
      			'belongsTo'=>array(
      			'Attribute'=>array(
      			'className'  => 'Attribute',
      			'foreignKey' => false,
      			'conditions'=>array("Attribute.npo_id = Donation.npo_id",'Attribute.id = Donation.attribute_id')
      			
                 )          
             )
          ),false
      );		
      		$typeCond = " Attribute.type='Event'";
       $eventdonationData = $this->Donation->find('all',array('fields'=>array('Attribute.title,sum(Donation.amount) as total,Donation.created'),'conditions'=>array('Donation.npo_id' =>$userId,$typeCond),'group' => 'Donation.attribute_id'));
       //pr($eventdonationData);
       $this->set('eventdonationData', $eventdonationData);
		}

}//ec
?>