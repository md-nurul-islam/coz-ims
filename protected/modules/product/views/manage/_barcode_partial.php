<?php
$webroot = Yii::getPathOfAlias('webroot');
$pdfs_path = $webroot . DIRECTORY_SEPARATOR . 'barcode_pdfs' . DIRECTORY_SEPARATOR;
$now = time();
Yii::import("application.extensions.barcode.*");

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
                        <?php
                        barcode::Barcode39($pr['code'], $barcode['width'], $barcode['height'], $barcode['quality'], $barcode['text'], $barcode['img_path'] . '/' . $pr['code'] . '.jpeg');
                        ?>
                        <img src="<?php echo '/bc_image' . '/' . $pr['code'] . '.jpeg'; ?>">
                    </div>
                    <div class="prod_name"><?php echo $pr['product_name']; ?></div>
                    <div class="prod_ptice"><?php echo ' TK ' . $pr['selling_price']; ?></div>
                    <div class="prod_ref_num"><?php echo $pr['code']; ?></div>
                </div>
                <?php
                $c++;
                if ($c % 32 == 0) {
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
        margin-bottom: 20px;
        text-align: center;
        width: 30%;
    }
    .prod_barcode {
        float: left;
        width: 100%;
    }
    .prod_barcode img {
        float: left;
        width: 100%;
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