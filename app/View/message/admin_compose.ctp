<?php echo $this->Form->create(null,array('action'=>'compose','method'=>'post','name'=>'frmMsg','id'=>'frmMsg')); ?>
<div align="center">
<table cellpadding="0" cellspacing="4" class="msgtable">
  <tr>
    <td><strong><?php echo __('TO'); ?>:</strong></td>
    <td><?php
      isset($selectedNpo) ? $selected = $selectedNpo : $selected = '';
     echo $this->Form->input('Message.to',array('type'=>'select','class'=>'required','style'=>'width:220px','options'=>$npos,'empty'=>'--Select One--','selected'=>$selected,'label'=>false,'div'=>false)); ?></td>
  </tr>
  <tr>
    <td><strong><?php echo __('SUBJECT'); ?>:</strong></td>
    <td><?php echo $this->Form->input('Message.subject',array('type'=>'text','class'=>'required','id'=>'subject','style'=>'width:200px','div'=>false,'label'=>false)); ?></td>
  </tr>
  <tr>
    <td valign="top"><strong><?php echo __('MESSAGE'); ?>:</strong></td>
    <td><?php echo $this->Form->input('Message.message',array('type'=>'textarea','class'=>'required','id'=>'message','rows'=>'11','cols'=>'40','div'=>false,'label'=>false)); ?></td>
  </tr>
  <tr>
    <td valign="top">&nbsp;</td>
    <td><?php echo $this->Form->submit('Send',array('value'=>'Send')); ?></td>
  </tr>
</table>
</div>
<?php echo $this->Form->end(); ?>
<script type="text/javascript">
  jQuery(document).ready(function (){
    jQuery('#frmMsg').validate();
  });
</script>