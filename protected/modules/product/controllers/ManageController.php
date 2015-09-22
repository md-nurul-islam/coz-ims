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
                'actions' => array('index', 'view', 'create', 'update', 'autocomplete'),
                'users' => array('@'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('update_stock', 'delete', 'barcode', 'downloadBarcode', 'barcodeFileList'),
                'expression' => '(!Yii::app()->user->isGuest) && (Yii::app()->user->isSuperAdmin || Yii::app()->user->isStoreAdmin)',
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
        $this->pageTitle = Yii::app()->name . ' - Product Details';

        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $this->pageTitle = Yii::app()->name . ' - Add Product';

        $model = new ProductDetails;
        $category_name = '';
        $supplier_name = '';
        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if (!Yii::app()->user->isSuperAdmin) {
            $store_id = Yii::app()->user->storeId;
        } else {
            $store_id = 1;
        }

        if (isset($_POST['ProductDetails'])) {
            $category_name = Yii::app()->request->getPost('category_name');
            $supplier_name = Yii::app()->request->getPost('supplier_name');

            $model->attributes = $_POST['ProductDetails'];

            $model->store_id = $store_id;

            if (empty($category_name)) {
                $model->category_id = '';
            }

            if (empty($supplier_name)) {
                $model->supplier_id = '';
            }

            $model->create_date = date('Y-m-d H:i:s', Settings::getBdLocalTime());

            if ($model->save())
                $this->redirect(array('index'));
        }

        $this->render('create', array(
            'model' => $model,
            'category_name' => $category_name,
            'supplier_name' => $supplier_name,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $this->pageTitle = Yii::app()->name . ' - Update Product';

        $model = $this->loadModel($id);

        $category_name = $model->category->category_name;
        $supplier_name = $model->supplier->supplier_name;
        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if (!Yii::app()->user->isSuperAdmin) {
            $store_id = Yii::app()->user->storeId;
        } else {
            $store_id = 1;
        }

        if (isset($_POST['ProductDetails'])) {
            $category_name = Yii::app()->request->getPost('category_name');
            $supplier_name = Yii::app()->request->getPost('supplier_name');

            $model->attributes = $_POST['ProductDetails'];

            $model->store_id = $store_id;

            if (empty($category_name)) {
                $model->category_id = '';
            }

            if (empty($supplier_name)) {
                $model->supplier_id = '';
            }

            if (empty($model->purchase_price)) {
                $model->purchase_price = 0.00;
            }

            if (empty($model->selling_price)) {
                $model->selling_price = 0.00;
            }

            $model->status = $_POST['ProductDetails']['status'];
            $model->update_date = date('Y-m-d H:i:s', Settings::getBdLocalTime());

            $update = Yii::app()->db->createCommand()
                    ->update('cims_product_details', array(
                'category_id' => $model->category_id,
                'supplier_id' => $model->supplier_id,
                'product_name' => $model->product_name,
                'purchase_price' => $model->purchase_price,
                'selling_price' => $model->selling_price,
                'update_date' => $model->update_date,
                'status' => $model->status,
                    ), 'id = :id AND store_id = :sid', array(':id' => $id, ':sid' => $model->store_id)
            );

            $this->redirect(array('index'));
        }

        $this->render('update', array(
            'model' => $model,
            'category_name' => $category_name,
            'supplier_name' => $supplier_name,
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
        $model = new ProductDetails('search');

        $this->pageTitle = Yii::app()->name . ' - Product List';
        $pageSize = 0;

        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['ProductDetails'])) {
            $model->attributes = $_GET['ProductDetails'];
        }

        if (isset($_GET['ProductDetails']['current_stock'])) {
            $model->current_stock = $_GET['ProductDetails']['current_stock'];
        }

        if (isset($_GET['pageSize'])) {
            $pageSize = (int) $_GET['pageSize'];
            $model->pageSize = $pageSize;
            unset($_GET['pageSize']);
        }

        if (!Yii::app()->user->isSuperAdmin) {
            $model->store_id = Yii::app()->user->storeId;
        } else {
            $model->store_id = 1;
        }

        $this->render('index', array(
            'model' => $model,
            'pageSize' => $pageSize,
        ));
    }

    public function actionBarcode() {

        ini_set('max_execution_time', 0);

        $modPurchase = new ProductStockEntries();
        $purchaseRecords = $modPurchase->purchaseListForBarcode();
        
        $barcode['filetype'] = 'PNG';
        $barcode['dpi'] = 300;
        $barcode['scale'] = 1;
        $barcode['rotation'] = 0;
        $barcode['font_family'] = 'Arial.ttf';
        $barcode['font_size'] = 7;
        $barcode['thickness'] = 35;
        $barcode['codetype'] = 'BCGean13';
        
        $mPDF1 = Yii::app()->ePdf->mpdf();

        $this->render('barcode', array(
            'purchaseRecords' => ($purchaseRecords) ? $purchaseRecords : array(),
            'pdf' => $mPDF1,
            'barcode' => $barcode,
        ));
    }

    public function actionDownloadBarcode() {

        $webroot = Yii::getPathOfAlias('webroot');
        $pdfs_path = $webroot . DIRECTORY_SEPARATOR . 'barcode_pdfs' . DIRECTORY_SEPARATOR;
        $name = Yii::app()->request->getParam('barcode');

        if (file_exists($pdfs_path . $name)) {
            Yii::app()->getRequest()->sendFile($name, file_get_contents($pdfs_path . $name));
        } else {
            throw new CException(404, 'File not found.');
        }
    }

    public function actionBarcodeFileList() {
        
        $webroot = Yii::getPathOfAlias('webroot');
        $pdfs_path = $webroot . DIRECTORY_SEPARATOR . 'barcode_pdfs';

        $files = CFileHelper::findFiles($pdfs_path);
        
        $response = array();
        if (!empty($files)) {
            foreach ($files as $file) {
                $ar_file_name = explode('/', $file);
                $response[] = end($ar_file_name);
            }   
        }
        echo json_encode($response);
        Yii::app()->end();
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return ProductDetails the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {

        $store_id = 1;
        if (!Yii::app()->user->isSuperAdmin) {
            $store_id = Yii::app()->user->storeId;
        }

        $criteria = new CDbCriteria();
        $criteria->compare('t.id', $id);
        $criteria->compare('t.store_id', $store_id);

        $model = ProductDetails::model()->with(array('category', 'supplier'))->find($criteria);

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
            if (!Yii::app()->user->isSuperAdmin) {
                $str_store_condition = " AND pd.store_id = '" . Yii::app()->user->storeId . "'";
            }

            if ((!Yii::app()->user->isGuest) && (Yii::app()->request->isAjaxRequest) && !empty($term)) {
                $ar_result = Yii::app()->db->createCommand()->select('id, product_name')->from('cims_product_details pd')->where("pd.product_name like '%" . $term . "%' AND status = '1'" . $str_store_condition)->limit(50)->queryAll();
            }

            $return_array = array();
            foreach ($ar_result as $result) {
                $return_array[] = array(
                    'id' => $result['id'],
                    'value' => $result['product_name'],
                );
            }

            echo CJSON::encode($return_array);
        }
    }

    public function actionUpdate_stock($id) {

        if (!Yii::app()->user->isSuperAdmin) {
            $store_id = Yii::app()->user->storeId;
        } else {
            $store_id = 1;
        }

        $model = new ProductStockAvail;
        $model = $model->getStockByProdId($id, $store_id);

        if (isset($_POST['ProductStockAvail'])) {
            $model->attributes = $_POST['ProductStockAvail'];

            $model->store_id = $store_id;

            if ($model->validate()) {
                if ($model->update()) {
                    Yii::app()->user->setFlash('success', 'Stock Successfully Updated.');
                } else {
                    Yii::app()->user->setFlash('error', 'Stock Could Not Be Updated.');
                }
            }
        }

        $this->render('update_stock', array('model' => $model));
    }

    /**
     * Performs the AJAX validation.
     * @param ProductDetails $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'product-details-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
