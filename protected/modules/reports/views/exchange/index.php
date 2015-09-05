<?php
/* @var $this PurchaseController */
/* @var $model ProductStockEntries */

$this->breadcrumbs = array(
    'Product Exchange' => array('index'),
    'Exchange Report',
);

$this->menu = Ims_menu::$report_menu;
?>

<?php if (!$model_data) { ?>

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

    <?php if ($model_data) { ?>
        
        <div class="report_title">
            Exchange Report Starting from <?php echo $from_date; ?> till <?php echo $to_date; ?>
        </div>
        
        <div class="report_table">
            <table>
                <tbody>
                    <tr>
                        <th>Bill Number</th>
                        <!--<th>Ref. Number</th>-->
                        <th>Item</th>
                        <th>Quantity</th>
                        <!--<th>Price</th>-->
                        <th>Item Total</th>
                    </tr>
                    
                    <?php
                    $j = 0;
                    $num_records = sizeof($model_data);
                    
                    $grand_bill_total = 0.00;
                    $total_payable = 0.00;
                    $total_discount = 0.00;
                    $total_change = 0.00;
                    $total_adjust = 0.00;
                    
                    foreach ($model_data as $k => $v) {
                        
                        if(isset($v['ex_product'])){
                            $j++;
                            
                            $bill_total = $v['ex_product']['bill_total'];
                            $adjust = $v['ex_product']['adjust'];
                            $bill_total_1 = $bill_total + $adjust;

                            unset($v['ex_product']['bill_total']);
                            unset($v['ex_product']['adjust']);

                            $amount_given = $v['ex_product']['amount_given'];
                            unset($v['ex_product']['amount_given']);

                            $discount = $v['ex_product']['discount'];
                            unset($v['ex_product']['discount']);

                            $balance = $v['ex_product']['balance'];
                            unset($v['ex_product']['balance']);
                        }
                        
                    ?>
                    
                        <?php
                                $i = 0;
//                                echo $k.'<pre>';
//                                var_dump($v['main_product']);exit;
                                //$num_rows = sizeof($v['main_product']);
                                if(isset($v['ex_product'])){
                                    $num_rows = sizeof($v['main_product']) + sizeof($v['ex_product']);
                                }
                                
//                                echo $num_rows;exit;
                                ?>
                    <?php if(isset($v['ex_product'])){ ?>
                    
                        <tr>
                            <td rowspan="<?php echo $num_rows + 10; ?>"><?php echo $k; ?></td>
                        </tr>
                    
                        
                        <tr>
                            <td style="text-align: left; font-weight: bold;" rowspan="1" colspan="3">Returned Products</td>
                        </tr>
                        
                        <?php foreach ($v['main_product'] as $c) {
                            ?>
                    
                            <tr>
                                <td style="text-align: left;"><?php echo $c['prod_name']; ?></td>
                                <td><?php echo $c['qty']; ?></td>
                                <td><?php echo $c['item_sub_total']; ?></td>
                            </tr>
                        
                        <?php $i++; } ?>
                        
                            <tr>
                                <td style="text-align: right; font-weight: bold;" colspan="2">Adjustable Amount</td>
                                <td style="font-weight: bold;" colspan="1"><?php echo $adjust;?></td>
                            </tr>
                            
                            <tr>
                                <td style="text-align: left; font-weight: bold;" colspan="3">&nbsp;</td>
                            </tr>
                            
                            <tr>
                                <td style="text-align: left; font-weight: bold;" colspan="3">Exchanged Products</td>
                            </tr>
                            
                        <?php foreach ($v['ex_product'] as $c) { ?>
                    
                            <tr>
                                <td style="text-align: left;"><?php echo $c['prod_name']; ?></td>
                                <td><?php echo $c['qty']; ?></td>
                                <td><?php echo $c['item_sub_total']; ?></td>
                            </tr>
                        
                        <?php } ?>
                            
                            <tr>
                                <td colspan="2" style="text-align: right; font-weight: bold;">Bill</td>
                                <td style="font-weight: bold;"><?php echo number_format($bill_total_1, 2); ?></td>
                            </tr>
                        
                            <tr>
                                <td colspan="2" style="text-align: right; font-weight: bold;">Payable</td>
                                <td style="font-weight: bold;"><?php echo number_format($bill_total, 2); ?></td>
                            </tr>
                        
                            <tr>
                                <td colspan="2" style="text-align: right; font-weight: bold;">Discount</td>
                                <td style="font-weight: bold;"><?php echo number_format($discount, 2); ?></td>
                            </tr>
                        
                            <tr>
                                <td colspan="2" style="text-align: right; font-weight: bold;">Amount Given</td>
                                <td style="font-weight: bold;"><?php echo number_format($amount_given, 2); ?></td>
                            </tr>
                        
                            <tr>
                                <td colspan="2" style="text-align: right; font-weight: bold;">Change</td>
                                <td style="font-weight: bold;"><?php echo number_format($balance, 2); ?></td>
                            </tr>
                        
                    <?php
                            $grand_bill_total += $bill_total_1 + $discount;
                            $total_payable   += $bill_total;
                            $total_discount += $discount;
                            $total_change  += $balance;
                            $total_adjust  += $adjust;
                        }
                    ?>
                    <?php } ?>       
                                <tr><td colspan="4" style="border-bottom: none;">&nbsp;</td></tr>
                                <tr><td colspan="4" style="border-top: none;">&nbsp;</td></tr>

                                <tr>
                                    <td colspan="3" style="text-align: right;">Total Bill</td>
                                    <td><?php echo number_format($grand_bill_total, 2); ?></td>
                                </tr>
                                <tr>
                                    <td colspan="3" style="text-align: right;">Total Adjustable Amount</td>
                                    <td><?php echo number_format($total_adjust, 2); ?></td>
                                </tr>
                                <tr>
                                    <td colspan="3" style="text-align: right;">Total Payable</td>
                                    <td><?php echo number_format($total_payable, 2); ?></td>
                                </tr>
                                <tr>
                                    <td colspan="3" style="text-align: right;">Total Discount</td>
                                    <td><?php echo number_format($total_discount, 2); ?></td>
                                </tr>
                                <tr>
                                    <td colspan="3" style="text-align: right;">Total Change</td>
                                    <td><?php echo number_format($total_change, 2); ?></td>
                                </tr>
                    
                    
                    
                </tbody>
            </table>
        </div>
    <?php } ?>
    

<style type="text/css">
    
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