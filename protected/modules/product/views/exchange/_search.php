<?php
/* @var $this SaleController */
/* @var $model ProductStockSales */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'id'); ?>
		<?php echo $form->textField($model,'id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'sales_id'); ?>
		<?php echo $form->textField($model,'sales_id',array('size'=>15,'maxlength'=>15)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'transaction_id'); ?>
		<?php echo $form->textField($model,'transaction_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'billnumber'); ?>
		<?php echo $form->textField($model,'billnumber',array('size'=>60,'maxlength'=>150)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'customer_id'); ?>
		<?php echo $form->textField($model,'customer_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'supplier_id'); ?>
		<?php echo $form->textField($model,'supplier_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'category_id'); ?>
		<?php echo $form->textField($model,'category_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ref_num'); ?>
		<?php echo $form->textField($model,'ref_num',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'product_details_id'); ?>
		<?php echo $form->textField($model,'product_details_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'quantity'); ?>
		<?php echo $form->textField($model,'quantity'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'item_selling_price'); ?>
		<?php echo $form->textField($model,'item_selling_price',array('size'=>12,'maxlength'=>12)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'serial_num'); ?>
		<?php echo $form->textField($model,'serial_num'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'sale_date'); ?>
		<?php echo $form->textField($model,'sale_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'item_subtotal'); ?>
		<?php echo $form->textField($model,'item_subtotal',array('size'=>12,'maxlength'=>12)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'discount_percentage'); ?>
		<?php echo $form->textField($model,'discount_percentage',array('size'=>12,'maxlength'=>12)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'dis_amount'); ?>
		<?php echo $form->textField($model,'dis_amount',array('size'=>12,'maxlength'=>12)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'tax'); ?>
		<?php echo $form->textField($model,'tax',array('size'=>12,'maxlength'=>12)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'tax_dis'); ?>
		<?php echo $form->textArea($model,'tax_dis',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'grand_total_payable'); ?>
		<?php echo $form->textField($model,'grand_total_payable',array('size'=>12,'maxlength'=>12)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'grand_total_paid'); ?>
		<?php echo $form->textField($model,'grand_total_paid',array('size'=>12,'maxlength'=>12)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'grand_total_balance'); ?>
		<?php echo $form->textField($model,'grand_total_balance',array('size'=>12,'maxlength'=>12)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'due_payment_date'); ?>
		<?php echo $form->textField($model,'due_payment_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'payment_method'); ?>
		<?php echo $form->textField($model,'payment_method'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'note'); ?>
		<?php echo $form->textArea($model,'note',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->