<?php
/* @var $this ManageController */
/* @var $model CustomerDetails */
/* @var $form CActiveForm */
?>

<div class="form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'customer-details-form',
        // Please note: When you enable ajax validation, make sure the corresponding
        // controller action is handling ajax validation correctly.
        // There is a call to performAjaxValidation() commented in generated controller code.
        // See class documentation of CActiveForm for details on this.
        'enableAjaxValidation' => true,
    ));
    ?>

    <p class="note">Fields with <span class="required">*</span> are required.</p>

    <?php echo $form->errorSummary($model); ?>

    <div class="row">
        <?php echo $form->labelEx($model, 'customer_name'); ?>
        <?php echo $form->textField($model, 'customer_name', array('size' => 60, 'maxlength' => 200)); ?>
        <?php echo $form->error($model, 'customer_name'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'customer_address'); ?>
        <?php echo $form->textArea($model, 'customer_address', array('size' => 60, 'rows' => 4, 'cols' => 45, 'maxlength' => 500)); ?>
        <?php echo $form->error($model, 'customer_address'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'customer_contact1'); ?>
        <?php echo $form->textField($model, 'customer_contact1', array('size' => 60, 'maxlength' => 100)); ?>
        <?php echo $form->error($model, 'customer_contact1'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'customer_contact2'); ?>
        <?php echo $form->textField($model, 'customer_contact2', array('size' => 60, 'maxlength' => 100)); ?>
        <?php echo $form->error($model, 'customer_contact2'); ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Add' : 'Update', array('id' => 'btn-submit')); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->