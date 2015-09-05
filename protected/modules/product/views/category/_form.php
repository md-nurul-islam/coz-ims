<?php
/* @var $this CategoryController */
/* @var $model CategoryDetails */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'category-details-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>true,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'category_name'); ?>
		<?php echo $form->textField($model,'category_name',array('size'=>60,'maxlength'=>120)); ?>
		<?php echo $form->error($model,'category_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'category_description'); ?>
		<?php echo $form->textArea($model,'category_description',array('size'=>60, 'rows' => 5, 'cols' => 45, 'maxlength'=>250)); ?>
		<?php echo $form->error($model,'category_description'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton( ($model->isNewRecord) ? 'Add' : 'Update', array('id' => 'btn-submit') ); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->