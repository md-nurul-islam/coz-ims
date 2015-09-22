<?php

/**
 * This is the model class for table "cims_product_stock_entries".
 *
 * The followings are the available columns in table 'cims_product_stock_entries':
 * @property integer $id
 * @property string $purchase_id
 * @property string $billnumber
 * @property string $ref_num
 * @property integer $supplier_id
 * @property integer $category_id
 * @property integer $product_details_id
 * @property integer $quantity
 * @property string $purchase_price
 * @property string $selling_price
 * @property string $purchase_date
 * @property integer $payment_type
 * @property string $item_subtotal
 * @property string $note
 * @property integer $grand_total_payable
 * @property string $grand_total_paid
 * @property string $grand_total_balance
 * @property string $due_payment_date
 * @property integer $serial_num
 *
 * The followings are the available model relations:
 * @property ProductDetails $productDetais
 * @property SupplierDetails $supplier
 * @property CategoryDetails $category
 */
class ProductStockEntries extends CActiveRecord {

    public $product_name;
    public $pageSize;

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'cims_product_stock_entries';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('purchase_id, supplier_id, product_details_id, quantity, purchase_price, selling_price, purchase_date, payment_type, item_subtotal, grand_total_payable, grand_total_paid, grand_total_balance, serial_num', 'required'),
            array('supplier_id, category_id, product_details_id, quantity, payment_type, serial_num', 'numerical', 'integerOnly' => true),
            array('purchase_id', 'length', 'max' => 15),
            array('billnumber', 'length', 'max' => 120),
            array('ref_num', 'length', 'max' => 150),
            array('purchase_price, selling_price, item_subtotal, grand_total_paid, grand_total_balance', 'length', 'max' => 12),
            array('note', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, purchase_id, billnumber, ref_num, supplier_id, category_id, product_details_id, quantity, purchase_price, selling_price, purchase_date, payment_type, item_subtotal, note, grand_total_payable, grand_total_paid, grand_total_balance, due_payment_date, serial_num', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'productDetails' => array(self::BELONGS_TO, 'ProductDetails', 'product_details_id',
//                'select'=>'productDetails.id, productDetails.product_name',
//                'joinType'=>'INNER JOIN',
                'with' => 'productStockAvails'
            ),
            'supplier' => array(self::BELONGS_TO, 'SupplierDetails', 'supplier_id'),
            'category' => array(self::BELONGS_TO, 'CategoryDetails', 'category_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'purchase_id' => 'Purchase ID',
            'billnumber' => 'Billnumber',
            'ref_num' => 'Ref Num',
            'supplier_id' => 'Supplier',
            'category_id' => 'Category',
            'product_details_id' => 'Item',
            'quantity' => 'Qty',
            'purchase_price' => 'Cost',
            'selling_price' => 'Sale',
            'purchase_date' => 'Date',
            'payment_type' => 'Payment Type',
            'item_subtotal' => 'Total',
            'note' => 'Note',
            'grand_total_payable' => 'Grand Total',
            'grand_total_paid' => 'Paid',
            'grand_total_balance' => 'Balance',
            'due_payment_date' => 'Due Date',
            'serial_num' => 'Serial Num',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     *
     * Typical usecase:
     * - Initialize the model fields with values from filter form.
     * - Execute this method to get CActiveDataProvider instance which will filter
     * models according to data in model fields.
     * - Pass data provider to CGridView, CListView or any similar widget.
     *
     * @return CActiveDataProvider the data provider that can return the models
     * based on the search/filter conditions.
     */
    public function search() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $store_id = 1;
        if (!Yii::app()->user->isSuperAdmin) {
            $store_id = Yii::app()->user->storeId;
        }

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('purchase_id', $this->purchase_id, true);
        $criteria->compare('billnumber', $this->billnumber, true);
        $criteria->compare('ref_num', $this->ref_num, true);
        $criteria->compare('supplier_id', $this->supplier_id);
        $criteria->compare('category_id', $this->category_id);
        $criteria->compare('product_details_id', $this->product_details_id);
        $criteria->compare('quantity', $this->quantity);
        $criteria->compare('purchase_price', $this->purchase_price, true);
        $criteria->compare('selling_price', $this->selling_price, true);
        $criteria->compare('purchase_date', $this->purchase_date, true);
        $criteria->compare('payment_type', $this->payment_type);
        $criteria->compare('item_subtotal', $this->item_subtotal, true);
        $criteria->compare('note', $this->note, true);
        $criteria->compare('grand_total_payable', $this->grand_total_payable);
        $criteria->compare('grand_total_paid', $this->grand_total_paid, true);
        $criteria->compare('grand_total_balance', $this->grand_total_balance, true);
        $criteria->compare('due_payment_date', $this->due_payment_date, true);
        $criteria->compare('serial_num', $this->serial_num);

        if (!Yii::app()->user->isSuperAdmin) {
            $criteria->compare('store_id', $store_id);
        }

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return ProductStockEntries the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function getProductStockInfo($prod_id = '', $ref_num = '', $all = false) {

        $store_id = 1;

        if (!Yii::app()->user->isSuperAdmin) {
            $store_id = Yii::app()->user->storeId;
        }

        $criteria = new CDbCriteria;
        $criteria->select = 't.id, t.purchase_price, t.selling_price, t.product_details_id';

        $criteria->with = array(
            'productDetails' => array(
                'select' => 'productDetails.id, productDetails.product_name, productDetails.purchase_price, productDetails.selling_price',
            ),
        );

        if (!empty($prod_id)) {
            $criteria->compare('t.product_details_id', $prod_id);
        } else {
            $criteria->group = 't.product_details_id';
        }

        if (!empty($ref_num)) {
            $criteria->compare('t.ref_num', $ref_num);
        }

        if (!Yii::app()->user->isSuperAdmin) {
            $criteria->compare('productDetails.store_id', $store_id);
            $criteria->compare('productStockAvails.store_id', $store_id);
            $criteria->compare('t.store_id', $store_id);
        }

        $criteria->compare('productDetails.status', 1);

        $criteria->order = 't.id DESC';

        if (!$all) {
            $criteria->limit = 1;
            $data = $this->find($criteria);
        } else {
            $data = $this->findAll($criteria);
        }

        return (!empty($data)) ? $data : FALSE;
    }

    public function getPurchase($id) {

        $store_id = 1;

        if (!Yii::app()->user->isSuperAdmin) {
            $store_id = Yii::app()->user->storeId;
        }

        $criteria = new CDbCriteria;

        $criteria->with = array('productDetails');
        $criteria->compare('purchase_id', $id);

        if (!Yii::app()->user->isSuperAdmin) {
            $criteria->compare('productDetails.store_id', $store_id);
            $criteria->compare('productStockAvails.store_id', $store_id);
            $criteria->compare('t.store_id', $store_id);
        }

        $criteria->order = 't.id DESC';

        $data = $this->findAll($criteria);
        $data = $this->formatPurchaseRecords($data);
        return $data;
    }

    public function formatPurchaseRecords($obj_purchase) {

        $date = date('d-m-Y', strtotime($obj_purchase[0]->purchase_date));
        $bill_no = $obj_purchase[0]->purchase_id;
        $g_total_payable = $obj_purchase[0]->grand_total_payable;
        $g_total_paid = $obj_purchase[0]->grand_total_paid;
        $g_total_balance = $obj_purchase[0]->grand_total_balance;

        $ar_cart = array();

        $ar_cart['date'] = $date;
        $ar_cart['bill_no'] = $bill_no;
        $ar_cart['g_total_payable'] = $g_total_payable;
        $ar_cart['g_total_paid'] = $g_total_paid;
        $ar_cart['g_total_balance'] = $g_total_balance;

        foreach ($obj_purchase as $row) {
            $_data['prod_name'] = $row->productDetails->product_name;
            $_data['qty'] = $row->quantity;
            $_data['cost'] = $row->purchase_price;
            $_data['sub_total'] = $row->item_subtotal;

            $ar_cart[] = $_data;
        }

        return $ar_cart;
    }

    public function purchaseList() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $store_id = 1;
        if (!Yii::app()->user->isSuperAdmin) {
            $store_id = Yii::app()->user->storeId;
        }

        $criteria = new CDbCriteria;
        $criteria->select = 't.purchase_id AS id, t.grand_total_paid';
        $criteria->with = array(
            'productDetails' => array(
                'select' => 'GROUP_CONCAT(productDetails.product_name) as product_name',
            ),
        );

        $criteria->compare('t.purchase_id', $this->purchase_id, true);
        $criteria->compare('product_name', $this->product_name, true);
        $criteria->compare('t.grand_total_paid', $this->grand_total_paid, true);

        if (!Yii::app()->user->isSuperAdmin) {
            $criteria->compare('productDetails.store_id', $store_id);
            $criteria->compare('productStockAvails.store_id', $store_id);
            $criteria->compare('t.store_id', $store_id);
        }

        $criteria->together = true;
        $criteria->group = 't.purchase_id';
        $criteria->order = 't.id DESC';

        return new CActiveDataProvider($this, array(
            'pagination' => array(
                'pageSize' => $this->pageSize,
            ),
            'criteria' => $criteria,
        ));
    }

