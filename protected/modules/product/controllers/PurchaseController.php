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
                'actions' => array('index', 'print', 'view', 'create', 'update', 'product_stock_info', 'createsingle'),
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
        $this->redirect(array('print', 'purchase_id' => $id));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $model = new ProductStockEntries;

        $this->pageTitle = Yii::app()->name . ' - Purchase Product';

        $store_id = 1;
        if (!Yii::app()->user->isSuperAdmin) {
            $store_id = Yii::app()->user->storeId;
        }

        $ar_cart = array();

        if (isset($_POST['ProductStockEntries'])) {
            $stock_info = new ProductStockAvail;

            $bill_number = $_POST['ProductStockEntries']['billnumber'];
            $purchase_date = date('Y-m-d', strtotime($_POST['ProductStockEntries']['purchase_date']));
            $supplier_id = $_POST['ProductStockEntries']['supplier_id'];
            $grand_total_payable = $_POST['ProductStockEntries']['grand_total_payable'];
            $grand_total_paid = $_POST['ProductStockEntries']['grand_total_paid'];
            $grand_total_balance = $_POST['ProductStockEntries']['grand_total_balance'];
            $due_payment_date = date('Y-m-d', strtotime($_POST['ProductStockEntries']['due_payment_date']));
            $payment_type = $_POST['ProductStockEntries']['payment_type'];
            $note = $_POST['ProductStockEntries']['note'];
            $purchase_id = $this->generatePurchaseId();

            $ar_product_details_id = array();
            $ar_product_details_name = array();
            $ar_ref_num = array();
            $ar_quantity = array();
            $ar_purchase_price = array();
            $ar_selling_price = array();
            $ar_item_subtotal = array();
            $ar_serial_num = array();
            $ar_cur_stock = array();

            $limit = sizeof($_POST['ProductStockEntries']['product_details_id']);
            $count = 0;

            for ($i = 0; $i < $limit; $i++) {

                $model = new ProductStockEntries;

                $model->billnumber = $bill_number;
                $model->purchase_date = $purchase_date;
                $model->supplier_id = (!empty($supplier_id)) ? $supplier_id : NULL;
                $model->grand_total_payable = $grand_total_payable;
                $model->grand_total_paid = $grand_total_paid;
                $model->grand_total_balance = $grand_total_balance;
                $model->due_payment_date = $due_payment_date;
                $model->payment_type = $payment_type;
                $model->note = $note;
                $model->purchase_id = $purchase_id;
                $model->store_id = $store_id;

                $model->product_details_id = $_POST['ProductStockEntries']['product_details_id'][$i];
                $model->ref_num = $_POST['ProductStockEntries']['ref_num'][$i];
                $model->quantity = intval($_POST['ProductStockEntries']['quantity'][$i]);
                $model->purchase_price = $_POST['ProductStockEntries']['purchase_price'][$i];
                $model->selling_price = $_POST['ProductStockEntries']['selling_price'][$i];
                $model->item_subtotal = $_POST['ProductStockEntries']['item_subtotal'][$i];
                $model->serial_num = $i;

                if (!$model->validate()) {
                    $ar_product_details_id[] = $model->product_details_id;
                    $ar_product_details_name[] = $_POST['ProductStockEntries']['product_details_name'][$i];
                    $ar_ref_num[] = $model->ref_num;
                    $ar_quantity[] = $model->quantity;
                    $ar_purchase_price[] = $model->purchase_price;
                    $ar_selling_price[] = $model->selling_price;
                    $ar_item_subtotal[] = $model->item_subtotal;
                    $ar_serial_num[] = $model->serial_num;
                    $ar_cur_stock[] = $_POST['cur_stock'][$i];
                } else {

                    $stock_info = $stock_info->getStockByProdId((int) $model->product_details_id, $store_id);

                    if (!$stock_info) {

                        $stock_info = new ProductStockAvail;
                        $stock_info->quantity = $model->quantity;
                        $stock_info->product_details_id = $model->product_details_id;
                        $stock_info->store_id = $store_id;
                        $stock_info->insert();
                    } else {

                        $cur_stock = intval($stock_info->quantity);
                        $new_stock = $cur_stock + $model->quantity;

                        $stock_info->quantity = $new_stock;
                        $stock_info->update();

                        $criteria = new CDbCriteria;
                        $criteria->compare('t.id', $model->product_details_id);
                        $criteria->compare('t.store_id', $store_id);

                        $prod_details = ProductDetails::model()->find($criteria);
                        $prod_details->purchase_price = $model->purchase_price;
                        $prod_details->selling_price = $model->selling_price;
                        $prod_details->update_date = date('Y-m-d H:i:s', time());
                        $prod_details->update();
                    }

                    if ($model->insert()) {
                        $count++;
                    }
                }
            }

            if ($count == $limit) {
                Yii::app()->user->setFlash('success', 'Products successfully added to stock.');
                $this->redirect(array('create'));
            }

            $ar_cart['product_details_id'] = $ar_product_details_id;
            $ar_cart['product_details_name'] = $ar_product_details_name;
            $ar_cart['ref_num'] = $ar_ref_num;
            $ar_cart['quantity'] = $ar_quantity;
            $ar_cart['purchase_price'] = $ar_purchase_price;
            $ar_cart['selling_price'] = $ar_selling_price;
            $ar_cart['item_subtotal'] = $ar_item_subtotal;
            $ar_cart['serial_num'] = $ar_serial_num;
            $ar_cart['cur_stock'] = $ar_cur_stock;
        }

        $this->render('create', array(
            'model' => $model,
            'ar_cart' => $ar_cart,
        ));
    }

    public function actionCreatesingle() {
        $model = new ProductStockEntries;

        $this->pageTitle = Yii::app()->name . ' - Purchase Product';

        $store_id = 1;
        if (!Yii::app()->user->isSuperAdmin) {
            $store_id = Yii::app()->user->storeId;
        }

        $ar_cart = array();

//        var_dump($_POST['ProductStockEntries']);exit;
        
        if (isset($_POST['ProductStockEntries'])) {
            $stock_info = new ProductStockAvail;

            $bill_number = $_POST['ProductStockEntries']['billnumber'];
            $purchase_date = date('Y-m-d', strtotime($_POST['ProductStockEntries']['purchase_date']));
            $supplier_id = $_POST['ProductStockEntries']['supplier_id'];
            $grand_total_payable = $_POST['ProductStockEntries']['grand_total_payable'];
            $grand_total_paid = $_POST['ProductStockEntries']['grand_total_paid'];
            $grand_total_balance = $_POST['ProductStockEntries']['grand_total_balance'];
            $due_payment_date = date('Y-m-d', strtotime($_POST['ProductStockEntries']['due_payment_date']));
            $payment_type = $_POST['ProductStockEntries']['payment_type'];
            $note = $_POST['ProductStockEntries']['note'];
            $purchase_id = $this->generatePurchaseId();
            
            $model = new ProductStockEntries;

            $model->billnumber = $bill_number;
            $model->purchase_date = $purchase_date;
            $model->supplier_id = (!empty($supplier_id)) ? $supplier_id : NULL;
            $model->grand_total_payable = $grand_total_payable;
            $model->grand_total_paid = $grand_total_paid;
            $model->grand_total_balance = $grand_total_balance;
            $model->due_payment_date = $due_payment_date;
            $model->payment_type = $payment_type;
            $model->note = $note;
            $model->purchase_id = $purchase_id;
            $model->store_id = $store_id;

            $model->product_details_id = $_POST['product_details_id'];
            $model->ref_num = $_POST['ref_num'];
            $model->quantity = intval($_POST['quantity']);
            $model->purchase_price = $_POST['purchase_price'];
            $model->selling_price = $_POST['selling_price'];
            $model->item_subtotal = $_POST['item_subtotal'];
            $model->serial_num = 0;

            if ($model->validate()) {

                $stock_info = $stock_info->getStockByProdId((int) $model->product_details_id, $store_id);

                if (!$stock_info) {

                    $stock_info = new ProductStockAvail;
                    $stock_info->quantity = $model->quantity;
                    $stock_info->product_details_id = $model->product_details_id;
                    $stock_info->store_id = $store_id;
                    $stock_info->insert();
                    
                } else {

                    $cur_stock = intval($stock_info->quantity);
                    $new_stock = $cur_stock + $model->quantity;

                    $stock_info->quantity = $new_stock;
                    $stock_info->update();

                    $criteria = new CDbCriteria;
                    $criteria->compare('t.id', $model->product_details_id);
                    $criteria->compare('t.store_id', $store_id);

                    $prod_details = ProductDetails::model()->find($criteria);
                    $prod_details->purchase_price = $model->purchase_price;
                    $prod_details->selling_price = $model->selling_price;
                    $prod_details->update_date = date('Y-m-d H:i:s', time());
                    $prod_details->update();
                }

                if ($model->insert()) {
                    Yii::app()->user->setFlash('success', 'Products successfully added to stock.');
                    $this->redirect(array('create'));
                }
            }
        }

        $this->render('create', array(
            'model' => $model,
            'ar_cart' => $ar_cart,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (!Yii::app()->user->isSuperAdmin) {
            $store_id = Yii::app()->user->storeId;
        } else {
            $store_id = 1;
        }

        if (isset($_POST['ProductStockEntries'])) {
            $model->attributes = $_POST['ProductStockEntries'];

            $model->store_id = $store_id;

            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id));
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
        $this->loadModel($id)->delete();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    public function actionPrint() {

        $id = Yii::app()->request->getParam('purchase_id');

        $model = new ProductStockEntries;
        $model = $model->getPurchase($id);

        $this->render('print', array(
            'model' => $model,
        ));
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {

        $model = new ProductStockEntries();
        $pageSize = 0;

        if (!Yii::app()->user->isSuperAdmin) {
            $store_id = Yii::app()->user->storeId;
        } else {
            $store_id = 1;
        }

        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['ProductStockEntries'])) {
            if (isset($_GET['ProductStockEntries'])) {
                if (isset($_GET['ProductStockEntries']['id']) && !empty($_GET['ProductStockEntries']['id'])) {
                    $model->purchase_id = $_GET['ProductStockEntries']['id'];
                }

                if (isset($_GET['ProductStockEntries']['product_name']) && !empty($_GET['ProductStockEntries']['product_name'])) {
                    $model->product_name = $_GET['ProductStockEntries']['product_name'];
                }

                if (isset($_GET['ProductStockEntries']['grand_total_paid']) && !empty($_GET['ProductStockEntries']['grand_total_paid'])) {
                    $model->grand_total_paid = $_GET['ProductStockEntries']['grand_total_paid'];
                }
            }
        }

        if (isset($_GET['pageSize'])) {
            $pageSize = (int) $_GET['pageSize'];
            $model->pageSize = $pageSize;
            unset($_GET['pageSize']);
        }

        $model->store_id = $store_id;

        $this->render('index', array(
            'model' => $model,
            'pageSize' => $pageSize,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return ProductStockEntries the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = ProductStockEntries::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param ProductStockEntries $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'product-stock-entries-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    /**
     * gets product stock information and latest cost and selling price.
     */
    public function actionProduct_stock_info() {

        if ((Yii::app()->user->isGuest) || (!Yii::app()->request->isAjaxRequest)) {
            throw new CHttpException(403, 'Access Forbidden.');
        }

        $prod_id = Yii::app()->request->getParam('prod_id');
        $ref_num = Yii::app()->request->getParam('ref_num');

        $cost = 0;
        $price = 0;
        $cur_stock = 0;

        $model = new ProductStockEntries();
        $model = $model->getProductStockInfo($prod_id, $ref_num);

        if (!empty($model)) {
            $cost = ( empty($model['productDetails']->purchase_price) || ($model['productDetails']->purchase_price <= 0 ) ) ? $model->purchase_price : $model['productDetails']->purchase_price;
            $price = ( empty($model['productDetails']->selling_price) || ($model['productDetails']->selling_price <= 0 ) ) ? $model->selling_price : $model['productDetails']->selling_price;
            $cur_stock = $model['productDetails']['productStockAvails']->quantity;
        }

        $response['cost'] = $cost;
        $response['price'] = $price;
        $response['cur_stock'] = $cur_stock;

        echo CJSON::encode($response);
        exit;
    }

    private function generatePurchaseId() {

        $data = Yii::app()->db->createCommand()->select('MAX(id) AS id')->from('cims_product_stock_entries')->queryRow();

        $max_id = (strlen($data['id']) < 2) ? '0' . ($data['id'] + 1) : ($data['id'] + 1);

        return $max_id = 'PD' . $max_id;
    }

}
