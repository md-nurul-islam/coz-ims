<?php
$webroot = Yii::getPathOfAlias('webroot');
$pdfs_path = $webroot . DIRECTORY_SEPARATOR . 'barcode_pdfs' . DIRECTORY_SEPARATOR;
$now = date('Ymd_His');

ob_start();
?>

<div class="wrapper">
    <?php
    if (!empty($purchaseRecords)) {
        $c = 0;
        $k = 0;
        $i_purchase_row_ids = array();
        foreach ($purchaseRecords as $pr) {
            $i_purchase_row_ids[$k]['id'] = $pr['id'];
            $i_purchase_row_ids[$k]['code'] = $pr['code'];
            ?>
            <?php for ($i = 0; $i < $pr['quantity']; $i++) { ?>
                <div class="code-wrapper">
                    <div class="prod_barcode">
                        <img src="/product/barcode/generate?filetype=PNG&dpi=300&scale=1&rotation=0&font_family=0&font_size=0&text=<?php echo $pr['code']; ?>&thickness=35&code=BCGean13">
                    </div>
                    <div class="prod_name"><?php echo $pr['product_name']; ?></div>
                    <div class="prod_ptice"><?php echo ' TK ' . $pr['selling_price']; ?></div>
                    <div class="prod_ref_num">
                        <?php
                        $rev_purchase_price = strrev($pr['purchase_price']);
                        $dotless_rev_purchase_price = str_replace('.', '', $rev_purchase_price);
                        $zeroless_rev_purchase_price = str_replace('0', '', $dotless_rev_purchase_price);
                        echo $zeroless_rev_purchase_price;
                        ?>K<?php echo $pr['code']; ?>-<?php echo $pr['quantity'] . '/' . $pr['quantity']; ?>
                    </div>
                </div>
                <?php
                $c++;
                if ($c % 63 == 0) {
                    ?>
                    <pagebreak />
                <?php } ?>
                <?php
            }
            $k++;
        }
    } else {
        ?>
        <div class="code-wrapper">
            No Product available to generate barcode.
        </div>
    <?php } ?>
</div>

<style type="text/css" media="all">
    .note {
        color: red;
        font-size: 20px;
        margin-bottom: 30px;
        margin-left: auto; 
        margin-right: auto; 
        text-align: center;
        width: 100%;
    }
    .wrapper {
        margin: 0;
        padding: 0;
        float: left;
        width: 100%;
    }
    .code-wrapper {
        float: left;
        margin-bottom: 15px;
        margin-left: 20px;
        text-align: center;
        width: 11%;
    }
    .prod_barcode {
        float: left;
        width: 100%;
    }
    .prod_barcode img {
        float: left;
        width: 100%;
    }
    .clearfix {
        clear: both;
    }
    .prod_name, .prod_ptice, .prod_ref_num {
        font-family: 'Tahoma';
        font-size: 10px;
    }
</style>

<?php
$s_pdf_content = ob_get_contents();
ob_end_clean();

echo $s_pdf_content;

if (!empty($purchaseRecords)) {
    $pdf = Yii::app()->ePdf->mpdf('', 'A4');
    $pdf->SetDisplayMode('fullpage');
    $pdf->WriteHTML($s_pdf_content);
    $pdf->Output($pdfs_path . DIRECTORY_SEPARATOR . $now . '_barcodes.pdf', 'F');
}
?>

<script type="text/javascript">
    $(document).ready(function () {

        $.ajax({
            url: '/product/manage/setbarcode',
            type: 'post',
            dataType: 'json',
            data: {ids: <?php echo json_encode($i_purchase_row_ids); ?>},
            success: function (response) {
                console.log(response.success);
            },
            error: function (e) {

            }
        });
    });
</script>