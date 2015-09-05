<?php
/* @var $this SaleController */
/* @var $model ProductStockSales */

$this->breadcrumbs = array(
    'Product Stock Sales' => array('index'),
    'Create',
);

$this->menu = Ims_menu::$exchange_menu;
?>

<h1>Exchange Product</h1>

<?php $this->renderPartial('_form', array('model' => $model,)); ?>