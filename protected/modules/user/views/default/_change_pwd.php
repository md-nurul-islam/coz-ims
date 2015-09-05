<?php
/* @var $this CategoryController */
/* @var $model CategoryDetails */
/* @var $form CActiveForm */
?>

<div class="form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'change-password-form',
        // Please note: When you enable ajax validation, make sure the corresponding
        // controller action is handling ajax validation correctly.
        // There is a call to performAjaxValidation() commented in generated controller code.
        // See class documentation of CActiveForm for details on this.
        'enableAjaxValidation' => true,
    ));
    ?>

    <p class="note">Fields with <span class="required">*</span> are required.</p>

    <?php echo $form->errorSummary($model); ?>
    
    <?php if (Yii::app()->user->hasFlash('success')) { ?>
        <div class="success">
            <?php echo Yii::app()->user->getFlash('success'); ?>
        </div>
    <?php } ?>

    <div class="row">
        <?php echo $form->labelEx($model, 'current_password'); ?>
        <?php echo $form->passwordField($model, 'current_password'); ?>
        <?php echo $form->error($model, 'current_password'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'new_password'); ?>
        <?php echo $form->passwordField($model, 'new_password'); ?>
        <?php echo $form->error($model, 'new_password'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'repeat_password'); ?>
        <?php echo $form->passwordField($model, 'repeat_password'); ?>
        <?php echo $form->error($model, 'repeat_password'); ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton(($model->isNewRecord) ? 'Add' : 'Update', array('id' => 'btn-submit')); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->