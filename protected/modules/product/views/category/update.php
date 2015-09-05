<?php
/* @var $this CategoryController */
/* @var $model CategoryDetails */

$this->breadcrumbs=array(
	'Category List'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu = Ims_menu::$product_menu;
?>

<h1>Update Category</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>