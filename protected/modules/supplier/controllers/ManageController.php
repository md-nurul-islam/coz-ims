<?php

class ManageController extends Controller {

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
                'actions' => array('create', 'update', 'index', 'view', 'autocomplete'),
                'users' => array('@'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('admin', 'delete'),
                'users' => array('admin'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {
        $this->pageTitle = Yii::app()->name . ' - View Supplier';

        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $model = new SupplierDetails;

        $this->pageTitle = Yii::app()->name . ' - Add Supplier';

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if (isset($_POST['SupplierDetails'])) {
            $model->attributes = $_POST['SupplierDetails'];
            
            if (!Yii::app()->user->isSuperAdmin) {
                $model->store_id = Yii::app()->user->storeId;
            }  else {
                $model->store_id = 1;
            }
            
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id));
        }

        $show_balance = false;

        $this->render('create', array(
            'model' => $model,
            'show_balance' => $show_balance,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);

        $this->pageTitle = Yii::app()->name . ' - Update Supplier';

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if (isset($_POST['SupplierDetails'])) {
            $model->attributes = $_POST['SupplierDetails'];
            
            if (!Yii::app()->user->isSuperAdmin) {
                $model->store_id = Yii::app()->user->storeId;
            }  else {
                $model->store_id = 1;
            }
            
            if ($model->save())
                $this->redirect(array('index'));
            //$this->redirect(array('view','id'=>$model->id));
        }

        $show_balance = true;

        $this->render('update', array(
            'model' => $model,
            'show_balance' => $show_balance,
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        $this->loadModel($id)->delete();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $model = new SupplierDetails('search');

        $this->pageTitle = Yii::app()->name . ' - Supplier List';

        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['SupplierDetails']))
            $model->attributes = $_GET['SupplierDetails'];

        $this->render('index', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return SupplierDetails the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = SupplierDetails::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs Autocomplte.
     * @param CategoryDetails $model the model to be validated
     */
    public function actionAutocomplete() {

        if (isset($_GET['term'])) {
            $term = $_GET['term'];

            $ar_result = array();
            $str_con_store = "";
            
//            if( !Yii::app()->user->isSuperAdmin) {
//                $str_con_store = " AND store_id = '" . Yii::app()->user->storeId . "'";
//            }
            
            if ((!Yii::app()->user->isGuest) && (Yii::app()->request->isAjaxRequest) && !empty($term)) {
                $ar_result = Yii::app()->db->createCommand()->select('id, supplier_name')->from('cims_supplier_details sd')->where("sd.supplier_name like '%" . $term . "%'{$str_con_store}")->limit(10)->queryAll();
            }

            $return_array = array();
            foreach ($ar_result as $result) {
                $return_array[] = array(
                    'id' => $result['id'],
                    'value' => $result['supplier_name'],
                );
            }

            echo CJSON::encode($return_array);
        }
    }

    /**
     * Performs the AJAX validation.
     * @param SupplierDetails $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'supplier-details-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
