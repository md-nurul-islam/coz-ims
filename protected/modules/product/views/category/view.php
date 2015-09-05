<?php
/* @var $this CategoryController */
/* @var $model CategoryDetails */

$this->breadcrumbs=array(
	'Category Details'=>array('index'),
);

$this->menu = Ims_menu::$product_menu;
?>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'category_name',
		'category_description',
	),
)); ?>
