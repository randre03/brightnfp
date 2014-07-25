<div class="instantPaymentNotifications view">
<h1><?php  __('InstantPaymentNotification');?></h1>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<?php foreach ($instantPaymentNotification['InstantPaymentNotification'] as $key => $value): ?>
			<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo $key; ?></dt>
			<dd<?php if ($i++ % 2 == 0) echo $class;?>>
				<?php echo $value; ?>
				&nbsp;
			</dd>
		<?php endforeach; ?>
	</dl>
</div>

<?php if(isset($instantPaymentNotification['PaypalItem']) && count($instantPaymentNotification['PaypalItem']) > 0): ?>
<div class="related">
  <a name="related"></a>
  <h1>Related Items</h1>
  <table cellpadding = "0" cellspacing = "0" width="100%">
    <tr>
      <th>Item Name</th>
      <th>Item Number</th>
      <th>Quantity</th>
      <th>Amount</th>
      <th>Actions</th>
    </tr>
  <?php foreach($instantPaymentNotification['PaypalItem'] as $item): ?>
    <tr>
      <td><?php echo $item['item_name']; ?></td>
      <td><?php echo $item['item_number']; ?></td>
      <td><?php echo $item['quantity']; ?></td>
      <td><?php echo $item['mc_gross']; ?></td>
      <td>
        <?php echo $this->Html->link('View', array('admin' => true, 'plugin' => 'paypal_ipn', 'controller' => 'paypal_items', 'action' => 'view', 'id' => $item['id']));  ?>
        <?php echo $this->Html->link('Edit', array('admin' => true, 'plugin' => 'paypal_ipn', 'controller' => 'paypal_items', 'action' => 'edit', 'id' => $item['id']));  ?>
        <?php echo $this->Html->link('Delete', array('admin' => true, 'plugin' => 'paypal_ipn', 'controller' => 'paypal_items', 'action' => 'delete', 'id' => $item['id']), null, "Are you sure?");  ?>
      </td>
    </tr>
  <?php endforeach; ?>
  </table>
</div>
<?php endif; ?>

<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('Edit InstantPaymentNotification'), array('action' => 'edit', $instantPaymentNotification['InstantPaymentNotification']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Delete InstantPaymentNotification'), array('action' => 'delete', $instantPaymentNotification['InstantPaymentNotification']['id']), null, sprintf(__('Are you sure you want to delete # %s?'), $instantPaymentNotification['InstantPaymentNotification']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List InstantPaymentNotifications'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New InstantPaymentNotification'), array('action' => 'add')); ?> </li>
	</ul>
</div>
