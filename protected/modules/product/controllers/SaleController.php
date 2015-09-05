<?php

class SaleController extends Controller {

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
                'actions' => array('index', 'advance_sale', 'advance_sale_list', 'view', 'create', 'update', 'product_stock_info', 'print'),
                'users' => array('@'),
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
        $this->redirect(array('print', 'sales_id' => $id));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {

        $model = new ProductStockSales;
        $edit = FALSE;
        $model->advance_sale_list = FALSE;

        $this->pageTitle = Yii::app()->name . ' - Sale';

        if (!Yii::app()->user->isSuperAdmin) {
            $store_id = Yii::app()->user->storeId;
        } else {
            $store_id = 1;
        }

        $ar_cart = array();

        if (isset($_POST['ProductStockSales'])) {
            $stock_info = new ProductStockAvail;

            $bill_number = $_POST['ProductStockSales']['billnumber'];
            $sale_date = date('Y-m-d', strtotime($_POST['ProductStockSales']['sale_date']));
            $dis_amount = $_POST['ProductStockSales']['dis_amount'];
            $grand_total_payable = $_POST['ProductStockSales']['grand_total_payable'];
            $grand_total_paid = $_POST['ProductStockSales']['grand_total_paid'];
            $grand_total_balance = $_POST['ProductStockSales']['grand_total_balance'];
            $due_payment_date = date('Y-m-d', strtotime($_POST['ProductStockSales']['due_payment_date']));
            $payment_type = $_POST['ProductStockSales']['payment_method'];
            $note = $_POST['ProductStockSales']['note'];
            $sales_id = $this->generateSalesId();

            $ar_product_details_id = array();
            $ar_product_details_name = array();
            $ar_ref_num = array();
            $ar_quantity = array();
            $ar_purchase_price = array();
            $ar_selling_price = array();
            $ar_item_subtotal = array();
            $ar_serial_num = array();
            $ar_cur_stock = array();

            $limit = sizeof($_POST['ProductStockSales']['product_details_id']);
            $count = 0;

            for ($i = 0; $i < $limit; $i++) {

                $model = new ProductStockSales;

                $model->billnumber = $bill_number;
                $model->sale_date = $sale_date;
                $model->supplier_id = (!empty($supplier_id)) ? $supplier_id : NULL;
                $model->dis_amount = $dis_amount;
                $model->grand_total_payable = $grand_total_payable;

                if (floatval($grand_total_paid) > 0) {
                    $model->grand_total_paid = $grand_total_paid;
                }

                $model->grand_total_balance = $grand_total_balance;
                $model->due_payment_date = $due_payment_date;
                $model->payment_method = $payment_type;
                $model->note = $note;
                $model->sales_id = $sales_id;
                $model->store_id = $store_id;

                $model->product_details_id = $_POST['ProductStockSales']['product_details_id'][$i];
                $model->ref_num = $_POST['ProductStockSales']['ref_num'][$i];
                $model->quantity = intval($_POST['ProductStockSales']['quantity'][$i]);
                $model->item_selling_price = $_POST['ProductStockSales']['item_selling_price'][$i];
                $model->item_subtotal = $_POST['ProductStockSales']['item_subtotal'][$i];
                $model->serial_num = $i;

                if (!$model->validate()) {
                    $ar_product_details_id[] = $model->product_details_id;
                    $ar_product_details_name[] = $_POST['ProductStockSales']['product_details_name'][$i];
                    $ar_ref_num[] = $model->ref_num;
                    $ar_quantity[] = $model->quantity;
                    $ar_selling_price[] = $model->item_selling_price;
                    $ar_item_subtotal[] = $model->item_subtotal;
                    $ar_serial_num[] = $model->serial_num;
                    $ar_cur_stock[] = $_POST['cur_stock'][$i];
                } else {

                    $stock_info = $stock_info->getStockByProdId((int) $model->product_details_id, $store_id);

                    $cur_stock = intval($stock_info->quantity);

                    if (($cur_stock > 0) && ($model->quantity <= $cur_stock)) {

                        $new_stock = $cur_stock - $model->quantity;

                        $stock_info->quantity = $new_stock;
                        $stock_info->update();

                        if ($model->insert()) {
                            $count++;
                        }
                    }
                }
            }

            if ($count == $limit) {
                Yii::app()->user->setFlash('success', 'Products successfully sold.');
                $this->redirect(array('print', 'sales_id' => $model->sales_id));
            }

            $ar_cart['product_details_id'] = $ar_product_details_id;
            $ar_cart['product_details_name'] = $ar_product_details_name;
            $ar_cart['ref_num'] = $ar_ref_num;
            $ar_cart['quantity'] = $ar_quantity;
            $ar_cart['selling_price'] = $ar_selling_price;
            $ar_cart['item_subtotal'] = $ar_item_subtotal;
            $ar_cart['serial_num'] = $ar_serial_num;
            $ar_cart['cur_stock'] = $ar_cur_stock;
        }

        $this->render('create', array(
            'model' => $model,
            'ar_cart' => $ar_cart,
            'edit' => $edit,
        ));
    }

