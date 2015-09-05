<?php

class ExchangeController extends Controller {

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
                'actions' => array('index'),
                'users' => array('@'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    public function actionIndex() {
        
        $model_data = false;
        $msg = '';
        
        $today = date('Y-m-d', Settings::getBdLocalTime());
        $from_date = $today;
        $to_date = $today;
        
        $ar_final_data = array();
        if( Yii::app()->request->isPostRequest && !empty($_POST) ){
            
            $from_date = Yii::app()->request->getPost('from_date');
            
            $to_date = Yii::app()->request->getPost('to_date');
            
            $model = new ExchangeProducts;
            
            $model_ex = $model->exchangeReportData($from_date, $to_date, true);
            
            if($model_ex){
                
                $model_main = $model->exchangeReportData($from_date, $to_date);
                $model_data = $this->__merge_arrays($model_main, $model_ex);
            }
            
            if(!$model_data){
                $msg = 'No Record Found in the given date range.';
            }
            
        }
        
        $this->render('index', array(
            'model_data' => $model_data,
            'msg' => $msg,
            'today' => $today,
            'from_date' => $from_date,
            'to_date' => $to_date,
        ));
    }
    
    private function __merge_arrays($ar_1, $ar_2){
        
//        echo '<pre>';
//        var_dump($ar_2);exit;
        
        foreach ($ar_1 as $key => $value) {
            if(array_key_exists($key, $ar_2)){
                $ar_1[$key]['ex_product'] = $ar_2[$key]['ex_product'];
            }
        }
//        echo '<pre>';
//        var_dump($ar_1);exit;
        return $ar_1;
        
    }

}
