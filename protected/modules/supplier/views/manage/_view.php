<?php
/* @var $this ManageController */
/* @var $data SupplierDetails */
?>

<div class="view">

    <b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
    <?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id' => $data->id)); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('supplier_name')); ?>:</b>
    <?php echo CHtml::encode($data->supplier_name); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('supplier_address')); ?>:</b>
    <?php echo CHtml::encode($data->supplier_address); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('supplier_contact1')); ?>:</b>
    <?php echo CHtml::encode($data->supplier_contact1); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('supplier_contact2')); ?>:</b>
    <?php echo CHtml::encode($data->supplier_contact2); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('balance')); ?>:</b>
    <?php echo CHtml::encode($data->balance); ?>
    <br />


</div>