<?php
/* @var $this CategoryController */
/* @var $model CategoryDetails */

$this->breadcrumbs=array(
	'Category Details'=>array('index'),
	'List',
);

$this->menu = Ims_menu::$product_menu;

/* Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#category-details-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
"); */
?>

<h1>Category List</h1>

<?php // echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php
    /* $this->renderPartial('_search',array(
    	'model'=>$model,
    )); */
?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'category-details-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'category_name',
		'category_description',
		array(
			'class'=>'CButtonColumn',
            'template' => '{view} {update}'
		),
	),
)); ?>
