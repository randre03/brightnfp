<?php echo $this->Form->create('Member',array('url'=>'/members/addmember','method'=>'post','id'=>'frmMember','name'=>'frmMember'));
      echo $this->Form->hidden('emailHid',array('id'=>'emailHid')); 
?><div id="container_left">
 <div class="register_form">
           <!-- Step 1 -->
             <div class="reg-form">
                <div class="form-object"> 
                  <label>Email</label>
                  <div class="input_fields"><?php echo $this->Form->input('email',array('id'=>'usrMail','type'=>'text','class'=>'required email','div'=>false,'label'=>false,'onBlur'=>'return  chkField("email",this,"Member")')); ?>
                <span style="line-height:30px;" id="email"></span>
                </div>
                </div>
                <div class="form-object"> 
                  <label>Name</label>
                  <div class="input_fields"><?php echo $this->Form->input('usrName',array('id'=>'usrName','type'=>'text','class'=>'required','div'=>false,'label'=>false)); ?></div></div>
                <div class="form-object"> 
                  <label>Password</label>
                  <div class="input_fields"><?php echo $this->Form->input('usrPassword',array('id'=>'usrPassword','type'=>'password','class'=>'required','div'=>false,'label'=>false,'minlength' =>'6')); ?></div></div>              
                <div class="form-object"> <label>Confirm Password</label>
                <div class="input_fields"><?php echo $this->Form->input('confPassword',array('id'=>'confPassword','type'=>'password','div'=>false,'label'=>false)); ?>
                <span style="line-height:30px;" id="confPwd"  class="regError"></span></div></div>
             </div>
             
               <div class="create_btn_wrap"><?php echo $this->Form->submit('Submit',array('class'=>'create_btn button_margin_left')); ?></div>
           </div>
</div>
<?php echo $this->Form->end(); ?>
<script type="text/javascript">
  jQuery(document).ready(function (){
    jQuery('#usrMail').keypress(function (){
         jQuery('#email').html('');
    });
    jQuery('#frmMember').validate({
      errorElement : 'label',
      errorClass : 'regError',
    });
    jQuery('#frmMember').submit(function (){
      if(jQuery('#usrPassword').val() !== jQuery('#confPassword').val()){
        jQuery('#confPwd').html('Password and confirm password do not match');
        jQuery('#confPassword').focus();
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