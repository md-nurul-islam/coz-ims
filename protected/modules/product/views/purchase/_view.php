<?php
/* @var $this PurchaseController */
/* @var $data ProductStockEntries */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('purchase_id')); ?>:</b>
	<?php echo CHtml::encode($data->purchase_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('billnumber')); ?>:</b>
	<?php echo CHtml::encode($data->billnumber); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ref_num')); ?>:</b>
	<?php echo CHtml::encode($data->ref_num); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('supplier_id')); ?>:</b>
	<?php echo CHtml::encode($data->supplier_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('category_id')); ?>:</b>
	<?php echo CHtml::encode($data->category_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('product_details_id')); ?>:</b>
	<?php echo CHtml::encode($data->product_details_id); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('quantity')); ?>:</b>
	<?php echo CHtml::encode($data->quantity); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('purchase_price')); ?>:</b>
	<?php echo CHtml::encode($data->purchase_price); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('selling_price')); ?>:</b>
	<?php echo CHtml::encode($data->selling_price); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('purchase_date')); ?>:</b>
	<?php echo CHtml::encode($data->purchase_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('payment_type')); ?>:</b>
	<?php echo CHtml::encode($data->payment_type); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('item_subtotal')); ?>:</b>
	<?php echo CHtml::encode($data->item_subtotal); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('note')); ?>:</b>
	<?php echo CHtml::encode($data->note); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('grand_total_payable')); ?>:</b>
	<?php echo CHtml::encode($data->grand_total_payable); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('grand_total_paid')); ?>:</b>
	<?php echo CHtml::encode($data->grand_total_paid); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('grand_total_balance')); ?>:</b>
	<?php echo CHtml::encode($data->grand_total_balance); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('due_payment_date')); ?>:</b>
	<?php echo CHtml::encode($data->due_payment_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('serial_num')); ?>:</b>
	<?php echo CHtml::encode($data->serial_num); ?>
	<br />

	*/ ?>

</div>