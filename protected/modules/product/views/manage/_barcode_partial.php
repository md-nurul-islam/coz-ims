<?php
$webroot = Yii::getPathOfAlias('webroot');
$pdfs_path = $webroot . DIRECTORY_SEPARATOR . 'barcode_pdfs' . DIRECTORY_SEPARATOR;

if (file_exists($pdfs_path . 'barcodes.pdf')) {
    unlink($pdfs_path . 'barcodes.pdf');
}

ob_start();
?>

<div class="wrapper">
    <?php
    $c = 0;
    foreach ($purchaseRecords as $pr) {
        ?>
        <?php for ($i = 0; $i < $pr['quantity']; $i++) { ?>
            <div class="code-wrapper">
                <div class="prod_name"><?php echo $pr['product_name']; ?></div>
                <div class="prod_barcode"><img src="/barcodegenerator/generatebarcode?code=<?php echo $pr['code']; ?>&size=30&codetype=code128"></div>
                <div class="prod_ref_num"><?php echo $pr['code']; ?></div>
            </div>
            <?php $c++; if ($c % 44 == 0) { ?>
                <pagebreak />
            <?php } ?>
        <?php } ?>
    <?php } ?>
</div>

<style type="text/css">
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
        float: left;
        width: 100%;
    }
    .code-wrapper {
        float: left;
        margin-bottom: 20px;
        text-align: center;
        width: 25%;
    }
    .export-btn {
        background-color: #519cc6;
        border: medium none;
        border-radius: 5px;
        box-shadow: 0 0 6px 1px #ccc;
        color: #ffffff;
        cursor: pointer;
        float: left;
        font-size: 15px;
        font-weight: bold;
        height: 35px;
        margin-bottom: 20px;
        margin-top: 20px;
        padding: 15px 15px 0;
        text-align: center;
        text-decoration: none;
        width: 100px;
    }
    .export-btn:hover {
        background-color: #0f547e;
        color: #ffffff;
        transition: all 0.5s ease-in-out 0s;
    }
    .export-btn:active {
        color: #ffffff;
    }
</style>

<?php
$s_pdf_content = ob_get_contents();
ob_end_clean();

echo $s_pdf_content;

$pdf = Yii::app()->ePdf->mpdf('', 'A4');
$pdf->WriteHTML($s_pdf_content);
$pdf->Output($pdfs_path . DIRECTORY_SEPARATOR . 'barcodes.pdf', 'F');
?>
