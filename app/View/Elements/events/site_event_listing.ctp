<?php 
  $this->Paginator->options(array('update'=>'siteEvents','indicator'=>'loaderIDast'));
$eventStr = '';
  foreach($events as $event){
    $paypalBtn = $paypal->button('Donate', array('type' => 'donate','class'=>'button_input','item_name'=>$event['Attribute']['title'],'custom'=>$npoId.'-'.$event['Attribute']['id'].'-events-'.$address,'return' => 'http://'.$_SERVER['HTTP_HOST'].'/paypal_ipn/process'));
    $imgUrl = $event['Attribute']['thumb_name'] != '' ? str_replace('{id}',$event['Npo']['id'],Configure::read('CHURCH_EVENT_URL')).$event['Attribute']['thumb_name'] : '/img/no_image_small.png';
    $eventStr .= str_replace(array('{title}','{desc}','{source}','{paypal_btn}','{npo_id}','{event_id}'),array($event['Attribute']['title'],strlen($event['Attribute']['description']) > 50 ? substr($event['Attribute']['description'],0,350).'...' : $event['Attribute']['description'] ,$imgUrl,$paypalBtn,$event['Npo']['id'],$event['Attribute']['id']),$event['TemplateTheme']['event_html']);
  }
echo $eventStr; 
?>
<div id="pagination" class="paging_section">
                          
                          <?php
                          echo $this->Paginator->prev($title = '<< Previous',array('recCount'=>$recCount)); 
                          echo $this->Paginator->numbers(array('separator'=>' ','recCount'=>$recCount)); 
                          echo '&nbsp;'.$this->Paginator->next($title = 'Next >>',array('recCount'=>$recCount));
                          if(isset($event) && !empty($event)){
                          ?>
                          &nbsp;&nbsp;&nbsp;&nbsp;View <?php 
                                                       //$options = array('1'=>'1','2'=>'2','3'=>'3');
                                                        echo $this->Form->input('pagecount',array('type'=>'select','options'=>$options,'div'=>false,'label'=>false));
                                                        echo $ajax->observeField('pagecount',array('url'=>array('controller'=>'events','action'=>'events',$address),'update'=>'siteEvents','indicator'=>'loaderIDast'));
                                                       ?> 
                          <?php } ?>
 </div> 