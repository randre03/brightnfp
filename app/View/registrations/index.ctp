<script type="text/javascript">
    cache = new Array();
    function cacheImage(src){
        img = new Image();
        img.src = src;
        cache.push(img);
    }//ef
</script>
<?php 
  //echo $this->Html->css('captcha');
  //echo $javascript->link(array('jquery-ui.min','jquery.captcha'));
echo $this->Form->create('Npo',array('method'=>'post','id'=>'frmRegister','name'=>'frmRegister','url'=>'/registrations','enctype'=>'multipart/form-data')); 
  echo $this->Form->hidden('emailHid',array('id'=>'emailHid','value'=>0));
  echo $this->Form->hidden('addressHid',array('id'=>'addressHid','value'=>0));
  echo $this->Form->hidden('titleHid',array('id'=>'titleHid','value'=>0));
  echo $this->Form->hidden('templateId',array('id'=>'tmpltId','value'=>0));
  echo $this->Form->hidden('themeId',array('id'=>'themeId','value'=>0));
 ?>
 
 <div class="register_form">
           <!-- Step 1 -->
             <h1 class="step1">Set up your account</h1>
             <div class="reg-form">
                <div class="form-object"> 
                <label>Email Address</label>
                <div class="input_fields"><?php echo $this->Form->input('email',array('type'=>'text','id'=>'usrMail','class'=>'required email','div'=>false,'label'=>false,'onBlur'=>'return  chkField("email",this,"Npo")')); ?>
                <span style="line-height:30px;" id="email"></span></div>
                </div>
                <div class="form-object"> 
                  <label>Password</label>
                  <div class="input_fields"><?php echo $this->Form->input('password',array('type'=>'password','id'=>'usrPassword','class'=>'required','div'=>false,'label'=>false,'minlength' =>'6')); ?></div>
                  </div>
                <div class="form-object"> 
                <label>Confirm Password</label>
                <div class="input_fields"><?php echo $this->Form->input('confirmPassword',array('type'=>'password','id'=>'confPassword','div'=>false,'label'=>false)); ?>
                <div id="confPwd" class="error"></div>
                </div>
                </div>
                <div class="form-object"> 
                <label>Verification </label>
                <div class="input_fields"><?php echo $this->Form->input('verify',array('type'=>'radio','options'=>array('taxid'=>''),'div'=>false,'label'=>false,'legend'=>false,'hiddenField'=>false,'checked'=>true)); ?>
                <span style="float:left">Tax Id</span>  
                <?php echo $this->Form->input('verify',array('type'=>'radio','options'=>array('address'=>''),'div'=>false,'label'=>false,'legend'=>false,'hiddenField'=>false)); ?><span style="float:left">Address</span>              
                </div>
                </div>
                <div class="form-object" id="divCorptax"> 
                <label>TaxId</label>
                <div class="input_fields"><?php echo $this->Form->input('taxid',array('type'=>'text','id'=>'taxid','div'=>false,'label'=>false,'class'=>'required')); ?>
                </div>
                </div>
                <div class="form-object" id="divCorpname" style="display:none"> 
                <label>Corporate name</label>
                <div class="input_fields"><?php echo $this->Form->input('corpName',array('type'=>'text','id'=>'corpName','div'=>false,'label'=>false)); ?>               
                </div>
                </div>
                <div class="form-object" id="divCorpaddrs" style="display:none"> 
                <label>Corporate address</label>
                <div class="input_fields"><?php echo $this->Form->input('corpAddress',array('type'=>'textarea','id'=>'corpAddress','div'=>false,'label'=>false,'rows'=>'15','cols'=>'53')); ?>               
                </div>
                </div>
                <div class="form-object"> 
                <label>Site Address</label>
                <div class="input_fields"><?php echo $this->Form->input('siteAddress',array('class'=>'required','type'=>'text','id'=>'usrAddress','div'=>false,'label'=>false,'onBlur'=>'return  chkField("address",this,"Npo")')); ?>
                <span style="line-height:30px;" id="address"></span>
                </div>
                </div>
                <div class="form-object"> 
                  <label>Business Name</label>
                  <div class="input_fields"><?php echo $this->Form->input('title',array('class'=>'required','type'=>'text','div'=>false,'id'=>'usrTitle','label'=>false,'onBlur'=>'return  chkField("title",this,"Npo")')); ?>
                <span style="line-height:30px;" id="title"></span>
                </div>
                </div>
                <div class="form-object"> 
                <label>Image</label>
                <div class="input_fields">
                <div class="upload">
                  <div class="fakeupload">
                <?php echo $this->Form->input('fakeupload',array('type'=>'text','name'=>'fakeupload','div'=>false,'label'=>false)) ?><!-- browse button is here as background --></div> <?php echo $this->Form->input('image',array('type'=>'file','id'=>'realupload','onchange'=>'this.form.fakeupload.value = this.value;','div'=>false,'label'=>false,'class'=>'realupload')); ?></div>
               
                </div>
                </div>
                <div class="form-object"> <label>Description</label>
                <div class="input_fields"><?php echo $this->Form->input('description',array('class'=>'required','type'=>'textarea','rows'=>'15','cols'=>'53','div'=>false,'id'=>'usrDesc','label'=>false)); ?>
                
                </div>
                </div>
             </div>
             <div class="tootip_wrap">
              <div class="tooltip"><span>Your email address will serve as your login.  Don't worry, we don't spam.</span></div>
             </div>
            <!-- Step 2 -->
             <h1 class="step2">Select your Template<span class="side_text">Don't worry, you can change your template at any time.</span></h1>
             <?php if(isset($templates) && !empty($templates)){ ?>
             <span class="side_text2">Choose from our gallery of <?php echo count($templates); ?> professionally designed templates</span>
             <div class="select_template">
              <?php foreach($templates as $template){?>
               <div class="template_thumb">
               <div rel="divPanel" style="display:none" id="div_<?php echo $template['Template']['id']; ?>" class="overlay_wrap">
                  <span class="overlay_tick"></span>
                  <div class="overlay_bar">
                  <ul>
                    <?php 
                      if(isset($template['TemplateTheme'])){ 
                        foreach($template['TemplateTheme'] as $k=>$v){
                          //echo $this->Html->image('/templates/'.$template['Template']['name'].'/'.$v['name'].'/'.$v['image'],array('style'=>'display:none'));
                    ?>
                      <script type="text/javascript">
                        cacheImage('<?php echo '/templates/'.$template['Template']['name'].'/'.$v['name'].'/'.$v['image'];   ?>');
                      </script>
                   <li><?php echo $this->Html->link(null,'javascript:void(0)',array('class'=>'blue','rel'=>'templateTheme','themeId'=>$v['id'],'image'=>'/templates/'.$template['Template']['name'].'/'.$v['name'].'/'.$v['image'],'templateId'=>'tempImg_'.$template['Template']['id'])); ?></li>
                   <?php 
                        }
                   } ?>
                  </ul>
                  </div>
               </div>
                <?php echo $this->Html->image('/templates/'.$template['Template']['name'].'/'.$template['TemplateTheme'][0]['name'].'/'.$template['TemplateTheme'][0]['image'],array('tempId'=>$template['Template']['id'],'id'=>'tempImg_'.$template['Template']['id'],'rel'=>'templtImg','style'=>'cursor:pointer')); ?>
               </div>
               <?php } ?>
              
             <div style="width:100%;text-align:center" id="templtError" class="error"></div>
             </div>
               <?php }else{?>
                <div class="select_template">
                     <div style="font-weight:bold;text-align:center;font-size:14px">Sorry No template available right now,Please check back later.</div>
             </div>
               <?php } ?>
            <!-- Step 3 --> 
             <!--<h1 class="step3">Choose from your site<span class="side_text">You can add and delete pages at any time.</span></h1>
             <span class="side_text2">Recommended Pages</span>-->
             <div class="select_page" style="width:100%">
                <!--<ul>
                 <li id="home">
                   Home<br><?php echo $this->Form->input('home',array('type'=>'checkbox','checked'=>true,'disabled'=>true,'div'=>false,'label'=>false,'legend'=>'false','value'=>1)); ?>
                 </li>
                 <li id="about">
                   About us<br><?php echo $this->Form->input('about',array('type'=>'checkbox','div'=>false,'label'=>false,'legend'=>'false','value'=>2)); ?>
                 </li>
                 <li id="contact">
                   Contact us<br><?php echo $this->Form->input('contact',array('type'=>'checkbox','div'=>false,'label'=>false,'legend'=>'false','value'=>3)); ?>
                 </li>
                 <li id="store">
                   Web Store<br><?php echo $this->Form->input('store',array('type'=>'checkbox','div'=>false,'label'=>false,'legend'=>'false','value'=>4)); ?>
                 </li>
                 <li id="services">
                   Product and Services<br><?php echo $this->Form->input('services',array('type'=>'checkbox','div'=>false,'label'=>false,'legend'=>'false','value'=>5)); ?>
                 </li>
                 <li id="calender">
                   Calender<br><?php echo $this->Form->input('calender',array('type'=>'checkbox','div'=>false,'label'=>false,'legend'=>'false','value'=>6)); ?>
                 </li>
                 <li id="testimonial">
                   Testimonial<br><?php echo $this->Form->input('testimonial',array('type'=>'checkbox','div'=>false,'label'=>false,'legend'=>'false','value'=>7)); ?>
                 </li>
                 <li id="blog">
                  Blog <br><?php echo $this->Form->input('blog',array('type'=>'checkbox','div'=>false,'label'=>false,'legend'=>'false','value'=>8)); ?>
                 </li>
                  <li id="gallery">
                  Photogallery <br><?php echo $this->Form->input('gallery',array('type'=>'checkbox','div'=>false,'label'=>false,'legend'=>'false','value'=>9)); ?>
                 </li>
                </ul> -->
                <span class="agree"><?php echo $this->Form->input('agree',array('type'=>'checkbox','div'=>false,'label'=>false,'legend'=>'false')); ?>I Agree To The Terms Of Service </span>
             </div>
             <!--<div class="ajax-fc-container">You must enable javascript to see captcha here!</div>-->
             
               <div class="create_btn_wrap" style="text-align:center;"><?php echo $this->Form->submit('Create My Website',array('class'=>'create_btn')); ?></div>
           </div>
         <?php echo $this->Form->end(); ?>  
