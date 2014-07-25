<div class="paypalItems index">
<h1><?php __('PaypalItems');?></h1>
<p>
<?php
echo $this->Paginator->counter(array(
'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%')
));
?></p>
<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $this->Paginator->sort('item_name');?></th>
	<th><?php echo $this->Paginator->sort('item_number');?></th>
	<th><?php echo $this->Paginator->sort('quantity');?></th>
	<th><?php echo $this->Paginator->sort('mc_gross');?></th>
	<th><?php echo $this->Paginator->sort('created');?></th>
	<th class="actions"><?php __('Actions');?></th>
</tr>
<?php
$i = 0;
foreach ($paypalItems as $paypalItem):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $paypalItem['PaypalItem']['item_name']; ?>
		</td>
		<td>
			<?php echo $paypalItem['PaypalItem']['item_number']; ?>
		</td>
		<td>
			<?php echo $paypalItem['PaypalItem']['quantity']; ?>
		</td>
		<td>
			<?php echo $this->Number->currency($paypalItem['PaypalItem']['mc_gross']); ?>
		</td>
		<td>
			<?php echo $this->Time->niceShort($paypalItem['PaypalItem']['created']); ?>
		</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $paypalItem['PaypalItem']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $paypalItem['PaypalItem']['id'])); ?>
			<?php echo $this->Html->link(__('Delete'), array('action' => 'delete', $paypalItem['PaypalItem']['id']), null, sprintf(__('Are you sure you want to delete # %s?'), $paypalItem['PaypalItem']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
</table>
</div>
<div class="paging">
	<?php echo $this->Paginator->prev('<< '.__('previous'), array(), null, array('class'=>'disabled'));?>
 | 	<?php echo $this->Paginator->numbers();?>
	<?php echo $this->Paginator->next(__('next').' >>', array(), null, array('class' => 'disabled'));?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('New PaypalItem'), array('action' => 'add')); ?></li>
	</ul>
</div>
