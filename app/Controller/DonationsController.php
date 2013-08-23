<?php 
class DonationsController extends AppController{
  var $name = 'Donations';
  var $uses = array('Donation');
  
    /**
	* @Date: November 25, 2011
	* @Method : index
	* @Purpose: This function is to get the donations recieved.
	* @Param: none
	* @Return: none 
	**/
	function index(){
    $this->checkSession('Npo');  
    $this->layout = 'layout_inner'; 
		$this->helpers['Paginator'] = array('ajax' => 'Ajax');		
   if(isset($this->request->data['pagecount']) && !empty($this->request->data['pagecount'])){  	   
  	  $limit =  $this->request->data['pagecount'];
  	}else if(isset($this->request->params['named']['recCount']) && !empty($this->request->params['named']['recCount'])){
  	  $limit = $this->request->params['named']['recCount'];
    }else{
  	  $limit = 10;
    }
    $this->set('recCount',$limit);
	  $npoId     = $this->Session->read('SESSION_USER.Npo.id');
		
	  $this->Donation->bindModel(
	       array(
	         'belongsTo'=>array(
	             'Npo'=>array(
	               'className'  => 'Npo',
                 'foreignKey' => 'npo_id'
               )          
           )
        ),false
    );
		
		
	  $this->Donation->bindModel(
	       array(
	         'belongsTo'=>array(
	             'Attribute'=>array(
	               'className'  => 'Attribute',
                 'foreignKey' => 'attribute_id'
               )          
           )
        ),false
    );
		
	  $this->Donation->bindModel(
	       array(
	         'belongsTo'=>array(
	             'Member'=>array(
	               'className'  => 'Member',
                 'foreignKey' => 'member_id'
               )          
           )
        ),false
    );
		$this->paginate = array('conditions'=>array('Donation.npo_id'=>$npoId),
                            'order'     => array('Donation.modified DESC'),
                            'fields'     => 'Donation.id,Donation.amount,Donation.created,Attribute.title,Member.email',
                            'limit'     => $limit
                              );	 
    $donationList =  $this->paginate('Donation');
    $this->set('donationList',$donationList);
   // pr($donationList);die();
   if($this->RequestHandler->isAjax()){
	      $this->layout = 'ajax';
				$this->viewPath = 'elements'.DS.'donation';
				$this->render('listing');
		}
	   
  }//ef
  
}//ec
?>