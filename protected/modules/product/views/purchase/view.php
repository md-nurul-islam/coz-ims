<?php
/* @var $this PurchaseController */
/* @var $model ProductStockEntries */

$this->breadcrumbs=array(
	'Product Stock Entries'=>array('index'),
	$model->id,
);

$this->menu = Ims_menu::$purchase_menu;
?>

<h1>View ProductStockEntries #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'purchase_id',
		'billnumber',
		'ref_num',
		'supplier_id',
		'category_id',
		'product_details_id',
		'quantity',
		'purchase_price',
		'selling_price',
		'purchase_date',
		'payment_type',
		'item_subtotal',
		'note',
		'grand_total_payable',
		'grand_total_paid',
		'grand_total_balance',
		'due_payment_date',
		'serial_num',
	),
)); ?>
