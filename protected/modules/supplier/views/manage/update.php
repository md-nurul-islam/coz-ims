<?php
/* @var $this ManageController */
/* @var $model SupplierDetails */

$this->breadcrumbs = array(
    'Supplier List' => array('index'),
    $model->id => array('view', 'id' => $model->id),
    'Update Supplier',
);

$this->menu = Ims_menu::$supplier_menu;
?>

<h1>Update Supplier</h1>

<?php $this->renderPartial('_form', array('model' => $model, 'show_balance' => $show_balance,)); ?>