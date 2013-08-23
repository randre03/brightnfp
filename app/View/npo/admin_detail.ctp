<?php echo $this->Html->css('style'); ?>
<table cellpadding="0" cellspacing="0" class="grid_widget">
  <thead>
  <tr class="even_col">
    <td class="a-center" colspan="2"><strong>Identification:</strong></td>
  </tr>
  </thead>
  <tbody>
  <?php if($detail['Npo']['taxid'] != ''){?>
    <tr><td>Tax Id:</td><td><?php echo $detail['Npo']['taxid']; ?></td></tr>
  <?php }else{ ?>
    <tr><td>Corporate Name:</td><td><?php echo $detail['Npo']['corporate_name']; ?></td></tr>
    <tr class="even_col"><td>Corporate Address:</td><td><?php echo $detail['Npo']['corporate_address']; ?></td></tr>
  <?php } ?></tbody>
</table>