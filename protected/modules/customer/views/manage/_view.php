<?php
/* @var $this ManageController */
/* @var $data CustomerDetails */
?>

<div class="view">

    <b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
    <?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id' => $data->id)); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('customer_name')); ?>:</b>
    <?php echo CHtml::encode($data->customer_name); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('customer_address')); ?>:</b>
    <?php echo CHtml::encode($data->customer_address); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('customer_contact1')); ?>:</b>
    <?php echo CHtml::encode($data->customer_contact1); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('customer_contact2')); ?>:</b>
    <?php echo CHtml::encode($data->customer_contact2); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('balance')); ?>:</b>
    <?php echo CHtml::encode($data->balance); ?>
    <br />


</div>