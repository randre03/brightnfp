<div id="container_left"><div class="dashbrd-right">
                
                	<!--White Box Start-->
                	<div class="white-box">
                    
                    	<!--White Box Top Start-->
                        <div class="grey-head-tleft">
                        	<div class="grey-head-tright"><span>NPO/Churches</span></div>
                        </div>
                        <!--White Box Top Closed-->
                        
                        <!--White Box Middle Start-->
                        <div class="white-box-mid" style="min-height:300px">
                        	
                            <!--Property Details Box Start-->
                        	<div class="prperties-detailbox">
                                <ul class="church_listing_widget">
                                  <?php 
                                    if(isset($npoList) && !empty($npoList)){
                                  ?>
                                  <li>
                                  
                                    <div class="church_con">
                                      <h4><?php echo ucfirst($npoList['Npo']['title']); ?></h4>
                                     
                                       <div class="church_pic2"><?php echo $this->Html->image(Configure::read('CHURCH_IMAGE_PATH').$npoList['Npo']['image'],array('alt'=>$npoList['Npo']['title'],'title'=>$npoList['Npo']['title']))?>
                                       </div>                                     
                                         
                                         <div class="church_des">                                 
                                      <h6>Description</h6>
                                      <p><?php echo $npoList['Npo']['description']; ?></p></div> 
                                    </div>
                                    <div class="buttons">
                                      <div class="margin_lft btns"> <?php echo $paypal->button('Donate', array('type' => 'donate','class'=>'button_input','item_name'=>$npoList['Npo']['title'],'custom'=>$npoList['Npo']['id'].'-'.'0','return' => 'http://'.$_SERVER['HTTP_HOST'].'/paypal_ipn/process')); ?></div>
                                      
                                      <p class="btns"><?php echo $this->Html->link('Events','/events/npoevent/'.$npoList['Npo']['id'],array('class'=>'button_link')); ?> <?php echo $this->Html->link('News','/news/nponews/'.$npoList['Npo']['id'],array('class'=>'button_link')); ?></p>
                                      <p class="btns" id="join_<?php echo $npoList['Npo']['id']; ?>"><?php echo $this->Html->link('Become a Member','javascript:void(0)',array('style'=>'width:145px','rel'=>'joinbtn','class'=>'button_link','npoId'=>$npoList['Npo']['id'])) ?></p>
                                      
                                    </div>
                                  </li>
                                  <?php } ?>
                                </ul>
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
                    jConfirm('Are you sure to join this Church/Npo?','Confirmation',function (r){
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
                    });
                  });
                </script>