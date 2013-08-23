
<div id="container_left"><div class="dashbrd-right">
                
                	<!--White Box Start-->
                	<div class="white-box">
                    
                    	<!--White Box Top Start-->
                        <div class="grey-head-tleft">
                        	<div class="grey-head-tright"><span>Contact Us</span></div>
                        </div>
                        <!--White Box Top Closed-->
                        
                        <!--White Box Middle Start-->
                        <div class="white-box-mid">
<?php echo $this->Form->create(null,array('id'=>'frmContact','name'=>'frmContact','action'=>'index')); ?>
                            <!--Flag Alerts Start-->
                          <div class="flag-alert" align="center">
                              <table width="90%" border="0" cellspacing="0" cellpadding="0" class="table-widget">
                                    <tr>
                                      <td width="30%" class="theading" align="right"><strong><?php echo __('E-mail'); ?>:</strong></td><td width="50%" class="theading"><?php echo $this->Form->input('email',array('type'=>'text','id'=>'email','class'=>'required email','div'=>false,'label'=>false)); ?></td>
                                    </tr>
				<tr>
                                      <td width="30%" class="theading" align="right"><strong><?php echo __('Name'); ?>:</strong></td><td width="50%" class="theading"><?php echo $this->Form->input('userName',array('type'=>'text','id'=>'userName','class'=>'required','div'=>false,'label'=>false)); ?></td>
                                    </tr>
				<tr>
                                      <td width="30%" class="theading" align="right"><strong><?php echo __('Message'); ?>:</strong></td><td width="50%" class="theading"><?php echo $this->Form->input('message',array('type'=>'textarea','id'=>'message','class'=>'required','div'=>false,'label'=>false)); ?></td>
                                 </tr>
				<tr>
                                      <td colspan="2" class="theading" align="center"><?php echo $this->Form->submit('Send',array('type'=>'submit','id'=>'submit','value'=>'Send'));?></td>
                                 </tr>

                              </table>

                            </div>
<?php echo $this->Form->end(); ?>
                        </div>
                        <!--White Box Middle Closed-->  
                    </div>
                    <!--White Box Closed-->
                </div></div>
<script type="text/javascript">
  jQuery(document).ready(function (){
    jQuery('#frmContact').validate({
   	errorClass : 'regError' 
   });
  });
</script>