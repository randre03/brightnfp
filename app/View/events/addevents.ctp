<div id="container_left">
<?php echo $this->Form->create('Attribute',array('url'=>'/events/addevents','method'=>'post','enctype'=>'multipart/form-data','id'=>'frmEvent','name'=>'frmEvent')); ?>
 <div class="register_form">
           <!-- Step 1 -->
             <div class="reg-form">
                <div class="form-object"> <label>Image</label>
                <div class="input_fields">
                <div class="upload"><div class="fakeupload">
                <?php echo $this->Form->input('fakeupload',array('type'=>'text','name'=>'fakeupload','div'=>false,'label'=>false)) ?><!-- browse button is here as background --></div> <?php echo $this->Form->input('image',array('type'=>'file','id'=>'realupload','onchange'=>'this.form.fakeupload.value = this.value;','div'=>false,'label'=>false,'class'=>'realupload')); ?></div></div></div>
                <div class="form-object"> 
                  <label>Title</label>
                  <div class="input_fields"><?php echo $this->Form->input('title',array('type'=>'text','div'=>false,'label'=>false,'class'=>'required')); ?></div>
                  </div>
                <div class="form-object"> <label>Date</label>
                <div class="input_fields"><?php echo $this->Form->input('date',array('id'=>'date','type'=>'text','div'=>false,'label'=>false,'class'=>'required')); ?></div></div>
                <div class="form-object"> <label>Start Time</label>
                <div class="input_fields"><?php echo $this->Form->input('time',array('id'=>'time','type'=>'text','div'=>false,'label'=>false,'class'=>'required')); ?></div></div>
                <div class="form-object" style="margin-bottom:20px"> <label>Description</label>
                <div class="input_fields"><?php echo $this->Form->input('fullDesc',array('type'=>'textarea','class'=>'required','rows'=>'10','cols'=>'30','div'=>false,'label'=>false)); ?></div></div>
                <!--<div class="form-object"> <label>Donate</label><div class="input_fields"><?php echo $this->Form->input('donate',array('type'=>'select','options'=>array('Yes'=>'Yes','No'=>'No'),'selected'=>'Yes','div'=>false,'label'=>false,'class'=>'required')); ?></div>
                </div>-->
             </div>
             
               <div class="create_btn_wrap"><?php echo $this->Form->submit('Submit',array('class'=>'create_btn button_margin_left')); ?></div>
           </div>
<?php echo $this->Form->end(); ?>
</div>
<script type="text/javascript">
  jQuery(document).ready(function (){
    jQuery('#frmEvent').validate({
      errorClass:'regError',
      rules :{
        'data[Npo][image]':{
            accept: "gif|jpg|jpeg|png"
        }
        }
  });
    
    jQuery('#time').timepicker({
        ampm: true,
    });
    jQuery('#date').datepicker({
      dateFormat: 'dd-mm-yy'
    });
  });
</script>