    public function actionAdvance_sale() {

        $model = new ProductStockSales;
        $edit = FALSE;
        $model->advance_sale_list = TRUE;

        $this->pageTitle = Yii::app()->name . ' - Advance Sale Order';

        if (!Yii::app()->user->isSuperAdmin) {
            $store_id = Yii::app()->user->storeId;
        } else {
            $store_id = 1;
        }

        $ar_cart = array();

        if (isset($_POST['ProductStockSales'])) {
            $stock_info = new ProductStockAvail;

            $bill_number = $_POST['ProductStockSales']['billnumber'];
            $sale_date = date('Y-m-d', strtotime($_POST['ProductStockSales']['sale_date']));
            $dis_amount = $_POST['ProductStockSales']['dis_amount'];
            $grand_total_payable = $_POST['ProductStockSales']['grand_total_payable'];
            $grand_total_paid = $_POST['ProductStockSales']['grand_total_paid'];
            $grand_total_balance = $_POST['ProductStockSales']['grand_total_balance'];
            $due_payment_date = date('Y-m-d', strtotime($_POST['ProductStockSales']['due_payment_date']));
            $payment_type = $_POST['ProductStockSales']['payment_method'];
            $note = $_POST['ProductStockSales']['note'];
            $sales_id = $this->generateSalesId();

            $ar_product_details_id = array();
            $ar_product_details_name = array();
            $ar_ref_num = array();
            $ar_quantity = array();
            $ar_purchase_price = array();
            $ar_selling_price = array();
            $ar_item_subtotal = array();
            $ar_serial_num = array();
            $ar_cur_stock = array();

            $limit = sizeof($_POST['ProductStockSales']['product_details_id']);
            $count = 0;

            for ($i = 0; $i < $limit; $i++) {

                $model = new ProductStockSales;

                $model->billnumber = $bill_number;
                $model->sale_date = $sale_date;
                $model->supplier_id = (!empty($supplier_id)) ? $supplier_id : NULL;
                $model->dis_amount = $dis_amount;
                $model->grand_total_payable = $grand_total_payable;

                if (floatval($grand_total_paid) > 0) {
                    $model->grand_total_paid = $grand_total_paid;
                }

                $model->grand_total_balance = $grand_total_balance;
                $model->due_payment_date = $due_payment_date;
                $model->payment_method = $payment_type;
                $model->note = $note;
                $model->sales_id = $sales_id;
                $model->store_id = $store_id;

                $model->product_details_id = $_POST['ProductStockSales']['product_details_id'][$i];
                $model->ref_num = $_POST['ProductStockSales']['ref_num'][$i];
                $model->quantity = intval($_POST['ProductStockSales']['quantity'][$i]);
                $model->item_selling_price = $_POST['ProductStockSales']['item_selling_price'][$i];
                $model->item_subtotal = $_POST['ProductStockSales']['item_subtotal'][$i];
                $model->serial_num = $i;
                $model->is_advance = 1;

                if (!$model->validate()) {
                    $ar_product_details_id[] = $model->product_details_id;
                    $ar_product_details_name[] = $_POST['ProductStockSales']['product_details_name'][$i];
                    $ar_ref_num[] = $model->ref_num;
                    $ar_quantity[] = $model->quantity;
                    $ar_selling_price[] = $model->item_selling_price;
                    $ar_item_subtotal[] = $model->item_subtotal;
                    $ar_serial_num[] = $model->serial_num;
                    $ar_cur_stock[] = $_POST['cur_stock'][$i];
                } else {

                    $stock_info = $stock_info->getStockByProdId((int) $model->product_details_id, $store_id);

                    $cur_stock = intval($stock_info->quantity);

                    if (($cur_stock > 0) && ($model->quantity <= $cur_stock)) {

                        $new_stock = $cur_stock - $model->quantity;

                        $stock_info->quantity = $new_stock;
                        $stock_info->update();

                        if ($model->insert()) {
                            $count++;
                        }
                    }
                }
            }

            if ($count == $limit) {
                Yii::app()->user->setFlash('success', 'Products successfully sold.');
                $this->redirect(array('print', 'sales_id' => $model->sales_id));
            }

            $ar_cart['product_details_id'] = $ar_product_details_id;
            $ar_cart['product_details_name'] = $ar_product_details_name;
            $ar_cart['ref_num'] = $ar_ref_num;
            $ar_cart['quantity'] = $ar_quantity;
            $ar_cart['selling_price'] = $ar_selling_price;
            $ar_cart['item_subtotal'] = $ar_item_subtotal;
            $ar_cart['serial_num'] = $ar_serial_num;
            $ar_cart['cur_stock'] = $ar_cur_stock;
        }

        $this->render('create', array(
            'model' => $model,
            'ar_cart' => $ar_cart,
            'edit' => $edit,
        ));
    }

