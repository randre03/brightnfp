<div id="container_left">
<?php echo $this->Form->create('Member',array('url'=>'/members/sendmessage','method'=>'post','id'=>'frmMsg','name'=>'frmMsg')); 
      echo $this->Form->hidden('memEmail',array('value'=>$memEmail));
?>
 <div class="register_form">
           <!-- Step 1 -->
             <div class="reg-form">
                <div class="form-object"> <label>Subject</label><div class="input_fields"><?php echo $this->Form->input('subject',array('type'=>'text','class'=>'required','div'=>false,'label'=>false)); ?></div></div>
             </div>
           <!-- Step 1 -->
             <div class="reg-form">
                <div class="form-object" style="margin-bottom:20px"> <label>Message for Member(s)</label><div class="input_fields"><?php echo $this->Form->input('msgEvent',array('type'=>'textarea','class'=>'required','rows'=>'10','cols'=>'30','div'=>false,'label'=>false)); ?></div></div>
             </div>
             
               <div class="create_btn_wrap"><?php echo $this->Form->submit('Submit',array('class'=>'create_btn','style'=>'margin-left: 233px;')); ?></div>
           </div>
<?php echo $this->Form->end(); ?>
</div>
<script type="text/javascript">
  jQuery(document).ready(function (){
    jQuery('#frmMsg').validate({errorClass:'regError'});
  });
</script>