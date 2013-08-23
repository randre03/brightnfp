<div id="container_left"><div class="dashbrd-right">
                
                	<!--White Box Start-->
                	<div class="white-box">
                    
                    	<!--White Box Top Start-->
                        <div class="grey-head-tleft">
                        	<div class="grey-head-tright"><span>Message</span></div>
                        </div>
                        <!--White Box Top Closed-->
                        
                        <!--White Box Middle Start-->
                        <div class="white-box-mid">
                        	
                            <!--Property Details Box Start-->
                        	<div class="prperties-detailbox">
                                
                  			</div>
                            <!--Property Details Box Closed-->
                         <div class="search_widget">&nbsp;
                              <div class="right_link">
                              <?php 
                          if($type=='inbox'){echo $this->Html->image('/img/icons/mail_reply.png');
                            echo $this->Html->link('Reply','/message/compose/'.$msg_detail['Message']['id'],array('class'=>"green_link"));
                          } ?></div>
                         </div>  
                         
                         <!--Message Details Start-->
                         <div class="message_details_sec">
                         
                          <ul class="msg_con_sec">
                            <li>
                              <label>Subject:</label>
                              <div class="label_right"><?php echo $msg_detail['Message']['subject']; ?></div>
                            </li>
                            <li>
                              <label>Sent On:</label>
                              <div class="label_right"><?php echo date(Configure::read('npoDateFormat'),strtotime($msg_detail['Message']['created'])); ?></div>
                            </li>
                            
                            <li>
                              <label>Message:</label>
                              <div class="label_right"><?php echo $msg_detail['Message']['message']; ?></div>
                            </li>
                          </ul>
                         
                         </div>
                         <!--Message Details CLosed-->
                         
                        
                        </div>
                        <!--White Box Middle Closed-->  
                    </div>
                    <!--White Box Closed-->
               
                </div></div>
                
                <script type="text/javascript">
                  jQuery(document).ready(function(){
                    jQuery('.msg_con_sec li:odd').addClass('even-col');
                  });
                </script>