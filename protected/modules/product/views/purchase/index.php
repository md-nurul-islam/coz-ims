<?php
/* @var $this PurchaseController */
/* @var $model ProductStockEntries */

$this->breadcrumbs = array(
    'Product Purchase' => array('index'),
    'Purchase List',
);

$this->menu = Ims_menu::$purchase_menu;

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
    $('.search-form').toggle();
    return false;
});
$('.search-form form').submit(function(){
    $('#product-stock-entries-grid').yiiGridView('update', {
            data: $(this).serialize()
    });
    return false;
});
");
?>

<h1>Purchase List</h1>

<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'product-stock-entries-grid',
    'dataProvider' => $model->purchaseList(),
    'filter' => $model,
    'columns' => array(
        array(
            'name' => 't.id',
            'value' => '$data->id',
            'filter' => CHtml::activeTextField($model, 'id'),
        ),
        array(
            'name' => 'product_name',
            'value' => '$data->productDetails->product_name',
            'filter' => CHtml::activeTextField($model, 'product_name'),
            'htmlOptions' => array('width' => '700px'),
        ),
        array(
            'name' => 't.grand_total_paid',
            'value' => '$data->grand_total_paid',
            'filter' => CHtml::activeTextField($model, 'grand_total_paid'),
        ),
        array(
            'class' => 'CButtonColumn',
            'template' => '{view}',
            'header' => CHtml::dropDownList('pageSize', $pageSize, array(10 => 10, 20 => 20, 50 => 50, 100 => 100), array(
                'onchange' => "$.fn.yiiGridView.update('product-stock-entries-grid',{ data:{pageSize: $(this).val() }})",
            )),
        ),
    ),
));
?>
