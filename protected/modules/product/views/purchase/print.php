<?php
$this->breadcrumbs = array(
    'Product Purchase' => array('index'),
    'Purchase List',
);

$this->menu = Ims_menu::$purchase_menu;
?>

<div class="print" style="margin-left: auto; margin-right: auto; width: 50%;">

    <style type="text/css">
        table *{
            font-family: Tahoma, Arial, Times New Roman;
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

    <table class="bill-print" style="width: 450px;">
        <tr>
            <td colspan="2" style="text-align: center;">
                <div class="row head">RFL EXclusive</div>
            </td>
        </tr>

        <tr>
            <td style="text-align: right; width: 350px;">Date: </td>
            <td style="text-align: right; width: 150px;"><?php echo $model['date']; ?></td>
        </tr>

        <tr>
            <td style="text-align: right">Bill No: </td>
            <td style="text-align: right"><?php echo $model['bill_no']; ?></td>
        </tr>

        <?php
        $payable = $model['g_total_payable'];
        $paid = $model['g_total_paid'];
        $balance = $model['g_total_balance'];

        unset($model['bill_no']);
        unset($model['date']);
        unset($model['g_total_payable']);
        unset($model['g_total_paid']);
        unset($model['g_total_balance']);
        ?>

        <tr>
            <td colspan="2">
                <div class="bill-table">
                    <table class="bill-print" style="width: 550px;">
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
                                    Cost:
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
                                    <td>
                                        <?php echo $i; ?> 
                                    </td>
                                    <td>
                                        <?php echo $row['prod_name']; ?> 
                                    </td>
                                    <td>
                                        <?php echo $row['qty']; ?> 
                                    </td>
                                    <td>
                                        <?php echo $row['cost']; ?> 
                                    </td>
                                    <td>
                                        <?php echo $row['sub_total']; ?> 
                                    </td>
                                </tr>
                                <?php
                                $i++;
                            }
                            ?>
                            <tr>
                                <td colspan="4" class="td-top-border-1px text-right-align bold-font">Grand Total Payable</td>
                                <td class="td-top-border-1px bold-font"><?php echo $payable; ?></td>
                            </tr>
                            <tr>
                                <td colspan="4" class="td-top-border-1px text-right-align bold-font">Grand Total Paid</td>
                                <td class="td-top-border-1px bold-font"><?php echo $paid; ?></td>
                            </tr>
                            <tr>
                                <td colspan="4" class="td-top-border-1px text-right-align bold-font">Grand Total Balance</td>
                                <td class="td-top-border-1px bold-font"><?php echo $balance; ?></td>
                            </tr>
                        </tbody>
                    </table>

                </div>
            </td>
        </tr>

    </table>

    <div class="print-btn">
        <button type="button" id="btn-print">Print</button>
    </div>

</div>

<?php
Yii::app()->clientScript->registerCoreScript('jquery');
?>

<script type="text/javascript">

    $(document).ready(function() {
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