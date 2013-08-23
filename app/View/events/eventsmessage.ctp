<div id="container_left">
<?php echo $this->Form->create('AttributeMessage',array('url'=>'/events/eventsmessage','method'=>'post','id'=>'frmEvent','name'=>'frmEvent')); 
      echo $this->Form->hidden('eventIds',array('value'=>$eventIds));
?>
 <div class="register_form">
           <!-- Step 1 -->
             <div class="reg-form">
                <div class="form-object" style="margin-bottom:20px"> <label>Message for event(s)</label><div class="input_fields"><?php echo $this->Form->input('msgEvent',array('type'=>'textarea','class'=>'required','rows'=>'10','cols'=>'30','div'=>false,'label'=>false)); ?></div></div>
             </div>
             
               <div class="create_btn_wrap"><?php echo $this->Form->submit('Submit',array('class'=>'create_btn','style'=>'margin-left: 233px;')); ?></div>
           </div>
<?php echo $this->Form->end(); ?>
</div>
<script type="text/javascript">
  jQuery(document).ready(function (){
    jQuery('#frmEvent').validate({errorClass:'regError'});
  });
</script>