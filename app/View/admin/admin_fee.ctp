<div align="center">
<?php echo $this->Form->create(null,array('id'=>'frmFee','name'=>'frmFee','action'=>'fee')); ?>
<table align="center" cellpadding="0" cellspacing="0" border="0" class="outerBorder">
    <tr>
      <td width="40%">&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td align="right"><strong><?php echo __('FEE'); ?></strong></td>
      <td><?php echo $this->Form->input('Fee.amount',array('type'=>'text','id'=>'amount','value'=>$fee['Fee']['amount'],'class'=>'required','div'=>false,'label'=>false)); ?></td>
    </tr>
    
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td><?php echo $this->Form->submit('submit',array('type'=>'submit','id'=>'submit','value'=>'Login'));?></td>
    </tr>
</table>
<?php echo $this->Form->end(); ?>
</div>
<script type="text/javascript">
  jQuery(document).ready(function (){
    jQuery('#frmFee').validate();
  });
</script>