    public function purchaseListForBarcode() {
        $store_id = 1;
        if (!Yii::app()->user->isSuperAdmin) {
            $store_id = Yii::app()->user->storeId;
        }

        $criteria = new CDbCriteria;
        $criteria->select = 't.id, t.purchase_id, t.product_details_id, t.purchase_date, t.quantity, t.selling_price, t.purchase_price';
        $criteria->with = array(
            'productDetails' => array(
                'select' => 'productDetails.product_name, productDetails.supplier_id, productDetails.category_id',
                'joinType' => 'INNER JOIN'
            ),
        );

        if (!Yii::app()->user->isSuperAdmin) {
            $criteria->compare('t.store_id', $store_id);
        }

//        $criteria->addCondition('productStockAvails.quantity > 0');
        $criteria->addCondition('t.ref_num IS NULL');
        $criteria->addCondition("t.ref_num = '0'", 'OR');
        $criteria->addCondition("t.ref_num = ''", 'OR');

        $criteria->order = 't.id DESC';
        $criteria->limit = 100;

        $data = $this->findAll($criteria);
        return (!empty($data)) ? $this->formatPurchaseBarcodeData($data) : FALSE;
    }

    public function purchaseReportData($from_date, $to_date) {

        $store_id = 1;
        if (!Yii::app()->user->isSuperAdmin) {
            $store_id = Yii::app()->user->storeId;
        }

        $from_date = (!empty($from_date)) ? $from_date : date('Y-m-d', Settings::getBdLocalTime());
        $to_date = (!empty($to_date)) ? $to_date : date('Y-m-d', Settings::getBdLocalTime());

        $criteria = new CDbCriteria;
        //var_dump($this->id);exit;
        $criteria->select = 't.id, t.purchase_id, t.ref_num, t.quantity, t.serial_num, t.selling_price, t.item_subtotal, t.grand_total_paid, t.grand_total_balance, t.grand_total_payable';
        $criteria->with = array(
            'productDetails' => array(
                'select' => 'productDetails.product_name',
                'joinType' => 'LEFT JOIN',
            ),
        );

        $criteria->compare('DATE(t.purchase_date) >', $from_date);
        $criteria->compare('DATE(t.purchase_date) <', $to_date);

        if (!Yii::app()->user->isSuperAdmin) {
            $criteria->compare('productDetails.store_id', $store_id);
            $criteria->compare('productStockAvails.store_id', $store_id);
            $criteria->compare('t.store_id', $store_id);
        }

        $criteria->together = true;
        $criteria->order = 't.id DESC';

        $data = $this->findAll($criteria);

        return (!empty($data)) ? $this->formatPurchaseReportData($data) : FALSE;
    }

