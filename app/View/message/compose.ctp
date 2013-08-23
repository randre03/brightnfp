<?php echo $this->Form->create('Message',array('url'=>'/message/compose','method'=>'post','id'=>'frmEvent','name'=>'frmEvent')); 
?><div id="container_left">
 <div class="register_form">
           <!-- Step 1 -->
             <div class="reg-form">
                <div class="form-object"> 
                <label>Subject</label>
                <div class="input_fields"><?php echo $this->Form->input('subject',array('type'=>'text','class'=>'required','div'=>false,'label'=>false)); ?>
                </div></div>
                <div class="form-object" style="margin-bottom:20px"> <label>Message to Administrator</label>
                <div class="input_fields"><?php echo $this->Form->input('msgEvent',array('type'=>'textarea','class'=>'required','rows'=>'10','cols'=>'30','div'=>false,'label'=>false)); ?></div>
                </div>
                
                <div class="create_btn_wrap"><?php echo $this->Form->submit('Submit',array('class'=>'create_btn button_margin_left')); ?></div>
             </div>
             
               
           </div>
</div>
<?php echo $this->Form->end(); ?>
<script type="text/javascript">
  jQuery(document).ready(function (){
    jQuery('#frmEvent').validate({errorClass:'regError'});
  });
</script>