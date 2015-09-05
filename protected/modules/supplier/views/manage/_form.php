<?php
/* @var $this ManageController */
/* @var $model SupplierDetails */
/* @var $form CActiveForm */
?>

<div class="form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'supplier-details-form',
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
        <?php echo $form->labelEx($model, 'supplier_name'); ?>
        <?php echo $form->textField($model, 'supplier_name', array('size' => 60, 'maxlength' => 255)); ?>
        <?php echo $form->error($model, 'supplier_name'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'supplier_address'); ?>
        <?php echo $form->textArea($model, 'supplier_address', array('rows' => 6, 'cols' => 45)); ?>
        <?php echo $form->error($model, 'supplier_address'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'supplier_contact1'); ?>
        <?php echo $form->textField($model, 'supplier_contact1', array('size' => 60, 'maxlength' => 100)); ?>
        <?php echo $form->error($model, 'supplier_contact1'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'supplier_contact2'); ?>
        <?php echo $form->textField($model, 'supplier_contact2', array('size' => 60, 'maxlength' => 100)); ?>
        <?php echo $form->error($model, 'supplier_contact2'); ?>
    </div>

    <?php if ($show_balance) { ?>
        <div class="row">
            <?php echo $form->labelEx($model, 'balance'); ?>
            <?php echo $form->textField($model, 'balance', array('readonly' => true)); ?>
            <?php echo $form->error($model, 'balance'); ?>
        </div>
    <?php } ?>

    <div class="row buttons">
        <?php echo CHtml::submitButton(($model->isNewRecord) ? 'Add' : 'Update', array('id' => 'btn-submit') ); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->