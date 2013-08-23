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
                                  
                                    <div class="church_content2">
                                      <h4><?php echo ucfirst($value['Npo']['title']); ?></h4>
                                      <h5>2:42pm December 13, 2011  </h5>
                                      <p>
                                       <span class="church_pic2"><?php echo $this->Html->image(Configure::read('CHURCH_IMAGE_PATH').$value['Npo']['thumb'],array('alt'=>$value['Npo']['title'],'title'=>$value['Npo']['title']))?>
                                       </span>
                                      <?php echo strlen($value['Npo']['description']) > 290 ? substr($value['Npo']['description'],0,290).'....' : $value['Npo']['description']; ?></p>
                                      
                                      <h6>Short Description</h6>
                                      <p>Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem..</p>
                                      <h6>Long Description</h6>
                                      <p>Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lo....</p>
                                      <div class="eventon">
                                        <h4>Event Timings: <span>4:00pm</span></h4>
                                        <h4>Occurs on: <span>December 13, 2011</span></h4>
                                      </div>
                                      
                                    </div>
                                    <div class="buttons">
                                      <div class="margin_lft btns"><a href="#" class="button_link">View</a> <?php echo $paypal->button('Donate', array('type' => 'donate','class'=>'button_input','item_name'=>$value['Npo']['title'],'custom'=>$value['Npo']['id'].'-'.'0','return' => 'http://'.$_SERVER['HTTP_HOST'].'/paypal_ipn/process')); ?></div>
                                      
                                      <p class="btns"><?php echo $this->Html->link('Events','/events/npoevent/'.$value['Npo']['id'],array('class'=>'button_link')); ?> <?php echo $this->Html->link('News','/news/nponews/'.$value['Npo']['id'],array('class'=>'button_link')); ?></p>
                                      <p class="btns" id="join_<?php echo $value['Npo']['id']; ?>"><?php echo $this->Html->link('Become a Member','javascript:void(0)',array('style'=>'width:145px','rel'=>'joinbtn','class'=>'button_link','npoId'=>$value['Npo']['id'])) ?></p>
                                      
                                    </div>
                                  </li>
                                  <?php }
                                  }else{ ?>                                    
                                  <li style="text-align:center"><strong>No church/Npo available right now.</strong></li>
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