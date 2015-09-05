<?php
/* @var $this ManageController */
/* @var $model CustomerDetails */

$this->breadcrumbs = array(
    'Customer List' => array('index'),
);

$this->menu = Ims_menu::$customer_menu;
?>

<h1>Customer</h1>

<?php
$this->widget('zii.widgets.CDetailView', array(
    'data' => $model,
    'attributes' => array(
        'customer_name',
        'customer_address',
        'customer_contact1',
        'customer_contact2',
        'balance',
    ),
));
?>
