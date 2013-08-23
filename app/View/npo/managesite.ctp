<?php echo $this->Form->create('Npo',array('url'=>'/npo/managesite','method'=>'post','id'=>'frmSite','name'=>'frmSite','enctype'=>'multipart/form-data'));
      echo $this->Form->hidden('id'); 
?>

<div id="container_left">
 <div class="register_form">
           <!-- Step 1 -->
             <div class="reg-form">
                <div class="form-object"> <label>Image</label>
                <div class="input_fields">
                <div class="upload"><div class="fakeupload">
                <?php echo $this->Form->input('fakeupload',array('type'=>'text','name'=>'fakeupload','div'=>false,'label'=>false)) ?><!-- browse button is here as background --></div> <?php echo $this->Form->input('image',array('type'=>'file','id'=>'realupload','onchange'=>'this.form.fakeupload.value = this.value;','div'=>false,'label'=>false,'class'=>'realupload')); ?></div></div></div>
                <div class="form-object" style="margin-bottom:20px"> <label>Window Title</label>
                <div class="input_fields"><?php echo $this->Form->input('winTitle',array('type'=>'text','div'=>false,'label'=>false)); ?></div>
                </div>
                <div class="form-object" style="margin-bottom:20px"> <label>Page Title</label>
                <div class="input_fields"><?php echo $this->Form->input('pageTitle',array('type'=>'text','div'=>false,'label'=>false)); ?><span style="margin-top:2px;color:green">Please do not remove &lt;span&gt; tags</span></div>
                </div>
                <div class="form-object" style="margin-bottom:20px"> <label>1st Title</label>
                <div class="input_fields"><?php echo $this->Form->input('firstTitle',array('type'=>'text','div'=>false,'label'=>false)); ?></div>
                </div>
                <div class="form-object" style="margin-bottom:20px"> <label>1st Description</label>
                <div class="input_fields"><?php echo $this->Form->input('firstDesc',array('type'=>'textarea','rows'=>'10','cols'=>'30','div'=>false,'label'=>false)); ?><span style="margin-top:2px;color:green">Add text in &lt;p&gt;&lt;/p&gt; tags to start a paragraph</span></div>
                </div>
                <div class="form-object" style="margin-bottom:20px"> <label>2nd Title</label>
                <div class="input_fields"><?php echo $this->Form->input('secondTitle',array('type'=>'text','div'=>false,'label'=>false)); ?></div>
                </div>
                <div class="form-object" style="margin-bottom:20px"> <label>2nd Description</label>
                <div class="input_fields"><?php echo $this->Form->input('secondDesc',array('type'=>'textarea','rows'=>'10','cols'=>'30','div'=>false,'label'=>false)); ?></div>
                </div>
                <div class="form-object" style="margin-bottom:20px"> <label>3rd Title</label>
                <div class="input_fields"><?php echo $this->Form->input('thirdTitle',array('type'=>'text','div'=>false,'label'=>false)); ?></div>
                </div>
                <div class="form-object" style="margin-bottom:20px"> <label>3rd Description</label>
                <div class="input_fields"><?php echo $this->Form->input('thirdDesc',array('type'=>'textarea','rows'=>'10','cols'=>'30','div'=>false,'label'=>false)); ?></div>
                </div>
                <div class="form-object" style="margin-bottom:20px"> <label>4th Title</label>
                <div class="input_fields"><?php echo $this->Form->input('fourthTitle',array('type'=>'text','div'=>false,'label'=>false)); ?></div>
                </div>
                <div class="form-object" style="margin-bottom:20px"> <label>4th Description</label>
                <div class="input_fields"><?php echo $this->Form->input('fourthDesc',array('type'=>'textarea','rows'=>'10','cols'=>'30','div'=>false,'label'=>false)); ?></div>
                </div>
                <div class="form-object" style="margin-bottom:20px"> <label>5th Title</label>
                <div class="input_fields"><?php echo $this->Form->input('fifthTitle',array('type'=>'text','div'=>false,'label'=>false)); ?></div>
                </div>
                <div class="form-object" style="margin-bottom:20px"> <label>5th Description</label>
                <div class="input_fields"><?php echo $this->Form->input('fifthDesc',array('type'=>'textarea','rows'=>'10','cols'=>'30','div'=>false,'label'=>false)); ?></div>
                </div>
                
                <div class="create_btn_wrap"><?php echo $this->Form->submit('Submit',array('class'=>'create_btn button_margin_left')); ?></div>
             </div>
             
               
           </div>
</div>
<?php echo $this->Form->end(); ?>
<script type="text/javascript">
jQuery('#frmSite').validate({
      errorElement : 'label',
      errorClass : 'regError',
      rules :{
        'data[Npo][image]':{
            accept: "gif|jpg|jpeg|png"
        }
      }
    });
</script>