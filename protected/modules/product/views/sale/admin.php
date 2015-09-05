<?php
/* @var $this SaleController */
/* @var $model ProductStockSales */

$this->breadcrumbs=array(
	'Product Stock Sales'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List ProductStockSales', 'url'=>array('index')),
	array('label'=>'Create ProductStockSales', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#product-stock-sales-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Product Stock Sales</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'product-stock-sales-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'sales_id',
		'transaction_id',
		'billnumber',
		'customer_id',
		'supplier_id',
		/*
		'category_id',
		'ref_num',
		'product_details_id',
		'quantity',
		'item_selling_price',
		'serial_num',
		'sale_date',
		'item_subtotal',
		'discount_percentage',
		'dis_amount',
		'tax',
		'tax_dis',
		'grand_total_payable',
		'grand_total_paid',
		'grand_total_balance',
		'due_payment_date',
		'payment_method',
		'note',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
