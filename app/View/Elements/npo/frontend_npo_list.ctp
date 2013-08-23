<?php 
  $this->Paginator->options(array('update'=>'npoList','indicator'=>'loaderIDast'));
?><div id="container_left"><div class="dashbrd-right">
                
                	<!--White Box Start-->
                	<div class="white-box">
                    
                    	<!--White Box Top Start-->
                        <div class="grey-head-tleft">
                        	<div class="grey-head-tright"><span>NPO/Churches</span></div>
                        </div>
                        <!--White Box Top Closed-->
                        
                        <!--White Box Middle Start-->
                        <div class="white-box-mid" style="min-height:300px">
                            <div class="search_widget">
                                  <?php echo $this->Form->create(null,array('action'=>'','method'=>'post')); ?>
                                <ul class="search_fields_widget">
                                  <li>Search: <?php echo $this->Form->input('searchElement',array('type'=>'text','div'=>false,'label'=>false));?></li>
                                  <li><?php 
                                          echo $this->Form->submit('Search',array('class'=>'button_input'));
                                        ?></li>
                                        </ul>
                                        <?php 
                                          echo $this->Form->end(); ?>
                              </div>
                        	
                            <!--Property Details Box Start-->
                        	<div class="prperties-detailbox">
                                <ul class="church_listing_widget">
                                  <?php 
                                    if(isset($npoList) && !empty($npoList)){
                                      $i = 0;
                                      foreach($npoList as $key=>$value){//echo strlen($value['Npo']['description']);exit;
                                        $i++;
                                        
                                        if($i % 2 == 0){
                                          $class = 'even-col';
                                        }else{
                                          $class = '';                                        
                                        }
                                  ?>
                                  <li class="<?php echo $class; ?>">
                                    <div class="church_pic"><?php echo $this->Html->image(Configure::read('CHURCH_IMAGE_PATH').$value['Npo']['thumb'],array('alt'=>$value['Npo']['title'],'title'=>$value['Npo']['title']))?></div>
                                    <div class="church_content">
                                      <h4><?php echo ucfirst($value['Npo']['title']); ?></h4>
                                      <p><?php echo strlen($value['Npo']['description']) > 290 ? substr($value['Npo']['description'],0,290).'....' : $value['Npo']['description']; ?></p>
                                      
                                    </div>
                                    <div class="right_buttons">
                                      <div class="margin_lft"><?php echo $this->Html->link('View',array('controller'=>'npo','action'=>'viewnpo',$value['Npo']['id']),array('class'=>'button_link'));?> <?php echo $paypal->button('Donate', array('type' => 'donate','class'=>'button_input','item_name'=>$value['Npo']['title'],'custom'=>$value['Npo']['id'].'-'.'0','return' => 'http://'.$_SERVER['HTTP_HOST'].'/paypal_ipn/process')); ?></div>
                                      
                                      <p><?php echo $this->Html->link('Events','/events/npoevent/'.$value['Npo']['id'],array('class'=>'button_link')); ?> <?php echo $this->Html->link('News','/news/nponews/'.$value['Npo']['id'],array('class'=>'button_link')); ?></p>
                                      <p id="join_<?php echo $value['Npo']['id']; ?>"><?php echo $this->Html->link('Become a Member','javascript:void(0)',array('style'=>'width:145px','rel'=>'joinbtn','class'=>'button_link','npoId'=>$value['Npo']['id'])) ?></p>
                                      
                                    </div>
                                  </li>
                                  <?php }
                                  }else{ ?>                                    
                                  <li style="text-align:center"><strong>No church/Npo available right now.</strong></li>
                                  <?php } ?>
                                </ul>
                  			  </div> 
                          <div id="pagination" class="paging_section">
                          
                          <?php
                          echo $this->Paginator->prev($title = '<< Previous', array('recCount'=>$recCount)); 
                          echo $this->Paginator->numbers(array('separator'=>' ','recCount'=>$recCount)); 
                          echo '&nbsp;'.$this->Paginator->next($title = 'Next >>',array('recCount'=>$recCount));
                          if(isset($npoList) && !empty($npoList)){
                          ?>
                          &nbsp;&nbsp;&nbsp;&nbsp;View <?php 
                                                        //$options = array('1'=>'1','2'=>'2','3'=>'3');
                                                        echo $this->Form->input('pagecount',array('type'=>'select','options'=>$options,'div'=>false,'label'=>false));
                                                        echo $ajax->observeField('pagecount',array('url'=>array('controller'=>'npo','action'=>'index'),'update'=>'npoList','indicator'=>'loaderIDast'));
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
                <script type="text/javascript">
                  jQuery('[rel="joinbtn"]').click(function (){
                    var obj = jQuery(this);
                    var npoId = obj.attr('npoid');
                    jConfirm('Become member of organization?','Confirmation',function (r){
                      if(r){
                        jQuery.ajax({
                          url :'/npo/request',
                          data:'npoId='+npoId,
                          success: function(text){  
                            if(text == 'success'){
                              jQuery('#join_'+npoId).html('<span class="greencolor"><strong>Your request has been sent</strong></span>');
                            }
                          }
                        });
                      }
                    },'Yes','Not Now');
                  });
                </script>