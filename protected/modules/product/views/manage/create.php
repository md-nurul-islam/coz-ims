<?php
/* @var $this ManageController */
/* @var $model ProductDetails */

$this->breadcrumbs=array(
	'Product Details'=>array('index'),
	'Add',
);

$this->menu = Ims_menu::$product_menu;
?>

<h1>Add Product</h1>

<?php $this->renderPartial('_form', array('model'=>$model, 'category_name' => $category_name, 'supplier_name' => $supplier_name,)); ?>