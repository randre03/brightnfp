<section id="content_container">
      <section id="container_wrap">
         <div id="container_left" style="width: 834px;"><div class="dashbrd-right">
                
                	<!--White Box Start-->
                	<div class="white-box">
                    
                    	<!--White Box Top Start-->
                        <div class="grey-head-tleft">
                        	<div class="grey-head-tright"><span>Forgot Password?</span></div>
                        </div>
                        <!--White Box Top Closed-->
                        
                      <?php
                       echo $this->Form->create(null,array('action'=>'','method'=>'post','id'=>"frmForgotPassword",'name'=>'frmForgotPassword'));
                       ?>
                        <!--White Box Middle Start-->
                        <div class="white-box-mid">  
                         <table cellpadding="0" cellspacing="0" border="0" align="center" width="100%">
                            <tr>
                              <td width="45%" align="right">Username:</td>
                              <td><div class="textbox" style="width:100%">
                                  <?php  echo $this->Form->input('username',array('type'=>'text','class'=>'required','div'=>false,'label'=>false)); ?>
                                  </div>
                              </td>
                            </tr>
                            <tr>
                              <td colspan="2" align="center">&nbsp;</td>
                            </tr>
                            <tr>
                              <td colspan="2" align="center"><?php echo $this->Form->submit('Submit'); ?></td>
                            </tr>
                         </table> 
                        </div>
                        <!--White Box Middle Closed-->  
                       <?php                       
                       echo $this->Form->end();
                      ?>
                    </div>
                    <!--White Box Closed-->
                    
                </div></div>
      </section>
</section>
<script type="text/javascript">
  jQuery(document).ready(function (){
    jQuery('#frmForgotPassword').validate();
  });
</script>