    private function formatPurchaseReportData($obj_data) {

        $formatted_data = array();

        foreach ($obj_data as $row) {
            $sale_ids[] = $row->purchase_id;
        }

        $sale_ids = array_unique($sale_ids);

        foreach ($sale_ids as $sale_id) {

            $_data = array();
            foreach ($obj_data as $row) {

                if ($sale_id == $row->purchase_id) {

                    $_data['bill_total'] = ( empty($row->grand_total_payable) || ($row->grand_total_payable <= 0) ) ? 0.00 : $row->grand_total_payable;
                    $_data['amount_given'] = ( empty($row->grand_total_paid) || ($row->grand_total_paid <= 0) ) ? 0.00 : $row->grand_total_paid;
                    $_data['discount'] = ( empty($row->dis_amount) || ($row->dis_amount <= 0) ) ? 0.00 : $row->dis_amount;
                    $_data['balance'] = ( empty($row->grand_total_balance) || ($row->grand_total_balance <= 0) ) ? 0.00 : $row->grand_total_balance;

                    $cart['prod_name'] = $row->productDetails->product_name;
                    $cart['ref_num'] = $row->ref_num;
                    $cart['qty'] = $row->quantity;
                    $cart['price'] = $row->selling_price;
                    $cart['item_sub_total'] = $row->item_subtotal;

                    $_data[] = $cart;
                }
            }

            $formatted_data[$sale_id][] = $_data;
        }

        return $formatted_data;
    }

    private function formatPurchaseBarcodeData($obj_data) {

        $formatted_data = array();
        $date = date('ymd');
        
        foreach ($obj_data as $row) {
            
            $code_prefix = Settings::$_num_zeros_for_barcode[strlen($row->id)].$row->id;
            
            $_data['id'] = $row->id;
//            $_data['code'] = $row->purchase_id . $row->product_details_id;
            $_data['code'] = $date.$code_prefix;
            $_data['purchase_price'] = $row->purchase_price;
            $_data['selling_price'] = $row->selling_price;
            $_data['product_name'] = $row->productDetails->product_name;
            $_data['quantity'] = $row->quantity;
            $_data['purchase_date'] = str_replace('-', '', $row->purchase_date);
            
            $formatted_data[] = $_data;
        }

        return $formatted_data;
    }

}
