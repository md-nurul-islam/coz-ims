<?php
/* @var $this ManageController */
/* @var $model SupplierDetails */

$this->breadcrumbs = array(
    'Supplier Details' => array('index'),
    'Manage',
);

$this->menu = Ims_menu::$supplier_menu;

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#supplier-details-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Supplier List</h1>

<?php //echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
    <?php
    /* $this->renderPartial('_search',array(
      'model'=>$model,
      )); */
    ?>
</div><!-- search-form -->

<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'supplier-details-grid',
    'dataProvider' => $model->search(),
    'filter' => $model,
    'columns' => array(
        'supplier_name',
        'supplier_address',
        'supplier_contact1',
        'balance',
        array(
            'class' => 'CButtonColumn',
        ),
    ),
));
?>
