<?php
/* @var $this ProductStockAvailController */
/* @var $model ProductStockAvail */
/* @var $form CActiveForm */
$this->menu = Ims_menu::$product_menu;
?>

<div class="form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'product-stock-avail-update_stock-form',
        // Please note: When you enable ajax validation, make sure the corresponding
        // controller action is handling ajax validation correctly.
        // See class documentation of CActiveForm for details on this,
        // you need to use the performAjaxValidation()-method described there.
        'enableAjaxValidation' => false,
    ));
    ?>
    <p class="note">Fields with <span class="required">*</span> are required.</p>

    <?php echo $form->errorSummary($model); ?>

    <?php if (Yii::app()->user->hasFlash('success')): ?>
        <div class="successMessage">
            <?php echo Yii::app()->user->getFlash('success'); ?>
        </div>
    <?php endif; ?>
    

    <div class="row">
        <?php echo $form->labelEx($model, 'product_details_id'); ?>
        <?php echo $form->hiddenField($model, 'product_details_id'); ?>
        <?php echo CHtml::textField('product_name', $model->productDetails->product_name, array('readonly' => true)); ?>
        <?php echo $form->error($model, 'product_details_id'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'quantity'); ?>
        <?php echo $form->textField($model, 'quantity'); ?>
        <?php echo $form->error($model, 'quantity'); ?>
    </div>


    <div class="row buttons">
        <?php echo CHtml::submitButton('Submit', array('id' => 'btn-submit')); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->