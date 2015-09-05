<?php
/* @var $this SaleController */
/* @var $data ProductStockSales */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('sales_id')); ?>:</b>
	<?php echo CHtml::encode($data->sales_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('transaction_id')); ?>:</b>
	<?php echo CHtml::encode($data->transaction_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('billnumber')); ?>:</b>
	<?php echo CHtml::encode($data->billnumber); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('customer_id')); ?>:</b>
	<?php echo CHtml::encode($data->customer_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('supplier_id')); ?>:</b>
	<?php echo CHtml::encode($data->supplier_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('category_id')); ?>:</b>
	<?php echo CHtml::encode($data->category_id); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('ref_num')); ?>:</b>
	<?php echo CHtml::encode($data->ref_num); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('product_details_id')); ?>:</b>
	<?php echo CHtml::encode($data->product_details_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('quantity')); ?>:</b>
	<?php echo CHtml::encode($data->quantity); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('item_selling_price')); ?>:</b>
	<?php echo CHtml::encode($data->item_selling_price); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('serial_num')); ?>:</b>
	<?php echo CHtml::encode($data->serial_num); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('sale_date')); ?>:</b>
	<?php echo CHtml::encode($data->sale_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('item_subtotal')); ?>:</b>
	<?php echo CHtml::encode($data->item_subtotal); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('discount_percentage')); ?>:</b>
	<?php echo CHtml::encode($data->discount_percentage); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('dis_amount')); ?>:</b>
	<?php echo CHtml::encode($data->dis_amount); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('tax')); ?>:</b>
	<?php echo CHtml::encode($data->tax); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('tax_dis')); ?>:</b>
	<?php echo CHtml::encode($data->tax_dis); ?>
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

	<b><?php echo CHtml::encode($data->getAttributeLabel('payment_method')); ?>:</b>
	<?php echo CHtml::encode($data->payment_method); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('note')); ?>:</b>
	<?php echo CHtml::encode($data->note); ?>
	<br />

	*/ ?>

</div>