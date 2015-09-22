<?php

class BarcodeController extends Controller {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column2';

    /**
     * @return array action filters
     */
    public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
            'postOnly + delete', // we only allow deletion via POST request
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules() {
        return array(
//            array('allow', // allow authenticated user to perform 'create' and 'update' actions
//                'actions' => array('index', 'view', 'create', 'update', 'autocomplete'),
//                'users' => array('@'),
//            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('generate'),
//                'expression' => '(!Yii::app()->user->isGuest) && (Yii::app()->user->isSuperAdmin || Yii::app()->user->isStoreAdmin)',
                'users' => array('*'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    public function actionGenerate() {

        $bcdir = Yii::getPathOfAlias('application.vendors.barcodegen');
        $class_dir = $bcdir . DIRECTORY_SEPARATOR . 'class';
        $classFile = 'BCGean13.barcode.php';
        $className = 'BCGean13';
        $baseClassFile = 'BCGBarcode1D.php';

        require_once($class_dir . DIRECTORY_SEPARATOR . 'BCGColor.php');
        require_once($class_dir . DIRECTORY_SEPARATOR . 'BCGBarcode.php');
        require_once($class_dir . DIRECTORY_SEPARATOR . 'BCGDrawing.php');
        require_once($class_dir . DIRECTORY_SEPARATOR . 'BCGFontFile.php');

        require_once($class_dir . DIRECTORY_SEPARATOR . $classFile);
        require_once($class_dir . DIRECTORY_SEPARATOR . $baseClassFile);

        $filetypes = array('PNG' => BCGDrawing::IMG_FORMAT_PNG, 'JPEG' => BCGDrawing::IMG_FORMAT_JPEG, 'GIF' => BCGDrawing::IMG_FORMAT_GIF);
        $pid = Yii::app()->request->getParam('pid');

        $drawException = null;

        try {
            $color_black = new BCGColor(0, 0, 0);
            $color_white = new BCGColor(255, 255, 255);

            $code_generated = new $className();

            $this->baseCustomSetup($code_generated, $_GET);

            $scale = Yii::app()->request->getParam('scale');

            $code_generated->setScale(max(1, min(4, $scale)));
            $code_generated->setBackgroundColor($color_white);
            $code_generated->setForegroundColor($color_black);

            $text = Yii::app()->request->getParam('text');
            if ($text !== '') {
                $text = stripslashes($text);
                if (function_exists('mb_convert_encoding')) {
                    $text = mb_convert_encoding($text, 'ISO-8859-1', 'UTF-8');
                }

                $code_generated->parse($text);
                
                $ref_num = $text.$code_generated->getChecksum();
                
                $command = Yii::app()->db->createCommand();
                $command->update(ProductStockEntries::model()->tableName(), array(
                    'ref_num' => $ref_num,
                        ), 'id=:id', array(':id' => $pid));
                
            }
        } catch (Exception $exception) {
            $drawException = $exception;
        }

        $drawing = new BCGDrawing('', $color_white);
        if ($drawException) {
            $drawing->drawException($drawException);
        } else {
            $drawing->setBarcode($code_generated);

            $rotation = Yii::app()->request->getParam('rotation');
            $drawing->setRotationAngle($rotation);

            $dpi = Yii::app()->request->getParam('dpi');
            $drawing->setDPI($dpi === 'NULL' ? null : max(72, min(300, intval($dpi))));
            $drawing->draw();
        }

        $filetype = Yii::app()->request->getParam('filetype');
        switch ($filetype) {
            case 'PNG':
                header('Content-Type: image/png');
                break;
            case 'JPEG':
                header('Content-Type: image/jpeg');
                break;
            case 'GIF':
                header('Content-Type: image/gif');
                break;
        }

        $drawing->finish($filetypes[$filetype]);
    }

    private function baseCustomSetup($barcode, $get) {

//        var_dump($get['font_family']);exit;
        $bcdir = Yii::getPathOfAlias('application.vendors.barcodegen');
        $font_dir = $bcdir . DIRECTORY_SEPARATOR . 'font';

        if (isset($get['thickness'])) {
            $barcode->setThickness(max(9, min(90, intval($get['thickness']))));
        }

        $font = 0;
        if ($get['font_family'] !== '0' && intval($get['font_size']) >= 1) {
            $font = new BCGFontFile($font_dir . '/' . $get['font_family'], intval($get['font_size']));
        }

        $barcode->setFont($font);
    }

}
