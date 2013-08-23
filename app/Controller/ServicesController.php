<?php 
/*
Web services controller class for iPhone
*/
class ServicesController extends AppController{
  var $name = 'Services';
  var $uses = array();
  
   
  /**
	* @Date: October 21, 2011
	* @Method : login
	* @Purpose: This function is to login user in iPhone App.
	* @Param: none
	* @Return: xml 
	**/
	function login(){
    $this->autoRender=false;
    if(!empty($GLOBALS['HTTP_RAW_POST_DATA'])) {
      App::import('Model','NpoMember');
      App::import('Model','Member');
      $this->NpoMember = new NpoMember();
      $this->Member    = new Member();
     /* $xml       = '<?xml version="1.0" encoding="UTF-8" ?>
                      <UserLogin>
                        <email>roger@gmail.com</email>
                        <password>123456</password>
                      </UserLogin>'; */
      $xml = $GLOBALS['HTTP_RAW_POST_DATA'];
      $loginData = simplexml_load_string($xml);
      if(isset($loginData) && is_object($loginData)){
        $userEmail = mysql_real_escape_string($loginData->email);
        $passWord  = mysql_real_escape_string($loginData->password);
        $this->Member->recursive = 2;
        $this->Member->bindModel(
    	       array(
    	         'hasMany'=>array(
    	             'NpoMember'=>array(
      	               'className'  => 'NpoMember',
                       'foreignKey' => 'member_id'
                       
                   )          
               )
            ),false
        ); 
        $this->NpoMember->bindModel(
                  array(
                    'belongsTo'=>array(
                      'Npo'=>array(
                          'className' => 'Npo',
                          'foreignKey' => 'npo_id',
                          'conditions' => array('Npo.status' => 'Active'),
                          'fields'     =>array('Npo.title')
                      )
                    )
                  ),false
        );
        $userData  = $this->Member->find('first',array('fields'=>array('Member.id,Member.name,Member.email,Member.status'),'conditions'=>array('Member.email'=>$userEmail,'Member.password'=>$passWord,'Member.status'=>'Active')));
        //pr($userData);die();
        if(isset($userData) && is_array($userData) && !empty($userData)){
          $responseXml = '<?xml version="1.0" encoding="UTF-8" ?><UserData><id>'.$userData["Member"]["id"].'</id><name>'.$userData["Member"]["name"].'</name><email>'.$userData["Member"]["email"].'</email><status>'.$userData["Member"]["status"].'</status>';
                              
          foreach($userData['NpoMember'] as $key=>$val){
            $responseXml .= '<npotitle>'.$val["Npo"]["title"].'</npotitle>';
          }
                          
            $responseXml .= '</UserData>';
        }else{
          $responseXml = '<?xml version="1.0" encoding="UTF-8" ?><error>Either your username/password is wrong or your account has been disabled</error>';          
        }
        return $responseXml;
      }
    }
  }//ef 
  
  /**
	* @Date: October 21, 2011
	* @Method : login
	* @Purpose: This function is to login user in iPhone App.
	* @Param: none
	* @Return: xml 
	**/
	function npo_list(){
	  $this->autoRender = false;
    App::import('Model','Npo');
    $this->Npo = new Npo();
    $npoList = $this->Npo->find('all',array('fields'=>array('Npo.id,Npo.title,Npo.id,Npo.image,Npo.thumb,Npo.description,Npo.description'),'conditions'=>array('Npo.status'=>'Active')));
    //pr($npoList);die();
    $responseXml = '<?xml version="1.0" encoding="UTF-8" ?><NpoData>';
    foreach($npoList as $key=>$value){
      $responseXml .='<NpoList><id>'.$value["Npo"]["id"].'</id><title>'.trim($value["Npo"]["title"]).'</title><image>'.trim(Configure::read('NPO_IMAGE_URL').$value["Npo"]["image"]).'</image><thumb>'.trim(Configure::read('NPO_IMAGE_URL').$value["Npo"]["thumb"]).'</thumb><description>'.trim($value["Npo"]["description"]).'</description></NpoList>';
    }    
    $responseXml .= '</NpoData>';
    return $responseXml;
  }//ef
  
