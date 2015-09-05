<?php
/* @var $this SaleController */
/* @var $model ProductStockSales */

$this->breadcrumbs = array(
    'Product Sales' => array('index'),
);

$this->menu = Ims_menu::$sale_menu;
?>

<h1>Product Sales <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model' => $model, 'ar_cart'=>$ar_cart, 'edit' => $edit,)); ?>