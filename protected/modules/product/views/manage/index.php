<?php
/* @var $this ManageController */
/* @var $model ProductDetails */

$this->breadcrumbs = array(
    'Product List' => array('index'),
);

$this->menu = Ims_menu::$product_menu;
?>

<h1>Product List</h1>

<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'product-details-grid',
    'dataProvider' => $model->search(),
    'filter' => $model,
    'columns' => array(
        array(
            'name' => 'category_name',
            'value' => '$data->category->category_name',
            'htmlOptions' => array('width' => '120px'),
        ),
        array(
            'name' => 'supplier_id',
            'value' => '$data->supplier->supplier_name',
            'htmlOptions' => array('width' => '100px'),
        ),
        'product_name',
        array(
            'name' => 'current_stock',
            'value' => '$data->productStockAvails->quantity',
            'htmlOptions' => array('width' => '60px'),
        ),
        'purchase_price',
        'selling_price',
        array(
            'class' => 'CButtonColumn',
            'template' => '{view} {update} {stock}',
            'htmlOptions' => array('width' => '200px'),
            'buttons' => array
                (
                'view' => array
                    (
                    'label' => 'View',
                    'imageUrl' => Yii::app()->baseUrl . '/images/icons/view.png',
                    'url' => 'Yii::app()->createUrl("product/manage/view", array("id"=>$data->id))',
                ),
                'update' => array
                    (
                    'label' => 'Update',
                    'imageUrl' => Yii::app()->baseUrl . '/images/icons/update.png',
                    'url' => 'Yii::app()->createUrl("product/manage/update", array("id"=>$data->id))',
                ),
                'stock' => array
                    (
                    'label' => 'Update Stock',
                    'url' => 'Yii::app()->createUrl("product/manage/update_stock", array("id"=>$data->id))',
                    'visible' => 'Yii::app()->user->isSuperAdmin || Yii::app()->user->isStoreAdmin',
                ),
            ),
            'header' => CHtml::dropDownList('pageSize', $pageSize, array(10 => 10, 20 => 20, 50 => 50, 100 => 100), array(
                'onchange' => "$.fn.yiiGridView.update('product-details-grid',{ data:{pageSize: $(this).val() }})",
            )),
        ),
    ),
));
?>
