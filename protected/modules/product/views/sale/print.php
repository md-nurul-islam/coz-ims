<?php
$this->breadcrumbs = array(
    'Product Sales' => array('index'),
    'Sales List',
);

$this->menu = Ims_menu::$sale_menu;
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
        .text-align-left{
            text-align: left;
        }
        .text-align-center{
            text-align: center;
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
            <td style="text-align: right; width: 75px;"><?php echo $model['date']; ?></td>
        </tr>

        <tr>
            <td style="text-align: right">Bill No: </td>
            <td style="text-align: right"><?php echo $model['bill_no']; ?></td>
        </tr>

        <?php
        $payable = $model['g_total_payable'];
        $paid = $model['g_total_paid'];
        $balance = $model['g_total_balance'];
        $dis_amount = $model['dis_amount'];

        unset($model['bill_no']);
        unset($model['date']);
        unset($model['g_total_payable']);
        unset($model['g_total_paid']);
        unset($model['g_total_balance']);
        unset($model['dis_amount']);
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
                                <th>
                                    Price:
                                </th>
                                <th>
                                    Total:
                                </th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            $i = 1;
                            foreach ($model as $row) {
                                ?>
                                <tr>
                                    <td class="text-align-center">
                                        <?php echo $i; ?> 
                                    </td>
                                    <td class="text-align-center">
                                        <?php echo $row['prod_name']; ?> 
                                    </td>
                                    <td class="text-align-center">
                                        <?php echo $row['qty']; ?> 
                                    </td>
                                    <td class="text-align-center">
                                        <?php echo $row['price']; ?> 
                                    </td>
                                    <td class="text-align-center">
                                        <?php echo $row['sub_total']; ?> 
                                    </td>
                                </tr>
                                <?php
                                $i++;
                            }
                            ?>
                            <tr>
                                <td colspan="4" class="td-top-border-1px text-right-align bold-font">Total Payable</td>
                                <td class="td-top-border-1px bold-font text-align-center"><?php echo $payable; ?></td>
                            </tr>
                            <tr>
                                <td colspan="4" class="td-top-border-1px text-right-align bold-font">Total Paid</td>
                                <td class="td-top-border-1px bold-font text-align-center"><?php echo $paid; ?></td>
                            </tr>
                            <tr>
                                <td colspan="4" class="td-top-border-1px text-right-align bold-font"><?php echo ($payable > $paid) ? 'Due' : 'Return'; ?></td>
                                <td class="td-top-border-1px bold-font text-align-center"><?php echo $balance; ?></td>
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

</div>

<div class="print-btn">
    <button type="button" id="btn-print">Print</button>
</div>


<?php
Yii::app()->clientScript->registerCoreScript('jquery');
?>

<style type="text/css">
    .print-btn{
        text-align: center;
        width: 100%;
    }
</style>

<script type="text/javascript">

    $(document).ready(function() {
        
        $(document).on('keypress', function(e){
            
            if (e.keyCode == 13) {
                return false;
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