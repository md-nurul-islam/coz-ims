<?php
/* @var $this ManageController */
/* @var $model StoreDetails */

$this->breadcrumbs=array(
	'Store Details'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List StoreDetails', 'url'=>array('index')),
	array('label'=>'Manage StoreDetails', 'url'=>array('admin')),
);
?>

<h1>Create StoreDetails</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>