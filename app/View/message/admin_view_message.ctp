<div align="center">
<table cellpadding="0" cellspacing="4" class="msgtable">
<?php if($type =='adminInbox'){ ?>
  <tr>
    <td colspan="2" align="right"><?php echo $this->Html->link($this->Html->image('reply_icon.gif',array('alt'=>__('REPLY'),'title'=>__('REPLY'))).' Reply',array('controller'=>'message','action'=>'compose',$message['Message']['id'],'adminInbox'),array('escape'=>false)); ?></td>
  </tr>
  <?php } ?>
  <tr>
    <td><strong><?php echo __('FROM'); ?>:</strong></td>
    <td><?php echo $message['Npo']['email']; ?></td>
  </tr>
  <tr>
    <td><strong><?php echo __('SUBJECT'); ?>:</strong></td>
    <td><?php echo $message['Message']['subject']; ?></td>
  </tr>
  <tr>
    <td valign="top"><strong><?php echo __('MESSAGE'); ?>:</strong></td>
    <td><?php echo $message['Message']['message']; ?></td>
  </tr>
  <?php if($type !== 'adminInbox'){ ?>
  <tr>
    <td valign="top"><strong><?php echo __('HAS_BEEN_READ_BY_RECIPENT'); ?>:</strong></td>
    <td><?php echo $message['Message']['read']; ?></td>
  </tr>
  <tr>
    <td valign="top"><strong><?php echo __('READ_ON'); ?>:</strong></td>
    <td><?php echo $message['Message']['read'] === 'Yes'? date('d/m/Y',strtotime($message['Message']['modified'])) : 'N/A ' ?></td>
  </tr>
  <?php } ?>
  <tr>
    <td valign="top"><strong><?php echo __('SENT_ON'); ?>:</strong></td>
    <td><?php echo date(Configure::read('adminDateFormat'),strtotime($message['Message']['created'])); ?></td>
  </tr>
</table>
</div>