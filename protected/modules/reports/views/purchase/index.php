<?php
/* @var $this PurchaseController */
/* @var $model ProductStockEntries */

$this->breadcrumbs = array(
    'Product Purchase' => array('index'),
    'Purchase List',
);

$this->menu = Ims_menu::$report_menu;
?>

<?php if (!$model) { ?>

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

    <div class="left margin-right">
        <?php echo CHtml::label('From Date', 'from_date', array('style' => 'cursor: pointer;')); ?>
        <?php
        $this->widget('zii.widgets.jui.CJuiDatePicker', array(
            'name' => 'from_date',
            'value' => $today,
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
                'style' => 'cursor: pointer;',
                'readonly' => true,
            ),
        ));
        ?>

    </div>

    <div class="left margin-right">
        <?php echo CHtml::label('To Date', 'to_date', array('style' => 'cursor: pointer;')); ?>
        <?php
        $this->widget('zii.widgets.jui.CJuiDatePicker', array(
            'name' => 'to_date',
            'value' => $today,
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
                'style' => 'cursor: pointer;',
                'readonly' => true,
            ),
        ));
        ?>

    </div>

    <div class="row left submit-btn">
        <?php echo CHtml::submitButton('Generate', array('id' => 'btn-submit')); ?>
    </div>
    
    <?php $this->endWidget(); ?>
    
</div>
    
<?php } ?>

    <?php if ($model) { ?>
        
        <div class="report_title">
            Purchase Report Starting from <?php echo $from_date; ?> till <?php echo $to_date; ?>
        </div>
        
        <div class="report_table">
            <table>
                <tbody>
                    <tr>
                        <th>Bill Number</th>
                        <th>Ref. Number</th>
                        <th>Item</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Item Total</th>
                    </tr>
                    
                    <?php
                    $j = 0;
                    $num_records = sizeof($model);
                    
                    $total_amount   = 0.00;
                    $total_discount = 0.00;
                    $total_balance  = 0.00;
                    
                    foreach ($model as $k => $v) {
                        
                        $j++;
                        
                        $bill_total = $v[0]['bill_total'];
                        unset($v[0]['bill_total']);
                        
                        $amount_given = $v[0]['amount_given'];
                        unset($v[0]['amount_given']);
                        
                        $discount = $v[0]['discount'];
                        unset($v[0]['discount']);
                        
                        $balance = $v[0]['balance'];
                        unset($v[0]['balance']);
                        
                    ?>
                    
                        <?php
                                $i = 0;
                                $num_rows = sizeof($v[0]);
                                foreach ($v[0] as $c) {
                            ?>
                            
                            <tr>
                                <?php if($i == 0) { ?>
                                    <td rowspan="<?php echo $num_rows; ?>"><?php echo $k; ?></td>
                                <?php } ?>
                                
                                <td><?php echo $c['ref_num']; ?></td>
                                <td style="text-align: left;"><?php echo $c['prod_name']; ?></td>
                                <td><?php echo $c['qty']; ?></td>
                                <td><?php echo $c['price']; ?></td>
                                <td><?php echo $c['item_sub_total']; ?></td>
                                
                            </tr>
                        
                        <?php $i++; } ?>
                        
                        <tr>
                            <td colspan="5" style="text-align: right;">Bill Total</td>
                            <td><?php echo number_format($bill_total + $discount, 2); ?></td>
                        </tr>
                        <tr>
                            <td colspan="5" style="text-align: right;">Discount</td>
                            <td><?php echo number_format($discount, 2); ?></td>
                        </tr>
                        <tr>
                            <td colspan="5" style="text-align: right;">Balance</td>
                            <td><?php echo number_format($balance, 2); ?></td>
                        </tr>
                        
                        <?php if ($j < $num_records) { ?>
                        <tr><td colspan="6">&nbsp;</td></tr>
                        <?php } ?>
                    <?php
                        
                        $total_amount   += ($bill_total + $discount);
                        $total_discount += $discount;
                        $total_balance  += $balance;
                        
                        }
                    ?>
                    <tr><td colspan="6" style="border-bottom: none;">&nbsp;</td></tr>
                    <tr><td colspan="6" style="border-top: none;">&nbsp;</td></tr>
                    
                    <tr>
                        <td colspan="5" style="text-align: right;">Total Amount</td>
                        <td><?php echo number_format($total_amount); ?></td>
                    </tr>
                    <tr>
                        <td colspan="5" style="text-align: right;">Total Discount</td>
                        <td><?php echo number_format($total_discount, 2); ?></td>
                    </tr>
                    <tr>
                        <td colspan="5" style="text-align: right;">Total Balance</td>
                        <td><?php echo number_format($total_balance, 2); ?></td>
                    </tr>
                    
                    
                </tbody>
            </table>
        </div>
    <?php } ?>
    

<style>
    
    table, td, th {
        border: 1px solid #000;
        text-align: center;
    }
    .report_title {
        font-size: 18px;
        font-weight: bold;
        margin-left: auto;
        margin-right: auto;
        padding: 10px 0 30px;
        text-align: center;
        width: 90%;
    }
    .report_table {
        width: 90%;
        margin-left: auto;
        margin-right: auto;
        text-align: center;
    }
</style>