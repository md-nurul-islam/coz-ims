<?php
/* @var $this PurchaseController */
/* @var $model ProductStockEntries */

$this->breadcrumbs=array(
    'Purchase List'=>array('index'),
    'Purchase',
);

$this->menu = Ims_menu::$purchase_menu;
?>

<h1>Purchase Product</h1>

<?php $this->renderPartial('_form_single', array('model'=>$model, 'ar_cart'=>$ar_cart)); ?>