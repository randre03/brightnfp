 <?php 
 echo $javascript->link(array('jquery-ui','jquery.ui.touch','QapTcha.jquery'));
 echo $this->Html->css('QapTcha.jquery');
 echo $this->Form->create('Member',array('method'=>'post','id'=>'frmMember','name'=>'frmMember','url'=>'/registrations/registration_member','enctype'=>'multipart/form-data')); 
  echo $this->Form->hidden('emailHid',array('id'=>'emailHid','value'=>0));
 ?>
 
 <div class="register_form">
           <!-- Step 1 -->
             <h1 class="step1">Set up your account</h1>
             <div class="reg-form">
                <div class="form-object"> 
                <label>Email Address</label>
                <div class="input_fields"><?php echo $this->Form->input('email',array('type'=>'text','id'=>'usrMail','class'=>'required email','div'=>false,'label'=>false,'onBlur'=>'return  chkField("email",this,"Member")')); ?>
                <span style="line-height:30px;" id="email"></span></div>
                </div>
                <div class="form-object"> 
                  <label>Password</label>
                  <div class="input_fields"><?php echo $this->Form->input('usrPassword',array('type'=>'password','id'=>'usrPassword','class'=>'required','div'=>false,'label'=>false,'minlength' =>'6')); ?></div>
                  </div>
                <div class="form-object"> 
                <label>Confirm Password</label>
                <div class="input_fields"><?php echo $this->Form->input('confPassword',array('type'=>'password','id'=>'confPassword','div'=>false,'label'=>false)); ?>
                <div id="confPwd" class="error"></div>
                </div>
                </div>
                <div class="form-object"> 
                <label>Name</label>
                <div class="input_fields"><?php echo $this->Form->input('usrName',array('type'=>'text','id'=>'confPassword','div'=>false,'label'=>false,'class'=>'required')); ?>
                
                </div>
                </div>
                <div class="form-object"> 
                <label>Something about yourself</label>
                <div class="input_fields"><?php echo $this->Form->input('description',array('type'=>'textarea','id'=>'description','rows'=>'15','cols'=>'53','div'=>false,'label'=>false)); ?>
                
                </div>
                </div>
                <div class="form-object QapTcha"> 
                </div>
             </div>
             <div class="tootip_wrap">
              <div class="tooltip"><span>Your email address will serve as your login.  Don't worry, we don't spam.</span></div>
             </div>
             
             <div class="select_page" style="width:100%">
                
                <span class="agree"><?php echo $this->Form->input('agree',array('type'=>'checkbox','div'=>false,'label'=>false,'legend'=>'false')); ?>I Agree To The Terms Of Service </span>
             </div>
               <div class="create_btn_wrap" style="text-align:center;"><?php echo $this->Form->submit('Sign Up',array('class'=>'create_btn')); ?></div>
           </div>
         <?php echo $this->Form->end(); ?>  
<!-- Container Ends -->
<script type="text/javascript">
  jQuery(document).ready(function (){
    jQuery('.QapTcha').QapTcha({}); 
    jQuery('#usrMail').keypress(function (){
         jQuery('#email').html('');
    });
    jQuery('#frmMember').validate({
      errorElement : 'label',
      errorClass : 'regError'
      }
    );
    jQuery('#frmMember').submit(function (){
      if(jQuery('#usrPassword').val() !== jQuery('#confPassword').val()){
        jQuery('#confPwd').html('Password and confirm password do not match');
        jQuery('#confPassword').focus();
        return false;
      }else{
        jQuery('#confPwd').html('');
      }
      if(jQuery('#tmpltId').val() == 0 || jQuery('#themeId').val() == 0){
        jQuery('#templtError').html('Please select a template and a theme.');        
        return false;
      }else{
        jQuery('#templtError').html('');    
      }
      if(!jQuery('#MemberAgree').is(':checked')){     
        jAlert('Please check terms of services', 'Acceptence Required');
        return false;
      }
      if(jQuery('#emailHid').val() == 0){        
        return true;
      }else{
        return false;
      }
    });
  });
  function chkField(field,str,model){
    var val = str.value;
    if(val !== ''){
      if(field == 'email'){
          var flag = 0;
          if(jQuery('#frmMember').validate().element('#usrMail')){
              var flag = 1;
          }
      }else{
        var flag = 1;
      }
      if(flag ==1){
          jQuery.ajax({
                 url: '/registrations/chkDuplicate',
                 data: 'value='+val+'&field='+field+'&model='+model,
                 success : function(text){    
                    jQuery('#'+field).html('');
                    if(text === 'ok'){
                      jQuery('#'+field+'Hid').val(0);
                      jQuery('#'+field).removeAttr('class');
                      jQuery('#'+field).addClass('successSpan');
                      jQuery('#'+field).append('<img src="/img/tick.gif?a=<?php echo time(); ?>" />'+field.charAt(0).toUpperCase()+field.slice(1)+'&nbsp;'+val +' is available');
                    }else{
                      jQuery('#'+field+'Hid').val(1);
                      jQuery('#'+field).removeAttr('class');
                      jQuery('#'+field).addClass('errorSpan');
                      jQuery('#'+field).append('<img src="/img/cross.gif?a=<?php echo time(); ?>" />'+field.charAt(0).toUpperCase()+ field.slice(1)+'&nbsp;'+val +' is unavailable');            
                    }
                 }
              });
     }
    }else{    
      jQuery('#'+field).html('');
    }
  }
</script>