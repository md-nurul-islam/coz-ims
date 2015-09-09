<?php

/* if multiple barcodes make sure itemId is unique */
$optionsArray = array(
    'itemId' => 'barcode-div', /* id for div or canvas */
    'barocde' => '4797001018719', /* value for EAN 13 be careful to set right values for each barcode type */
    'type' => 'code128', /* supported types  ean8, ean13, upc, std25, int25, code11, code39, code93, code128, codabar, msi, datamatrix */
);
echo Common::getItemBarcode($optionsArray);

//$this->widget('DataGrid', array('model' => 'ProductDetails', 'pageSize' => 20));
?>
