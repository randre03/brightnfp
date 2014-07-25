<div class="paypalItems form">
<h1><?php __('Add/Edit PaypalItem');?></h1>
<?php echo $this->Form->create('PaypalItem');?>
	<fieldset>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('instant_payment_notification_id');
		echo $this->Form->input('item_name');
		echo $this->Form->input('item_number');
		echo $this->Form->input('quantity');
		echo $this->Form->input('mc_gross');
		echo $this->Form->input('mc_shipping');
		echo $this->Form->input('mc_handling');
		echo $this->Form->input('tax');
	?>
	</fieldset>
<?php echo $this->Form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('List PaypalItems'), array('action' => 'index'));?></li>
	</ul>
</div>
