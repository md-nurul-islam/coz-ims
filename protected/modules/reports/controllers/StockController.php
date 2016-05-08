<?php

class StockController extends Controller {

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
                'actions' => array('index', 'get_tabledata'),
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

        $this->pageTitle = Yii::app()->name . ' - Stock Report';
        $model = new ProductStockAvail();

        $datatable = array(
            'model' => 'ProductStockAvail',
            'dataSource' => Yii::app()->request->getBaseUrl(TRUE) . "/{$this->module->id}/{$this->id}/get_tabledata",
            'header' => $model->getDataTableHeadersForReport(),
            'columns' => $model->getDataTableColumnsForReport(),
            'pageLength' => 1000,
            'columnDefs' => $model->getDataTableColumnsDefsForReport(),
            'columnId' => $model->getIdColumnForReport(),
            'showModal' => false,
            'footerCallback' => TRUE,
        );

        $this->render('index', array(
            'datatable' => $datatable,
        ));
    }

    public function actionGet_tabledata() {

        $order = Yii::app()->request->getPost('order');
        
        if(!empty($order)) {
            $params['order'] = $order;
        }
        
        $cur_page = Yii::app()->request->getPost('start');
        $length = Yii::app()->request->getPost('length');

        list($params['offset'], $params['items_per_page']) = Settings::getDataTablePageLimit($cur_page, $length);

        $model = new ProductStockAvail();
        $_data = $model->getStockReportData($params);
        $obj_num_records_total = $model->getDataTableDataRowCountForReport();
        $num_records_total = intval($obj_num_records_total['total_rows']);

        $data = array(
            'recordsTotal' => $num_records_total,
            'recordsFiltered' => $num_records_total,
            'data' => $_data,
        );
        
        echo json_encode($data);
        Yii::app()->end();
    }

}