<!-- Container Ends -->
<script type="text/javascript">
  jQuery(document).ready(function (){
    jQuery('[type="radio"]').click(function (){
        var obj = jQuery(this);
        var id  = obj.attr('id');
        if(id == 'NpoVerifyTaxid'){
          jQuery('#taxid').addClass('required');
          jQuery('#corpName,#corpAddress').removeClass('required');
          jQuery('#divCorptax,#divCorpname,#divCorpaddrs').toggle();
        }else if(id == 'NpoVerifyAddress'){
          jQuery('#taxid').removeClass('required');
          jQuery('#corpName,#corpAddress').addClass('required');
          jQuery('#divCorptax,#divCorpname,#divCorpaddrs').toggle();
        }
    });
    jQuery('[rel="templtImg"]').click(function (){
        jQuery('[rel="divPanel"]').hide();
        var id = jQuery(this).attr('tempId');
        jQuery('#span_'+id).show();
        jQuery('#div_'+id).show();
        jQuery('#tmpltId').val(id);
    });
    jQuery('[rel="templateTheme"]').click(function (){
        var id = jQuery(this).attr('themeId');
        jQuery('.color_active').removeClass('color_active');
        jQuery(this).addClass('color_active');
        var tempId =  jQuery(this).attr('templateId');
        jQuery('#themeId').val(id);              
    }); 
    
    jQuery('[rel="templateTheme"]').mouseover(function (){
      var obj     = jQuery(this);
      var imgId   = obj.attr('templateId');
      var imgUrl  = obj.attr('image');
      jQuery('#'+imgId).attr('src',imgUrl);
    }); 
    jQuery('#usrMail').keypress(function (){
         jQuery('#email').html('');
    });
    jQuery('#usrTitle').keypress(function (){
         jQuery('#title').html('');
    });
    jQuery('#usrAddress').keypress(function (){
         jQuery('#address').html('');
    });
    jQuery('#frmRegister').validate({
      errorElement : 'label',
      errorClass : 'regError',
      rules :{
        'data[Npo][image]':{
           required: true,
            accept: "gif|jpg|jpeg|png"
        }
      }
    });
    jQuery('#frmRegister').submit(function (){
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
      if(!jQuery('#NpoAgree').is(':checked')){     
        jAlert('Please check terms of services', 'Acceptence Required');
        return false;
      }
      if(jQuery('#emailHid').val() == 0 && jQuery('#addressHid').val() == 0 && jQuery('#titleHid').val() == 0 ){        
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
          if(jQuery('#frmRegister').validate().element('#usrMail')){
              var flag = 1;
          }
      }else{
        var flag = 1;
      }
      if(field == 'address'){
        val = val.toLowerCase();
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
                    }else if(text === 'exists'){
                      jQuery('#'+field+'Hid').val(1);
                      jQuery('#'+field).removeAttr('class');
                      jQuery('#'+field).addClass('errorSpan');
                      jQuery('#'+field).append('<img src="/img/cross.gif?a=<?php echo time(); ?>" />'+field.charAt(0).toUpperCase()+ field.slice(1)+'&nbsp;'+val +' is unavailable');            
                    }else{
                      jQuery('#'+field+'Hid').val(1);
                      jQuery('#'+field).removeAttr('class');
                      jQuery('#'+field).addClass('errorSpan');
                      jQuery('#'+field).append('<img src="/img/cross.gif?a=<?php echo time(); ?>" />'+field.charAt(0).toUpperCase()+ field.slice(1)+'&nbsp;'+val +' is not subscribed.');        
                    
                    }
                 }
              });
     }
    }else{    
      jQuery('#'+field).html('');
    }
  }
</script>