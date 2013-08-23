<?php 
  $this->Paginator->options(array('update'=>'siteEvents','indicator'=>'loaderIDast'));
$newStr = '';
  foreach($news as $new){
    $paypalBtn = $paypal->button('Donate', array('type' => 'donate','class'=>'button_input','item_name'=>$new['Attribute']['title'],'custom'=>$npoId.'-'.$new['Attribute']['id'].'-events-'.$address,'return' => 'http://'.$_SERVER['HTTP_HOST'].'/paypal_ipn/process'));
    $imgUrl = $new['Attribute']['thumb_name'] != '' ? str_replace('{id}',$new['Npo']['id'],Configure::read('CHURCH_EVENT_URL')).$new['Attribute']['thumb_name'] : '/img/no_image_small.png';
    $newStr .= str_replace(array('{title}','{desc}','{source}','{paypal_btn}','{npo_id}','{event_id}'),array($new['Attribute']['title'],strlen($new['Attribute']['description']) > 50 ? substr($new['Attribute']['description'],0,350).'...' : $new['Attribute']['description'] ,$imgUrl,$paypalBtn,$new['Npo']['id'],$new['Attribute']['id']),$new['TemplateTheme']['news_html']);
  }
echo $newStr; 
?>
<div id="pagination" class="paging_section">
                          
                          <?php
                          echo $this->Paginator->prev($title = '<< Previous',array('recCount'=>$recCount)); 
                          echo $this->Paginator->numbers(array('separator'=>' ','recCount'=>$recCount)); 
                          echo '&nbsp;'.$this->Paginator->next($title = 'Next >>',array('recCount'=>$recCount));
                          if(isset($news) && !empty($news)){
                          ?>
                          &nbsp;&nbsp;&nbsp;&nbsp;View <?php 
                                                       //$options = array('1'=>'1','2'=>'2','3'=>'3');
                                                        echo $this->Form->input('pagecount',array('type'=>'select','options'=>$options,'div'=>false,'label'=>false));
                                                        echo $ajax->observeField('pagecount',array('url'=>array('controller'=>'news','action'=>'news',$address),'update'=>'siteEvents','indicator'=>'loaderIDast'));
                                                       ?> 
                          <?php } ?>
 </div> 