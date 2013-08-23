<?php echo $this->Form->create('User',array('action'=>'login','id'=>'frmLogin','method'=>'post','onsubmit'=>'return chkPost()')); ?><header id="header">
      <section id="top-header">
         <section id="topheader_wrap">
          <section id="header_left">
          <div id="logo"><?php echo $this->Html->link($this->Html->image('/img/logo.png',array('title'=>'BrightnFP.com')),'/',array('escape'=>false)); ?></div></section>
          <section id="header_right">
          <?php 
          $npoLog     = $this->Session->read('SESSION_USER.Npo');
          $memberLog  = $this->Session->read('SESSION_USER.Member');
          if(isset($npoLog) && !empty($npoLog)){?>
            <div id="welcome">Welcome <?php echo $this->Html->link($npoLog['email'],'/npo/npodashboard');  ?>| <?php echo $this->Html->link('Logout','/users/logout',array('class'=>'logout')); ?></div>            
           <?php }elseif(isset($memberLog) && !empty($memberLog)){ ?>
            <div id="welcome">Welcome <?php echo $this->Html->link($memberLog['email'],'/members/memberdashboard');  ?>| <?php echo $this->Html->link('Logout','/users/logout',array('class'=>'logout')); ?></div>           
          <?php }else{ ?>
           <span id="already_reg"></span>
            <div id="login_panel">
              <label class="label">Username</label>   <div class="textbox"><?php echo $this->Form->input('username',array('id'=>'username','type'=>'text','div'=>false,'label'=>false)); ?></div>
              <label class="label">Password</label>   <div class="textbox"><?php echo $this->Form->input('password',array('id'=>'password','type'=>'password','label'=>false,'div'=>false)); ?></div>
              <button class="signin_btn"></button>
              <div class="login_options"> <p>
               Member<?php
                 echo $this->Form->input('type',array('type'=>'radio','options'=>array('member'=>''),'div'=>false,'label'=>false,'hiddenField'=>false,'class'=>'radio_btn'));
               ?></p>
              <p>Npo <?php 
                echo $this->Form->input('type',array('type'=>'radio','options'=>array('npo'=>''),'div'=>false,'label'=>false,'hiddenField'=>false,'checked'=>true,'class'=>'radio_btn'));
                ?></p>
               
               </div>
              <span class="forgotspan"><?php echo $this->Html->link('Forgot Password ?','/users/forgotpassword',array('style'=>'color:#FFFFFF')); ?><br />Register
              <?php echo $this->Html->link('NPO','/registrations',array('class'=>'register_link')); ?>|<?php echo $this->Html->link('Member','/registrations/registration_member',array('class'=>'register_link')); ?>
              </span>
              
           </div>
           <?php } ?>
            <nav id="nav">
            	<ul>
                	  <li class="about"><?php echo $this->Html->link(__('ABOUT_US'),'#'); ?></li>
                    <li class="non-profit"><?php echo $this->Html->link(__('FOR_NON_PROFIT'),'#'); ?></li>
                    <li class="formembers"><?php echo $this->Html->link(__('MEMBERS'),'#'); ?></li>
		                <li class="contact"><?php echo $this->Html->link(__('CONTACT_US'),'/contacts/'); ?></li>
                </ul>
              </nav>
           </section>
         </section>
      </section>
      <div align="center">
        				<?php if($this->Session->check('Message.flash')){ ?>
        					<div align="center" class="messageBlock">
        						<?php echo $this->Session->flash();?>
        					</div>
        					<?php
        				}?>
</div>
</header>
<?php echo $this->Form->end();
 ?>
<script type="text/javascript">
  jQuery('[type="radio"]').click(function (){
    var obj = jQuery(this);
    var id  = jQuery(this).attr('id');
      if(id == 'UserTypeNpo'){
        jQuery('#frmLogin').attr('action','/users/login');
      }else if(id == 'UserTypeMember'){
        jQuery('#frmLogin').attr('action','/users/member_login');
      }
  });
  function chkPost(){
    if(jQuery.trim(jQuery('#username').val()) ===''){
      jAlert('Please enter your username','Username Required');
      return false;
    }
    if(jQuery.trim(jQuery('#password').val()) ===''){
      jAlert('Please enter your password', 'Password Required');
      return false;
    }
  }
</script>