  /**
	* @Date: November 16, 2011
	* @Method : npo_events
	* @Purpose: This function is to get Events of the npos.
	* @Param: id
	* @Return: xml 
	**/
	function npo_events($id){
	  $this->autoRender = false;
    App::import('Model','Attribute');
    $this->Attribute = new Attribute();
    $npoEvents = $this->Attribute->find('all',array('fields'=>array('Attribute.id,Attribute.title,Attribute.description,Attribute.image_name,Attribute.time,Attribute.date,Attribute.is_donate'),'conditions'=>array('Attribute.status'=>'Active','Attribute.type' =>'Event','Attribute.npo_id' =>$id)));
    //pr($npoEvents);die();
    $responseXml = '<?xml version="1.0" encoding="UTF-8" ?><NpoEvent>';
    foreach($npoEvents as $key=>$value){
      $responseXml .='<Events><EventID>'.$value['Attribute']['id'].'</EventID><EventTitle>'.$value["Attribute"]["title"].'</EventTitle><EventTime>'.$value["Attribute"]["time"].'</EventTime><EventDate>'.$value["Attribute"]["date"].'</EventDate><PhotoUrl>'.trim(str_replace('{id}',$id,Configure::read('CHURCH_EVENT_URL').$value["Attribute"]["image_name"])).'</PhotoUrl><ThumbUrl>'.trim(str_replace('{id}',$id,Configure::read('CHURCH_EVENT_URL').$value["Attribute"]["image_name"])).'</ThumbUrl><EventDescription>'.$value["Attribute"]["description"].'</EventDescription><IsDonate>'.$value["Attribute"]["is_donate"].'</IsDonate></Events>';
    }    
    $responseXml .= '</NpoEvent>';
    return $responseXml;
  }//ef
  
  /**
	* @Date: November 16, 2011
	* @Method : npo_news
	* @Purpose: This function is to get News of the npos.
	* @Param: id
	* @Return: xml 
	**/
	function npo_news($id){
	  $this->autoRender = false;
    App::import('Model','Attribute');
    $this->Attribute = new Attribute();
    $npoNews = $this->Attribute->find('all',array('fields'=>array('Attribute.id,Attribute.title,Attribute.description,Attribute.created,Attribute.publisher,Attribute.short_description,Attribute.image_name,Attribute.is_donate'),'conditions'=>array('Attribute.status'=>'Active','Attribute.type' =>'News','Attribute.npo_id' =>$id)));
    //pr($npoNews);die();
    $responseXml = '<?xml version="1.0" encoding="UTF-8" ?><NPONews>';
    foreach($npoNews as $key=>$value){
      $responseXml .='<News><NewsID>'.$value['Attribute']['id'].'</NewsID><NewsTitle>'.$value["Attribute"]["title"].'</NewsTitle><NewsDate>'.date(Configure::read('userDateFormat'),strtotime($value["Attribute"]["created"])).'</NewsDate><PublisherName>'.$value["Attribute"]["publisher"].'</PublisherName><PhotoUrl>'.trim(str_replace('{id}',$id,Configure::read('CHURCH_NEWS_URL').$value["Attribute"]["image_name"])).'</PhotoUrl><ThumbUrl>'.trim(str_replace('{id}',$id,Configure::read('CHURCH_NEWS_URL').$value["Attribute"]["image_name"])).'</ThumbUrl><ShortDescription>'.$value["Attribute"]["short_description"].'</ShortDescription><DetailDescription>'.$value["Attribute"]["description"].'</DetailDescription><IsDonate>'.$value["Attribute"]["is_donate"].'</IsDonate></News>';
    }    
    $responseXml .= '</NPONews>';
    //echo $responseXml;exit;
    return $responseXml;
  }//ef
  
  /**
	* @Date: November 18, 2011
	* @Method : event_message
	* @Purpose: This function is to get messages of events.
	* @Param: id
	* @Return: xml 
	**/
	function event_messages(){
	  $this->autoRender = false;
    App::import('Model','Attribute');
    $this->Attribute = new Attribute();
    App::import('Model','AttributeMessage');
    $this->AttributeMessage = new AttributeMessage();
    $this->Attribute->recursive = 2;
    $this->Attribute->bindModel(
                  array(
                    'hasMany'=>array(
                          'AttributeMessage'=>array(
                          'className' => 'AttributeMessage',
                          'foreignKey' =>'attribute_id',
                          'fields'     => array('AttributeMessage.message,AttributeMessage.created'),
                          'conditions'=>array('AttributeMessage.status'=>'Active')
                      )
                    )
                  )
        );
    $npoMessage = $this->Attribute->find('all',array('fields'=>array('Attribute.title,Attribute.id')));
    //pr($npoMessage);die();
    $responseXml = '<?xml version="1.0" encoding="UTF-8" ?><Events>';
    foreach($npoMessage as $key=>$value){
      $responseXml .='<Event><EventID>'.$value['Attribute']['id'].'</EventID><EventName>'.$value["Attribute"]["title"].'</EventName><Messages>';
        foreach($value['AttributeMessage'] as $k=>$v){
          $responseXml .='<Message><message>'.$v['message'].'</message><date>'.date(Configure::read('npoDateFormat'),strtotime($v['created'])).'</date></Message>';
        }
      $responseXml .='</Messages></Event>';
    }    
    $responseXml .= '</Events>';
    return $responseXml;
  }//ef
}//ec
?>