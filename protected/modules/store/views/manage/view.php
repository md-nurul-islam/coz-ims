<?php
/* @var $this ManageController */
/* @var $model StoreDetails */

$this->breadcrumbs=array(
	'Store Details'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List StoreDetails', 'url'=>array('index')),
	array('label'=>'Create StoreDetails', 'url'=>array('create')),
	array('label'=>'Update StoreDetails', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete StoreDetails', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage StoreDetails', 'url'=>array('admin')),
);
?>

<h1>View StoreDetails #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		'log',
		'type',
		'address',
		'place',
		'city',
		'phone',
		'email',
		'web',
		'pin',
	),
)); ?>
