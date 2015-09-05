<?php
/* @var $this ManageController */
/* @var $model StoreDetails */
/* @var $form CActiveForm */
?>

<div class="form" style="width: 390px">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'store-details-form',
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
        <?php echo $form->labelEx($model, 'name'); ?>
        <?php echo $form->textField($model, 'name', array('size' => 60, 'maxlength' => 100)); ?>
        <?php echo $form->error($model, 'name'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'address'); ?>
        <?php echo $form->textField($model, 'address', array('size' => 60, 'maxlength' => 100)); ?>
        <?php echo $form->error($model, 'address'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'place'); ?>
        <?php echo $form->textField($model, 'place', array('size' => 60, 'maxlength' => 100)); ?>
        <?php echo $form->error($model, 'place'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'city'); ?>
        <?php echo $form->textField($model, 'city', array('size' => 60, 'maxlength' => 100)); ?>
        <?php echo $form->error($model, 'city'); ?>
    </div>

    <div class="form-submit-btn">
        <button type="submit" id="btn-submit">Update</button>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->