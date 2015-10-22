<?php
/* @var $this PurchaseController */
/* @var $model ProductStockEntries */
/* @var $form CActiveForm */
?>

<div class="wide form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'product-stock-entries-form',
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

        <div class="left">
            <?php echo $form->labelEx($model, 'billnumber'); ?>
            <?php echo $form->textField($model, 'billnumber', array('size' => 20, 'maxlength' => 120)); ?>
            <?php echo $form->error($model, 'billnumber'); ?>
        </div>

        <div class="left margin-right">
            <?php echo $form->labelEx($model, 'purchase_date'); ?>
            <?php
            $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                'name' => 'ProductStockEntries[purchase_date]',
                'value' => date('Y-m-d', Settings::getBdLocalTime()),
                'options' => array(
                    'dateFormat' => 'yy-mm-dd',
                    'showAnim' => 'blind', //'slide','fold','slideDown','fadeIn','blind','bounce','clip','drop'
                    'changeMonth' => true,
                    'changeYear' => true,
                    'yearRange' => '2000:2099',
                    'minDate' => '2000-01-01', // minimum date
                    'maxDate' => '2099-12-31', // maximum date
                    'monthNamesShort' => Settings::$_month_full_name_for_datepicker,
                ),
                'htmlOptions' => array(
                    'style' => '',
                    'readonly' => true,
                ),
            ));
            ?>
            <?php echo $form->error($model, 'purchase_date'); ?>
        </div>

    </fieldset>

    <fieldset>
        <div class="left margin-right-20">
            <?php echo $form->labelEx($model, 'product_details_id', array('class' => 'font-left', 'for' => 'product_details_id')); ?>
            <div class="clear"></div>
            <?php $product_name = ''; ?>
            <?php echo CHtml::hiddenField('product_details_id', '', array('size' => 30)); ?>
            <?php
            $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
                'name' => 'product_name',
                'value' => $product_name,
                'source' => $this->createUrl('/product/manage/autocomplete'),
                'options' =>
                array(
                    'minLength' => 1,
                    'showAnim' => 'fold',
                    'select' => "js:function(event, data) {
                                $('#product_details_id').val(data.item.id);
                            }",
                ),
                'htmlOptions' => array(
                    'size' => 28,
                    'placeholder' => 'Type Product Name..',
                ),
            ));
            ?>
        </div>

        <div class="left margin-right-20">
            <?php echo $form->labelEx($model, 'ref_num', array('class' => 'font-left', 'for' => 'ref_num')); ?>
            <div class="clear"></div>
            <?php echo CHtml::textField('ref_num', '', array('size' => 25, 'maxlength' => 150)); ?>
        </div>

        <div class="left margin-right-5">
            <?php echo $form->labelEx($model, 'quantity', array('class' => 'font-left', 'for' => 'quantity')); ?>
            <div class="clear"></div>
            <?php echo CHtml::textField('quantity', '', array('size' => 6)); ?>
        </div>

        <div class="left margin-right">
            <?php echo $form->labelEx($model, 'purchase_price', array('class' => 'font-left', 'for' => 'purchase_price')); ?>
            <div class="clear"></div>
            <?php echo CHtml::textField('purchase_price', '', array('size' => 7, 'maxlength' => 12)); ?>
        </div>

        <div class="left margin-right">
            <?php echo $form->labelEx($model, 'selling_price', array('class' => 'font-left', 'for' => 'selling_price')); ?>
            <div class="clear"></div>
            <?php echo CHtml::textField('selling_price', '', array('size' => 7, 'maxlength' => 12)); ?>
        </div>

        <div class="left margin-right-5">
            <?php echo CHtml::label('Avail Stock', 'avail_stock', array('class' => 'font-left', 'for' => 'item_subtotal')); ?>
            <div class="clear"></div>
            <?php echo CHtml::textField('avail_stock', '', array('maxlength' => 12, 'size' => 6, 'readonly' => true)); ?>
        </div>

        <div class="left">
            <?php echo $form->labelEx($model, 'item_subtotal', array('class' => 'font-left', 'for' => 'item_subtotal')); ?>
            <div class="clear"></div>
            <?php echo CHtml::textField('item_subtotal', '', array('maxlength' => 12, 'size' => 8)); ?>
        </div>
    </fieldset>

    <fieldset class="custom-color">

        <div class="row">
            <div class="left">
                <?php echo $form->labelEx($model, 'supplier_id'); ?>
                <?php $supplier_name = ''; ?>
                <?php echo $form->hiddenField($model, 'supplier_id'); ?>
                <?php
                $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
                    'name' => 'supplier_name',
                    'value' => $supplier_name,
                    'source' => $this->createUrl('/supplier/manage/autocomplete'),
                    'options' =>
                    array(
                        'minLength' => 1,
                        'showAnim' => 'fold',
                        'select' => "js:function(event, data) {
                                    $('#ProductStockEntries_supplier_id').val(data.item.id);
                                }",
                    ),
                    'htmlOptions' => array(
                        'size' => 20,
                        'placeholder' => 'Type Supplier Name..'
                    ),
                ));
                ?>
                <?php echo $form->error($model, 'supplier_id'); ?>
            </div>

            <div class="left">
                <?php echo $form->labelEx($model, 'grand_total_payable'); ?>
                <?php echo $form->textField($model, 'grand_total_payable'); ?>
                <?php echo $form->error($model, 'grand_total_payable'); ?>
            </div>

            <div class="left">
                <?php echo $form->labelEx($model, 'grand_total_paid'); ?>
                <?php echo $form->textField($model, 'grand_total_paid', array('size' => 12, 'maxlength' => 12)); ?>
                <?php echo $form->error($model, 'grand_total_paid'); ?>
            </div>

            <div class="left">
                <?php echo $form->labelEx($model, 'grand_total_balance'); ?>
                <?php echo $form->textField($model, 'grand_total_balance', array('size' => 12, 'maxlength' => 12, 'readonly' => true)); ?>
                <?php echo $form->error($model, 'grand_total_balance'); ?>
            </div>
        </div>

        <div class="row">
            <div class="left">
                <?php echo $form->labelEx($model, 'due_payment_date'); ?>
                <?php
                $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                    'name' => 'ProductStockEntries[due_payment_date]',
                    //'value'=> date('Y-m-d', Settings::getBdLocalTime()),
                    'options' => array(
                        'dateFormat' => 'yy-mm-dd',
                        'showAnim' => 'blind', //'slide','fold','slideDown','fadeIn','blind','bounce','clip','drop'
                        'changeMonth' => true,
                        'changeYear' => true,
                        'yearRange' => '2000:2099',
                        'minDate' => '2000-01-01', // minimum date
                        'maxDate' => '2099-12-31', // maximum date
                        'monthNamesShort' => Settings::$_month_full_name_for_datepicker,
                    ),
                    'htmlOptions' => array(
                        'style' => '',
                        'readonly' => true,
                    ),
                ));
                ?>
                <?php echo $form->error($model, 'due_payment_date'); ?>
            </div>

            <div class="left">
                <?php echo $form->labelEx($model, 'payment_type'); ?>
                <?php echo $form->dropDownList($model, 'payment_type', Settings::$_payment_types, array('style' => 'width: 92px;')); ?>
                <?php echo $form->error($model, 'payment_type'); ?>
            </div>

            <div class="left">
                <?php echo $form->labelEx($model, 'note'); ?>
                <?php echo $form->textArea($model, 'note', array('rows' => 6, 'cols' => 50)); ?>
                <?php echo $form->error($model, 'note'); ?>
            </div>

            <div class="row left submit-btn">
                <?php echo CHtml::submitButton($model->isNewRecord ? 'Purchase' : 'Update', array('id' => 'btn-submit')); ?>
            </div>
        </div>
    </fieldset>

    <?php $this->endWidget(); ?>

