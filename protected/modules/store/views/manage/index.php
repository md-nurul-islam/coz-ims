<?php
/* @var $this ManageController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Store Details',
);

$this->menu=array(
	array('label'=>'Create StoreDetails', 'url'=>array('create')),
	array('label'=>'Manage StoreDetails', 'url'=>array('admin')),
);
?>

<h1>Store Details</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
