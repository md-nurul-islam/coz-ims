<?php
/* @var $this ManageController */
/* @var $model CustomerDetails */

$this->breadcrumbs = array(
    'Customer List' => array('index'),
    'Update',
);

$this->menu = Ims_menu::$customer_menu;
?>

<h1>Update Customer</h1>

<?php $this->renderPartial('_form', array('model' => $model)); ?>