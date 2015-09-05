<?php
/* @var $this PurchaseController */
/* @var $model ProductStockEntries */

$this->breadcrumbs = array(
    'Exchange Product' => array('index'),
    'Exchange List',
);

$this->menu = Ims_menu::$exchange_menu;

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
    $('.search-form').toggle();
    return false;
});
$('.search-form form').submit(function(){
    $('#product-stock-exchange-grid').yiiGridView('update', {
            data: $(this).serialize()
    });
    return false;
});
");
?>

<h1>Exchange List</h1>

<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'product-stock-exchange-grid',
    'dataProvider' => $model->exchangeList(),
    'filter' => $model,
    'columns' => array(
        array(
            'name' => 't.id',
            'value' => '$data->id',
            'filter' => CHtml::activeTextField($model, 'id'),
        ),
//        array(
//            'name' => 'sold_item',
//            'value' => '$data->mainProductDetails->main_product_name',
//            'filter' => CHtml::activeTextField($model, 'main_product_name'),
//            'htmlOptions' => array('width' => '700px'),
//        ),
        array(
            'name' => 'exchanged_item',
            'value' => '$data->exchangeProductDetails->ex_product_name',
            'filter' => CHtml::activeTextField($model, 'ex_product_name'),
            'htmlOptions' => array('width' => '700px'),
        ),
        array(
            'name' => 't.grand_total_payable',
            'value' => '$data->grand_total_payable',
            'filter' => CHtml::activeTextField($model, 'grand_total_payable'),
        ),
        array(
            'class' => 'CButtonColumn',
            'template' => '{view}',
            'header' => CHtml::dropDownList('pageSize', $pageSize, array(10 => 10, 20 => 20, 50 => 50, 100 => 100), array(
                'onchange' => "$.fn.yiiGridView.update('product-stock-exchange-grid',{ data:{pageSize: $(this).val() }})",
            )),
        ),
    ),
));

