<div id="container_left"><div class="dashbrd-right">
                
                	<!--White Box Start-->
                	<div class="white-box">
                    
                    	<!--White Box Top Start-->
                        <!--White Box Top Closed-->
                        
                        <!--White Box Middle Start-->
                        <div class="white-box-mid" style="min-height:300px">
                        	
                            <!--Property Details Box Start-->
                        	<div class="prperties-detailbox">
                                <ul class="church_listing_widget">
                                  <?php if(isset($npoList) && !empty($npoList)){ ?>                                  
                                  <li>
                                  
                                    <div class="church_con">
                                      <h4><?php echo ucfirst($npoList['Attribute']['title']); ?></h4>
                                      
                                       <div class="church_pic2"><?php echo $npoList['Attribute']['image_name'] !='' ? $this->Html->image(str_replace('{id}',$npoId,Configure::read('CHURCH_NEWS_URL')).$npoList['Attribute']['image_name'],array('alt'=>$npoList['Attribute']['title'],'title'=>$npoList['Attribute']['title'])) : $this->Html->image('/img/no_image_big.jpg'); ?>
                                       </div>
                                      
                                      <div class="church_des">
                                      <h6>Short Description</h6>
                                      <p><?php echo $npoList['Attribute']['short_description']; ?></p>
                                      <h6>Long Description</h6>
                                      <p><?php echo $npoList['Attribute']['description']; ?></p>
                                        </div>                                    
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