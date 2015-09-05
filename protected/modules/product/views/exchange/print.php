<?php
$this->breadcrumbs = array(
    'Product Sales' => array('index'),
    'Sales List',
);

$this->menu = Ims_menu::$exchange_menu;
?>

<div class="print" style="margin-left: auto; margin-right: auto; width: 50%;">

    <style type="text/css">
        table *{
            font-family: Tahoma, Arial, Times New Roman;
            font-size: 12px;
        }
        .head{
            margin-left: auto;
            margin-right: auto;
            width: 50%;
            text-align: center;
            font-weight: bold;
            font-size: 14px;
        }
        .bill-table{
            width: 100%;
        }
        .bill-print{
            border: 1px solid #000;
        }
        .bill-print thead th{
            background: transparent;
        }
        .td-top-border-1px{
            border-top: 1px solid #000;
        }
        .text-right-align{
            text-align: right;
        }
        .bold-font{
            font-weight: bold;
        }
    </style>
    
    <table class="bill-print" style="width: 300px;">

        <tr>
            <td colspan="2" class="head">
                <?php echo $store->name;?>
            </td>
        </tr>

        <tr>
            <td colspan="2" style="text-align: center;">
                <?php
                    echo $store->address.'<br />'.$store->place.', '.$store->city;
                ?>
            </td>
        </tr>

        <tr>
            <td colspan="2" style="text-align: center;">
                &nbsp;
            </td>
        </tr>

        <tr>
            <td style="text-align: right; width: 225px;">Date: </td>
            <td style="text-align: right; width: 75px;"><?php echo $model_ex['date']; ?></td>
        </tr>

        <tr>
            <td style="text-align: right">Bill No: </td>
            <td style="text-align: right"><?php echo $model_ex['bill_no']; ?></td>
        </tr>
        
        <tr>
            <td style="text-align: left; font-weight: bold; ">Returned Products</td>
        </tr>

        <?php
        $payable = $model_ex['g_total_payable'];
        $paid = $model_ex['g_total_paid'];
        $balance = $model_ex['g_total_balance'];
        $dis_amount = $model_ex['dis_amount'];
        $adjust = $model_ex['adjust'];

        unset($model_ex['bill_no']);
        unset($model_ex['date']);
        unset($model_ex['g_total_payable']);
        unset($model_ex['g_total_paid']);
        unset($model_ex['g_total_balance']);
        unset($model_ex['dis_amount']);
        unset($model_ex['adjust']);
        ?>

        <tr>
            <td colspan="2">
                <div class="bill-table">
                    <table class="bill-print" style="width: 300px;">
                        <thead>
                            <tr>
                                <th>
                                    SN.:
                                </th>
                                <th>
                                    Item:
                                </th>
                                <th>
                                    Qty:
                                </th>
<!--                                <th>
                                    Price:
                                </th>-->
                                <th>
                                    Total:
                                </th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            $i = 1;
                            foreach ($model_main as $row) {
                                ?>
                                <tr>
                                    <td>
                                        <?php echo $i; ?> 
                                    </td>
                                    <td>
                                        <?php echo $row['prod_name']; ?> 
                                    </td>
                                    <td>
                                        <?php echo $row['qty']; ?> 
                                    </td>
<!--                                    <td>
                                        <?php //echo $row['price']; ?> 
                                    </td>-->
                                    <td>
                                        <?php echo $row['sub_total']; ?> 
                                    </td>
                                </tr>
                                <?php
                                $i++;
                            }
                            ?>
                            <tr>
                                <td colspan="3" class="td-top-border-1px text-right-align bold-font">Total Return</td>
                                <td class="td-top-border-1px bold-font"><?php echo $adjust; ?></td>
                            </tr>
                            
                        </tbody>
                    </table>

                </div>
            </td>
        </tr>
        
        <tr>
            <td style="text-align: left; font-weight: bold; ">Exchanged Products</td>
        </tr>
        
        <tr>
            <td colspan="2">
                <div class="bill-table">
                    <table class="bill-print" style="width: 300px;">
                        <thead>
                            <tr>
                                <th>
                                    SN.:
                                </th>
                                <th>
                                    Item:
                                </th>
                                <th>
                                    Qty:
                                </th>
<!--                                <th>
                                    Price:
                                </th>-->
                                <th>
                                    Total:
                                </th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            $i = 1;
                            foreach ($model_ex as $row) {
                                ?>
                                <tr>
                                    <td>
                                        <?php echo $i; ?> 
                                    </td>
                                    <td>
                                        <?php echo $row['prod_name']; ?> 
                                    </td>
                                    <td>
                                        <?php echo $row['qty']; ?> 
                                    </td>
<!--                                    <td>
                                        <?php //echo $row['price']; ?> 
                                    </td>-->
                                    <td>
                                        <?php echo $row['sub_total']; ?> 
                                    </td>
                                </tr>
                                <?php
                                $i++;
                            }
                            ?>
                            <tr>
                                <td colspan="3" class="td-top-border-1px text-right-align bold-font">Total Bill</td>
                                <td class="td-top-border-1px bold-font"><?php echo number_format($payable + $adjust, 2); ?></td>
                            </tr>
                            <tr>
                                <td colspan="3" class="td-top-border-1px text-right-align bold-font">Total Payable</td>
                                <td class="td-top-border-1px bold-font"><?php echo $payable; ?></td>
                            </tr>
                            <tr>
                                <td colspan="3" class="td-top-border-1px text-right-align bold-font">Total Paid</td>
                                <td class="td-top-border-1px bold-font"><?php echo $paid; ?></td>
                            </tr>
                            <tr>
                                <td colspan="3" class="td-top-border-1px text-right-align bold-font">Return</td>
                                <td class="td-top-border-1px bold-font"><?php echo $balance; ?></td>
                            </tr>
                        </tbody>
                    </table>

                </div>
            </td>
        </tr>

        <tr>
            <td colspan="2">
                <div class="bill-table">
                    <table style="width: 300px;">
                        <tr>
                            <td class="bold-font" style="text-align: left; width: 80px;">Grand Total: </td>
                            <td class="bold-font" style="text-align: left; width: 220px;"><?php echo number_format(($payable + $dis_amount), 2, '.', ''); ?></td>
                        </tr>
                        
                        <tr>
                            <td class="bold-font" style="text-align: left; width: 80px;">Discount: </td>
                            <td class="bold-font" style="text-align: left; width: 220px;"><?php echo number_format($dis_amount, 2, '.', ''); ?></td>
                        </tr>
                    </table>
                </div>
            </td>
        </tr>

    </table>

    <div class="print-btn" style="width: 105px;">
        <button type="button" id="btn-print">Print</button>
    </div>
    
</div>

<?php
Yii::app()->clientScript->registerCoreScript('jquery');
?>

<script type="text/javascript">

    $(document).ready(function() {
        
        $(document).on('keypress', function(e){
            
            if (e.keyCode == 13) {
                $('#btn-print').trigger('click');
            }
            
            return false;
        });
        
        $(document).on('click', '#btn-print', function() {
            var divContents = $(".print").html();
            var printWindow = window.open('', '', 'height=400, width=800');
            console.log(divContents);
            printWindow.document.write('<html><head><title>Print</title>');
            printWindow.document.write('</head><body >');
            printWindow.document.write(divContents);
            printWindow.document.write('</body></html>');
            printWindow.document.close();
            printWindow.print();
        });
    });
</script>