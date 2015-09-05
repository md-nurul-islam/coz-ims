<?php

class CategoryController extends Controller {

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
                'actions' => array('index', 'view', 'create', 'update', 'autocomplete'),
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
        $this->pageTitle = Yii::app()->name . ' - View Category';

        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $model = new CategoryDetails;

        $this->pageTitle = Yii::app()->name . ' - Add Category';

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if (isset($_POST['CategoryDetails'])) {
            $model->attributes = $_POST['CategoryDetails'];
            
//            if (!Yii::app()->user->isSuperAdmin) {
//                $model->store_id = Yii::app()->user->storeId;
//            }

            if ($model->save())
                $this->redirect(array('index'));
        }

        $this->render('create', array(
            'model' => $model,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);

        $this->pageTitle = Yii::app()->name . ' - Update Category';

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if (isset($_POST['CategoryDetails'])) {
            $model->attributes = $_POST['CategoryDetails'];
            
//            if (!Yii::app()->user->isSuperAdmin) {
//                $model->store_id = Yii::app()->user->storeId;
//            }

            if ($model->save())
                $this->redirect(array('index'));
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        if (!Yii::app()->request->isAjaxRequest) {
            throw new CHttpException(400, 'Bad Request.');
        }

        $model = $this->loadModel($id);
        $model->status = 0;
        $model->update();
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $model = new CategoryDetails('search');

        $this->pageTitle = Yii::app()->name . ' - Category List';

        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['CategoryDetails']))
            $model->attributes = $_GET['CategoryDetails'];

        $this->render('index', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return CategoryDetails the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = CategoryDetails::model()->findByPk($id);
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

            $str_store_condition = "";

//            if (!Yii::app()->user->isSuperAdmin) {
//                $str_store_condition = " AND store_id = '" . Yii::app()->user->storeId . "'";
//            }

            if ((!Yii::app()->user->isGuest) && (Yii::app()->request->isAjaxRequest) && !empty($term)) {
                $ar_result = Yii::app()->db->createCommand()->select('id, category_name')->from('cims_category_details cd')->where("cd.category_name like '%" . $term . "%' AND cd.status = 1" . $str_store_condition)->limit(10)->queryAll();
            }

            $return_array = array();
            foreach ($ar_result as $result) {
                $return_array[] = array(
                    'id' => $result['id'],
                    'value' => $result['category_name'],
                );
            }

            echo CJSON::encode($return_array);
        }
    }

    /**
     * Performs the AJAX validation.
     * @param CategoryDetails $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'category-details-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
