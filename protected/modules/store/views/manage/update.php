<?php
/* @var $this ManageController */
/* @var $model StoreDetails */

$this->breadcrumbs = array(
    $model->name => array('update'),
    'Update',
);
?>

<h1>Update Store Details</h1>

<?php $this->renderPartial('_form', array('model' => $model)); ?>