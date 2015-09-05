<?php
/* @var $this ManageController */
/* @var $model ProductDetails */

$this->breadcrumbs=array(
	'Product List'=>array('index'),
);

$this->menu = Ims_menu::$product_menu;
?>

<h1>Product Details</h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		array(
            'name' => 'category_id',
            'value' => $model->category->category_name,
        ),
		array(
            'name' => 'supplier_id',
            'value' => $model->supplier->supplier_name,
        ),
		'product_name',
		'purchase_price',
		'selling_price',
	),
)); ?>
