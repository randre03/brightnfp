<div id="container_left"><div class="dashbrd-right">
                
                	<!--White Box Start-->
                	<div class="white-box">
                                                           
                        <!--White Box Middle Start-->
                        <div class="white-box-mid" style="min-height:300px">
                        	
                            <!--Property Details Box Start-->
                        	<div class="prperties-detailbox">
                                <ul class="church_listing_widget">
                                  <?php if(isset($npoList) && !empty($npoList)){ ?>                                  
                                  <li>
                                  
                                    <div class="church_con">
                                      <h4><?php echo ucfirst($npoList['Attribute']['title']); ?></h4>
                                      
                                       <div class="church_pic2"><?php echo $npoList['Attribute']['image_name'] !='' ? $this->Html->image(str_replace('{id}',$npoId,Configure::read('CHURCH_EVENT_URL')).$npoList['Attribute']['image_name'],array('alt'=>$npoList['Attribute']['title'],'title'=>$npoList['Attribute']['title'])) : $this->Html->image('/img/no_image_big.jpg'); ?>
                                       </div> 
                                       <div class="church_des">  
                                       <div class="eventon">
                                        <h4>Event Timings: <span><?php echo date(Configure::read('npoTimeFormat'),strtotime($npoList['Attribute']['time'])); ?></span></h4>
                                        <h4>Start Time: <span><?php echo date(Configure::read('npoDateFormat'),strtotime($npoList['Attribute']['date'])); ?></span></h4>
                                      </div>                                       
                                       <div class="event_details_sec">                         
                                      <h6>Long Description</h6>
                                      <p><?php echo $npoList['Attribute']['description']; ?></p></div>  </div></div>
                                      <div class="church_mes">                       
                                          <h6>Message(s) of <?php echo ucfirst($npoList['Attribute']['title']); ?>:</h6>
                                          <ul class="church_listing_widget">
                                          <?php if(isset($npoList['AttributeMessage']) && !empty($npoList['AttributeMessage'])){ 
                                                  $i = 0;
                                                  foreach($npoList['AttributeMessage'] as $key=>$value){
                                                  $i++;
                                                  if($i % 2 == 0){
                                                    $class = "even-col";
                                                  }else{
                                                    $class = "";
                                                  }
                                          ?>
                                          <li class="<?php echo $class; ?>">
                                            <div class="church_content" style="width:100%">
                                                <p><?php echo $value['message'] ?></p>
                                                  <h5>Sent On <?php echo date(Configure::read('npoDateFormat').' | '.Configure::read('npoTimeFormat'),strtotime($value['created'])) ?></h5>
                                            </div>
                                          </li>
                                      <?php }}else{ ?>
                                          <li>
                                            <div class="church_content" style="width:100%;text-align:center">
                                                <p><strong>No message found</strong></p>
                                            </div>
                                          </li>
                                        
                                      <?php } ?>
                                      </ul>
                                  
                                  
                                    </div>
                                    <div class="buttons">
                                      <div class="margin_lft btns"><?php echo $paypal->button('Donate', array('type' => 'donate','class'=>'button_input','item_name'=>$npoList['Attribute']['title'],'custom'=>$npoId.'-'.$npoList['Attribute']['id'],'return' => 'http://'.$_SERVER['HTTP_HOST'].'/paypal_ipn/process')); ?></div>
                                      
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