    public function actionAdvance_sale_list() {
        $model = new ProductStockSales();
        $pageSize = 0;

        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['ProductStockSales'])) {
            if (isset($_GET['ProductStockSales']['id']) && !empty($_GET['ProductStockSales']['id'])) {
                $model->sales_id = $_GET['ProductStockSales']['id'];
            }

            if (isset($_GET['ProductStockSales']['product_name']) && !empty($_GET['ProductStockSales']['product_name'])) {
                $model->product_name = $_GET['ProductStockSales']['product_name'];
            }

            if (isset($_GET['ProductStockSales']['grand_total_paid']) && !empty($_GET['ProductStockSales']['grand_total_paid'])) {
                $model->grand_total_paid = $_GET['ProductStockSales']['grand_total_paid'];
            }
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
        $model->advance_sale_list = TRUE;
        
        $this->render('index', array(
            'model' => $model,
            'pageSize' => $pageSize,
        ));
    }

    public function actionPrint() {

        $id = Yii::app()->request->getParam('sales_id');

        $model = new ProductStockSales;
        $model = $model->getSales($id);

        if (!Yii::app()->user->isSuperAdmin) {
            $store_id = Yii::app()->user->storeId;
        } else {
            $store_id = 1;
        }

        $store = StoreDetails::model()->findByPk($store_id);

        $this->render('print', array(
            'model' => $model,
            'store' => $store,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {

        $model = new ProductStockSales;
        $model_data = $model->getSalesInfo(NULL, $id);
        $edit = TRUE;
        $model->isNewRecord = FALSE;
        
        $cur_date = strtotime(date('Y-m-d', Settings::getBdLocalTime()));
        $sale_date = strtotime($model_data[0]->sale_date);
        
        $model->advance_sale_list = FALSE;
        
        if($sale_date > $cur_date) {
            $model->advance_sale_list = TRUE;
        }

        if (!Yii::app()->user->isSuperAdmin) {
            $store_id = Yii::app()->user->storeId;
        } else {
            $store_id = 1;
        }

        if (isset($_POST['ProductStockSales'])) {

            $bill_number = $_POST['ProductStockSales']['billnumber'];
            $sale_date = date('Y-m-d', strtotime($_POST['ProductStockSales']['sale_date']));
            $due_payment_date = date('Y-m-d', strtotime($_POST['ProductStockSales']['due_payment_date']));
            $note = $_POST['ProductStockSales']['note'];
            $payment_type = $_POST['ProductStockSales']['payment_method'];

            $dis_amount = $_POST['ProductStockSales']['dis_amount'];
            $grand_total_payable = $_POST['ProductStockSales']['grand_total_payable'];
            $grand_total_paid = $_POST['ProductStockSales']['grand_total_paid'];
            $grand_total_balance = $_POST['ProductStockSales']['grand_total_balance'];

            $limit = sizeof($_POST['ProductStockSales']['product_details_id']);
            $count = 0;

            for ($i = 0; $i < $limit; $i++) {

                $prod_sale = new ProductStockSales;

                $sale_id = $model_data[0]->sales_id;
                $ref_num = $_POST['ProductStockSales']['ref_num'][$i];
                $prod_id = $_POST['ProductStockSales']['product_details_id'][$i];

                $model = $prod_sale->getSalesInfo(NULL, $sale_id, $ref_num, $prod_id);

                $model->billnumber = $bill_number;
                $model->sale_date = $sale_date;
                $model->due_payment_date = $due_payment_date;
                $model->note = $note;
                $model->payment_method = $payment_type;

                $model->dis_amount = $dis_amount;
                $model->grand_total_payable = $grand_total_payable;
                $model->grand_total_paid = $grand_total_paid;
                $model->grand_total_balance = $grand_total_balance;
                $model->store_id = $store_id;

                if ($model->update()) {
                    $count++;
                }
            }

            if ($count == $limit) {
                Yii::app()->user->setFlash('success', 'Products successfully sold.');
                $this->redirect(array('print', 'sales_id' => $model->sales_id));
            }
        }

        $ar_cart = array();

        $ar_product_details_id = array();
        $ar_product_details_name = array();
        $ar_ref_num = array();
        $ar_quantity = array();
        $ar_purchase_price = array();
        $ar_selling_price = array();
        $ar_item_subtotal = array();
        $ar_serial_num = array();
        $ar_cur_stock = array();

        foreach ($model_data as $row) {
            $ar_product_details_id[] = $row->product_details_id;
            $ar_product_details_name[] = $row['productDetails']->product_name;
            $ar_ref_num[] = $row->ref_num;
            $ar_quantity[] = $row->quantity;
            $ar_selling_price[] = $row->item_selling_price;
            $ar_item_subtotal[] = $row->item_subtotal;
            $ar_serial_num[] = $row->serial_num;
            $ar_cur_stock[] = 0;

            $model->billnumber = $row->billnumber;
            $model->sale_date = $row->sale_date;
            $model->supplier_id = $row->supplier_id;
            $model->dis_amount = $row->dis_amount;
            $model->grand_total_payable = $row->grand_total_payable;
            $model->grand_total_paid = $row->grand_total_paid;
            $model->grand_total_balance = $row->grand_total_balance;
            $model->due_payment_date = $row->due_payment_date;
            $model->payment_method = $row->payment_method;
            $model->note = $row->note;
            $model->sales_id = $row->sales_id;
        }

        $ar_cart['product_details_id'] = $ar_product_details_id;
        $ar_cart['product_details_name'] = $ar_product_details_name;
        $ar_cart['ref_num'] = $ar_ref_num;
        $ar_cart['quantity'] = $ar_quantity;
        $ar_cart['selling_price'] = $ar_selling_price;
        $ar_cart['item_subtotal'] = $ar_item_subtotal;
        $ar_cart['serial_num'] = $ar_serial_num;
        $ar_cart['cur_stock'] = $ar_cur_stock;

        $this->render('update', array(
            'model' => $model,
            'ar_cart' => $ar_cart,
            'edit' => $edit,
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
     * Manages all models.
     */
    public function actionIndex() {

        $model = new ProductStockSales();
        $pageSize = 0;

        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['ProductStockSales'])) {
            if (isset($_GET['ProductStockSales']['id']) && !empty($_GET['ProductStockSales']['id'])) {
                $model->sales_id = $_GET['ProductStockSales']['id'];
            }

            if (isset($_GET['ProductStockSales']['product_name']) && !empty($_GET['ProductStockSales']['product_name'])) {
                $model->product_name = $_GET['ProductStockSales']['product_name'];
            }

            if (isset($_GET['ProductStockSales']['grand_total_paid']) && !empty($_GET['ProductStockSales']['grand_total_paid'])) {
                $model->grand_total_paid = $_GET['ProductStockSales']['grand_total_paid'];
            }
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

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return ProductStockSales the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = ProductStockSales::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param ProductStockSales $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'product-stock-sales-form') {
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

        $response = array();
        $ref_num = Yii::app()->request->getParam('ref_num');
        $prod_id = Yii::app()->request->getParam('prod_id');
        $prod_id = (!empty($prod_id)) ? $prod_id : '';

        $cur_stock = 0;

        $model = new ProductStockEntries();

        $model = $model->getProductStockInfo($prod_id, $ref_num, true);

        if (!empty($model)) {
            $romatted_data = $this->formatProdInfo($model);
            $response['response'] = $romatted_data;
        }
        echo CJSON::encode($response);
        Yii::app()->end();
    }

    private function generateSalesId() {

        $data = Yii::app()->db->createCommand()->select('MAX(id) AS id')->from('cims_product_stock_sales')->queryRow();

        $max_id = (strlen($data['id']) < 2) ? '0' . ($data['id'] + 1) : ($data['id'] + 1);

        return $max_id = 'SD' . $max_id;
    }

    private function formatProdInfo($prods) {

        $response = array();

        foreach ($prods as $row) {

            $_data['product_id'] = $row['productDetails']->id;
            $_data['product_name'] = $row['productDetails']->product_name;
            $_data['price'] = ( empty($row['productDetails']->selling_price) || ($row['productDetails']->selling_price <= 0) ) ? $row->selling_price : $row['productDetails']->selling_price;
            $_data['cur_stock'] = $row['productDetails']['productStockAvails']->quantity;
            $response[] = $_data;
        }

        return $response;
    }

}
