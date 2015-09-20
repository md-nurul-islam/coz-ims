<?php
//
////Widht of the barcode image. 
//$width  = 250;  
////Height of the barcode image.
//$height = 50;
////Quality of the barcode image. Only for JPEG.
//$quality = 100;
////1 if text should appear below the barcode. Otherwise 0.
//$text = 0;
//// Location of barcode image storage.
//$location = Yii::getPathOfAlias("webroot").'/barcode_pdfs/bc.jpeg';
//
//Yii::import("application.extensions.barcode.*");
//barcode::Barcode39('123456', $width , $height , $quality, $text, $location);
//echo '<img src="/barcode_pdfs/bc.jpeg">';
//exit;

//echo time();
//echo date('ymd');
//exit;

//echo '<img src="/barcodegenerator/generatebarcode?code=123456&codetype=code128">';
for($i = 0; $i <= 100; $i++){
    echo '<img src="/product/barcode/generate?filetype=PNG&dpi=72&scale=1&rotation=0&font_family=Arial.ttf&font_size=0&text=192168264595&thickness=30&code=BCGean13">';
}
exit;

$this->widget('DataGrid', array('model' => 'ProductDetails', 'pageSize' => 20));
?>
