<div align="center">
<?php echo $this->Form->create(null,array('id'=>'frmForgot','name'=>'frmForgot','action'=>'admin_forgotpassword')); ?>
<table align="center" cellpadding="2" cellspacing="0" border="0" class="outerBorder">
    <tr>
      <td width="40%">&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td align="right"><strong><?php echo __('USERNAME'); ?>:</strong></td>
      <td><?php echo $this->Form->input('Admin.adminUserName',array('type'=>'text','id'=>'adminUserName','class'=>'required','div'=>false,'label'=>false)); ?></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>

    <tr>
      <td>&nbsp;</td>
      <td><?php echo $this->Form->submit('Send Request',array('type'=>'submit','id'=>'submit','value'=>'Login'));?> &nbsp; 
	<?php //echo $this->Html->link(__('Forgot Password'),array('controller'=>'users','action'=>'forgotpassword','admin'=>true)); ?></td>
    </tr>
</table>
<?php echo $this->Form->end(); ?>
</div>
<script type="text/javascript">
  jQuery(document).ready(function (){
    jQuery('#frmForgot').validate();
  });
</script>