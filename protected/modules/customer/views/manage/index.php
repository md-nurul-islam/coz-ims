<?php
/* @var $this ManageController */
/* @var $model CustomerDetails */

$this->breadcrumbs = array(
    'Customer List' => array('index'),
);

$this->menu = Ims_menu::$customer_menu;

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#customer-details-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Customer List</h1>

<?php //echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<!--div class="search-form" style="display:none">
<?php
//$this->renderPartial('_search',array(
//	   'model'=>$model,
//    ));
?>
</div--><!-- search-form -->

<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'customer-details-grid',
    'dataProvider' => $model->search(),
    'filter' => $model,
    'columns' => array(
        'customer_name',
        'customer_address',
        'customer_contact1',
        'customer_contact2',
        array(
            'class' => 'CButtonColumn',
        ),
    ),
));
?>
