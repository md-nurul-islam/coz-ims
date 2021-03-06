<?php

class PurchaseController extends Controller {

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
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('index', 'view', 'create', 'update', 'product_stock_info', 'print'),
                'users' => array('@'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    public function actionIndex() {
        
        $model = false;
        $msg = '';
        
        $today = date('Y-m-d', Settings::getBdLocalTime());
        $from_date = $today;
        $to_date = $today;
        
        if( Yii::app()->request->isPostRequest && !empty($_POST) ){
            
            $from_date = Yii::app()->request->getPost('from_date');
            
            $to_date = Yii::app()->request->getPost('to_date');
            
            $model = new ProductStockEntries;
            $model = $model->purchaseReportData($from_date, $to_date);
            
            if(!$model){
                $msg = 'No Record Found in the given date rang.';
            }
            
        }
        
        $this->render('index', array(
            'model' => $model,
            'msg' => $msg,
            'today' => $today,
            'from_date' => $from_date,
            'to_date' => $to_date,
        ));
    }

}
