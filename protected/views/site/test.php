<?php
echo '&nbsp;';
echo '&nbsp;';
echo '&nbsp;';
echo '&nbsp;';
echo '&nbsp;';
echo '&nbsp;';
echo '&nbsp;';
echo '&nbsp;';
echo '&nbsp;';
echo '&nbsp;';
echo '&nbsp;';
echo '&nbsp;';
echo '&nbsp;';
echo '&nbsp;';
echo '&nbsp;';
echo '&nbsp;';
echo '&nbsp;';
echo '&nbsp;';
echo '&nbsp;';
echo '&nbsp;';
echo '&nbsp;';

//Widht of the barcode image. 
$width  = 250;  
//Height of the barcode image.
$height = 50;
//Quality of the barcode image. Only for JPEG.
$quality = 100;
//1 if text should appear below the barcode. Otherwise 0.
$text = 0;
// Location of barcode image storage.
$location = Yii::getPathOfAlias("webroot").'/barcode_pdfs/bc.jpeg';

Yii::import("application.extensions.barcode.*");
barcode::Barcode39('123456', $width , $height , $quality, $text, $location);
echo '<img src="/barcode_pdfs/bc.jpeg">';
exit;


echo '<img src="/barcodegenerator/generatebarcode?code=123456&codetype=code128">';
exit;

$this->widget('DataGrid', array('model' => 'ProductDetails', 'pageSize' => 20));
?>