</div><!-- form -->

<script type="text/javascript">

    var prod_id = '';
    var prod_name = '';
    var reference_num = '';
    var qty = 0;
    var cost = 0.00;
    var price = 0.00;
    var sub_total = 0.00;
    var cur_stock = 0;
    var cart_div = 1;

    function get_subtotal() {

        if ($('#quantity').val() == '') {
            alert('Please Provide Quantity.');
            setTimeout(function () {
                $('#quantity').focus();
            }, 1);
            return false;
        }

        if ($('#purchase_price').val() == '') {
            alert('Please Provide Cost.');
            return false;
        }

        if ($('#selling_price').val() == '') {
            alert('Please Provide Selling Price.');
            return false;
        }

        cost = parseFloat($('#purchase_price').val());
        price = parseFloat($('#selling_price').val());
        qty = parseInt($('#quantity').val());

        if (qty <= 0) {
            alert('Please Provide Quantity.');
            setTimeout(function () {
                $('#quantity').focus();
            }, 1);
            return false;
        }

        if (cost <= 0.00) {
            alert('Invalid Cost.');
            return false;
        }

        if (price <= 0.00) {
            alert('Invalid Selling Price.');
            setTimeout(function () {
                $('#selling_price').focus();
            }, 1);
            return false;
        }

        if (price < cost) {
            alert('Selling Price Cannot be smaller than Cost.');
            setTimeout(function () {
                $('#selling_price').focus();
            }, 1);
            return false;
        }

        sub_total = parseFloat(qty * cost).toFixed(2);
        $('#item_subtotal').val(sub_total);

        return true;
    }

    function calculate_grand_total() {
        var grand_total = 0.00;

        grand_total = sub_total;
        $('#ProductStockEntries_grand_total_payable').val(grand_total);
        $('#ProductStockEntries_grand_total_paid').val(grand_total);
        return true;
    }

    function calculate_balance() {
        var paid = 0.00;
        var balance = 0.00;
        var grand_total = parseFloat($('#ProductStockEntries_grand_total_payable').val());

        paid = parseFloat($('#ProductStockEntries_grand_total_paid').val());

        if (paid <= 0) {
            alert('Paid should be larger Zero.');
            return false;
        }

        if (paid > grand_total) {
            alert('Paid amount should not be larger than Grand Total.');
            return false;
        }

        balance = grand_total - paid;
        balance = balance.toFixed(2);

        $('#ProductStockEntries_grand_total_balance').val(balance);
        return true;
    }

    $(document).ready(function () {

        $('#product-stock-entries-form').submit(function () {
            if ($('#product_details_id').length <= 0 || $('#supplier_name').val() == '') {
                return false;
            }
        });

        $('#ref_num').blur(function () {
            var ref_num = $(this).val();

            if (ref_num == '') {
                return false;
            }

            var prod_id = $('#product_details_id').val();

            $.ajax({
                url: 'product_stock_info',
                type: 'post',
                dataType: "json",
                data: {prod_id: prod_id, ref_num: ref_num},
                success: function (data) {
                    $('#purchase_price').val(data.cost);
                    $('#selling_price').val(data.price);
                    $('#avail_stock').val(data.cur_stock);
                },
                error: function (e) {

                }
            });

        });

        $('#selling_price').blur(function () {

            if (get_subtotal() == true) {
                calculate_grand_total();
            }

        });

        $(document).on('keyup', '#ProductStockEntries_grand_total_paid', function () {
            calculate_balance();
        });

    })
</script>