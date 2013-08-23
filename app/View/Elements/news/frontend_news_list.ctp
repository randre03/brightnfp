<?php 
  $this->Paginator->options(array('update'=>'newsDiv','indicator'=>'loaderIDast'));
?><div id="container_left"><div class="dashbrd-right">
                
                	<!--White Box Start-->
                	<div class="white-box">
                    
                    	<!--White Box Top Start-->
                        <div class="grey-head-tleft">
                        	<div class="grey-head-tright"><span>News of <?php echo $npoTitle; ?></span></div>
                        </div>
                        <!--White Box Top Closed-->
                        
                        <!--White Box Middle Start-->
                        <div class="white-box-mid" style="min-height:300px">
                        	
                            <!--Property Details Box Start-->
                        	<div class="prperties-detailbox">
                                <ul class="church_listing_widget">
                                  <?php 
                                    if(isset($eventList) && !empty($eventList)){
                                      $i = 0;
                                      foreach($eventList as $key=>$value){//echo strlen($value['Attribute']['description']);exit;
                                        $i++;
                                        
                                        if($i % 2 == 0){
                                          $class = 'even-col';
                                        }else{
                                          $class = '';                                        
                                        }
                                  ?>
                                  <li class="<?php echo $class; ?>">
                                    <div class="church_pic"><?php echo $value['Attribute']['thumb_name'] !='' ? $this->Html->image(str_replace('{id}',$npoId,Configure::read('CHURCH_NEWS_URL')).$value['Attribute']['thumb_name'],array('alt'=>$value['Attribute']['title'],'title'=>$value['Attribute']['title'])) : $this->Html->image('/img/no_image_small.png')?></div>
                                    <div class="church_content">
                                      <h4><?php echo ucfirst($value['Attribute']['title']); ?></h4>
                                      <p><?php echo strlen($value['Attribute']['description']) > 290 ? substr($value['Attribute']['description'],0,290).'....' : $value['Attribute']['description']; ?></p>
                                      
                                    </div>
                                    <div class="right_buttons">
                                      <div class="margin_lft"><?php echo $this->Html->link('View',array('controller'=>'news','action'=>'viewnews',$value['Attribute']['id'],$npoId),array('class'=>'button_link')); ?>&nbsp;<?php echo $paypal->button('Donate', array('type' => 'donate','class'=>'button_input','item_name'=>$value['Attribute']['title'],'custom'=>$npoId.'-'.$value['Attribute']['id'],'return' =>'http://'.$_SERVER['HTTP_HOST'].'/paypal_ipn/process')); ?></div>
                                    
                                      <!--<p><?php echo $this->Html->link('Events','/events/npoevent/'.$value['Attribute']['id'],array('class'=>'button_link')); ?> <a href="#" class="button_link">News</a></p>-->
                                      
                                    </div>
                                  </li>
                                  <?php }
                                  }else{ ?>                                    
                                  <li style="text-align:center"><strong>No News available right now.</strong></li>
                                  <?php } ?>
                                </ul>
                  			  </div> 
                          <div id="pagination" class="paging_section">
                          
                          <?php
                          echo $this->Paginator->prev($title = '<< Previous',array('recCount'=>$recCount)); 
                          echo $this->Paginator->numbers(array('separator'=>' ','recCount'=>$recCount)); 
                          echo '&nbsp;'.$this->Paginator->next($title = 'Next >>',array('recCount'=>$recCount));
                          if(isset($eventList) && !empty($eventList)){
                          ?>
                          &nbsp;&nbsp;&nbsp;&nbsp;View <?php 
                                                       // $options = array('1'=>'1','2'=>'2','3'=>'3');
                                                        echo $this->Form->input('pagecount',array('type'=>'select','options'=>$options,'div'=>false,'label'=>false));
                                                        echo $ajax->observeField('pagecount',array('url'=>array('controller'=>'news','action'=>'nponews',$npoId),'update'=>'newsDiv','indicator'=>'loaderIDast'));
                                                       ?> 
                          <?php } ?>
                          </div>                 			 
                         <!--Property Details Box Closed-->
                            
                            <!--Flag Alerts Start-->
                          
                            <!--Flag Alerts Closed-->
                        
                        </div>
                        <!--White Box Middle Closed-->  
                    </div>
                    <!--White Box Closed-->
                    
                </div></div>