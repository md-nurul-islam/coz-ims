<?php
/* @var $this ManageController */
/* @var $model ProductDetails */
/* @var $form CActiveForm */
?>

<div class="wide form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
    ));
    ?>

    <div class="row">
        <?php echo $form->label($model, 'category_id'); ?>
        <?php echo $form->textField($model, 'category_id'); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model, 'supplier_id'); ?>
        <?php echo $form->textField($model, 'supplier_id'); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model, 'product_name'); ?>
        <?php echo $form->textField($model, 'product_name', array('size' => 60, 'maxlength' => 255)); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model, 'purchase_price'); ?>
        <?php echo $form->textField($model, 'purchase_price', array('size' => 12, 'maxlength' => 12)); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model, 'selling_price'); ?>
        <?php echo $form->textField($model, 'selling_price', array('size' => 12, 'maxlength' => 12)); ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton('Search'); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- search-form -->