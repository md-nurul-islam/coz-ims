<?php
/* @var $this CategoryController */
/* @var $model CategoryDetails */

$this->breadcrumbs=array(
	'Category List'=>array('index'),
	'Add',
);

$this->menu = Ims_menu::$product_menu;
?>

<h1>Add Category</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>