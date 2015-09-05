<?php
/* @var $this ManageController */
/* @var $model SupplierDetails */

$this->breadcrumbs = array(
    'Supplier List' => array('index'),
);

$this->menu = Ims_menu::$supplier_menu;
?>

<h1>Supplier Details</h1>

<?php
$this->widget('zii.widgets.CDetailView', array(
    'data' => $model,
    'attributes' => array(
        'supplier_name',
        'supplier_address',
        'supplier_contact1',
        'supplier_contact2',
        'balance',
    ),
));
?>
