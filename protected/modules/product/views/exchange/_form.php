<?php
/* @var $this PurchaseController */
/* @var $model ExchangeProducts */
/* @var $form CActiveForm */
?>

<div class="wide form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'product-exchange-form',
        // Please note: When you enable ajax validation, make sure the corresponding
        // controller action is handling ajax validation correctly.
        // There is a call to performAjaxValidation() commented in generated controller code.
        // See class documentation of CActiveForm for details on this.
        'enableAjaxValidation' => false,
    ));
    ?>

    <p class="note">Fields with <span class="required">*</span> are required.</p>

    <?php if (Yii::app()->user->hasFlash('success')) { ?>
        <div class="success">
            <?php echo Yii::app()->user->getFlash('success'); ?>
        </div>
    <?php } ?>

    <?php echo $form->errorSummary($model); ?>
    
    <fieldset class="custom-color">

        <div class="row">
            <div class="left">
                <?php echo $form->labelEx($model, 'sales_id'); ?>
                <?php echo $form->textField($model, 'sales_id'); ?>
                <?php echo $form->error($model, 'sales_id'); ?>
            </div>
        </div>

    </fieldset>
    
    <div id="sale_list">
        
    </div>

    <?php $this->endWidget(); ?>
    <?php Yii::app()->clientScript->registerCoreScript('jquery'); ?>
</div><!-- form -->

<script type="text/javascript">

    function getSalesList(sales_id) {
        $.ajax({
            url: 'get_sales',
            type: 'post',
            data: {sales_id: sales_id},
            success: function(data) {
                $('#sale_list').html('');
                $('#sale_list').html(data);
                //console.log(data);
            },
            error: function() {

            }
        });
    }
    
    $(document).ready(function() {
        
        $('#product-exchange-form').submit(function(e) {
            e.preventDefault();
            return false;
        });
        
        $('#ExchangeProducts_sales_id').change(function() {
            getSalesList($(this).val());
        }); 
    })
</script>