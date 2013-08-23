<?php 
$eventStr = '';
  foreach($events as $event){
    $paypalBtn = $paypal->button('Donate', array('type' => 'donate','class'=>'button_input','item_name'=>$event['Attribute']['title'],'custom'=>$npoId.'-'.$event['Attribute']['id'].'-events-'.$address,'return' => 'http://'.$_SERVER['HTTP_HOST'].'/paypal_ipn/process'));
    $imgUrl = $event['Attribute']['thumb_name'] != '' ? str_replace('{id}',$event['Npo']['id'],Configure::read('CHURCH_EVENT_URL')).$event['Attribute']['thumb_name'] : '/img/no_image_small.png';
    $eventStr .= str_replace(array('{title}','{desc}','{source}','{paypal_btn}','{npo_id}','{event_id}'),array($event['Attribute']['title'],strlen($event['Attribute']['description']) > 50 ? substr($event['Attribute']['description'],0,350).'...' : $event['Attribute']['description'] ,$imgUrl,$paypalBtn,$event['Npo']['id'],$event['Attribute']['id']),$event['TemplateTheme']['event_html']);
  }
echo $eventStr; 
?>