<?php

/**
 * This is the model class for table "cims_product_stock_sales".
 *
 * The followings are the available columns in table 'cims_product_stock_sales':
 * @property integer $id
 * @property string $sales_id
 * @property integer $transaction_id
 * @property string $billnumber
 * @property integer $customer_id
 * @property integer $supplier_id
 * @property integer $category_id
 * @property string $ref_num
 * @property integer $product_details_id
 * @property integer $quantity
 * @property string $item_selling_price
 * @property integer $serial_num
 * @property string $sale_date
 * @property string $item_subtotal
 * @property string $discount_percentage
 * @property string $dis_amount
 * @property string $tax
 * @property string $tax_dis
 * @property string $grand_total_payable
 * @property string $grand_total_paid
 * @property string $grand_total_balance
 * @property string $due_payment_date
 * @property integer $payment_method
 * @property string $note
 *
 * The followings are the available model relations:
 * @property Transactions $transaction
 * @property CustomerDetails $customer
 * @property SupplierDetails $supplier
 * @property CategoryDetails $category
 * @property ProductDetails $productDetails
 */
class ProductStockSales extends CActiveRecord {

    public $product_name;
    public $pageSize;
    public $advance_sale_list = FALSE;
    
    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'cims_product_stock_sales';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('sales_id, quantity, item_selling_price, serial_num, sale_date, item_subtotal, grand_total_payable, grand_total_paid, grand_total_balance', 'required'),
            array('transaction_id, customer_id, supplier_id, category_id, product_details_id, quantity, serial_num, payment_method', 'numerical', 'integerOnly' => true),
            array('sales_id', 'length', 'max' => 15),
            array('billnumber', 'length', 'max' => 150),
            array('ref_num', 'length', 'max' => 255),
            array('item_selling_price, item_subtotal, discount_percentage, dis_amount, tax, grand_total_payable, grand_total_paid, grand_total_balance', 'length', 'max' => 12),
            array('tax_dis, note', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, sales_id, transaction_id, billnumber, customer_id, supplier_id, category_id, ref_num, product_details_id, quantity, item_selling_price, serial_num, sale_date, item_subtotal, discount_percentage, dis_amount, tax, tax_dis, grand_total_payable, grand_total_paid, grand_total_balance, due_payment_date, payment_method, note', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'transaction' => array(self::BELONGS_TO, 'Transactions', 'transaction_id'),
            'customer' => array(self::BELONGS_TO, 'CustomerDetails', 'customer_id'),
            'supplier' => array(self::BELONGS_TO, 'SupplierDetails', 'supplier_id'),
            'category' => array(self::BELONGS_TO, 'CategoryDetails', 'category_id'),
            'productDetails' => array(self::BELONGS_TO, 'ProductDetails', 'product_details_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'sales_id' => 'Sales',
            'transaction_id' => 'Transaction',
            'billnumber' => 'Billnumber',
            'customer_id' => 'Customer',
            'supplier_id' => 'Supplier',
            'category_id' => 'Category',
            'ref_num' => 'Ref Num',
            'product_details_id' => 'Item',
            'quantity' => 'Qty',
            'item_selling_price' => 'Price',
            'serial_num' => 'Serial Num',
            'sale_date' => 'Sale Date',
            'item_subtotal' => 'Total',
            'discount_percentage' => 'Discount Percentage',
            'dis_amount' => 'Discount',
            'tax' => 'Tax',
            'tax_dis' => 'Tax Dis',
            'grand_total_payable' => 'Grand Total',
            'grand_total_paid' => 'Paid',
            'grand_total_balance' => ($this->advance_sale_list) ?  'Due' : 'Return',
            'due_payment_date' => 'Due Date',
            'payment_method' => 'Payment Type',
            'note' => 'Note',
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
        $criteria->compare('sales_id', $this->sales_id, true);
        $criteria->compare('transaction_id', $this->transaction_id);
        $criteria->compare('billnumber', $this->billnumber, true);
        $criteria->compare('customer_id', $this->customer_id);
        $criteria->compare('supplier_id', $this->supplier_id);
        $criteria->compare('category_id', $this->category_id);
        $criteria->compare('ref_num', $this->ref_num, true);
        $criteria->compare('product_details_id', $this->product_details_id);
        $criteria->compare('quantity', $this->quantity);
        $criteria->compare('item_selling_price', $this->item_selling_price, true);
        $criteria->compare('serial_num', $this->serial_num);
        $criteria->compare('sale_date', $this->sale_date, true);
        $criteria->compare('item_subtotal', $this->item_subtotal, true);
        $criteria->compare('discount_percentage', $this->discount_percentage, true);
        $criteria->compare('dis_amount', $this->dis_amount, true);
        $criteria->compare('tax', $this->tax, true);
        $criteria->compare('tax_dis', $this->tax_dis, true);
        $criteria->compare('grand_total_payable', $this->grand_total_payable, true);
        $criteria->compare('grand_total_paid', $this->grand_total_paid, true);
        $criteria->compare('grand_total_balance', $this->grand_total_balance, true);
        $criteria->compare('due_payment_date', $this->due_payment_date, true);
        $criteria->compare('payment_method', $this->payment_method);
        
        if (!Yii::app()->user->isSuperAdmin) {
            $criteria->compare('t.store_id', $store_id);
        }
        
        $criteria->compare('note', $this->note, true);
        
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return ProductStockSales the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function getSales($id) {
        
        $store_id = 1;
        
        if (!Yii::app()->user->isSuperAdmin) {
            $store_id = Yii::app()->user->storeId;
        }

        $criteria = new CDbCriteria;

        $criteria->with = array('productDetails');
        $criteria->compare('sales_id', $id);
        
        if (!Yii::app()->user->isSuperAdmin) {
            $criteria->compare('productDetails.store_id', $store_id);
            $criteria->compare('t.store_id', $store_id);
        }
        
        $criteria->order = 't.id DESC';

        $data = $this->findAll($criteria);
        $data = $this->formatSalesRecords($data);
        return $data;
    }

    public function formatSalesRecords($obj_sales) {

        $date = date('d-m-Y', strtotime($obj_sales[0]->sale_date));
        $bill_no = $obj_sales[0]->sales_id;
        $g_total_payable = $obj_sales[0]->grand_total_payable;
        $g_total_paid = $obj_sales[0]->grand_total_paid;
        $g_total_balance = $obj_sales[0]->grand_total_balance;
        $dis_amount = (!empty($obj_sales[0]->dis_amount) || (floatval($obj_sales[0]->dis_amount) > 0) ) ? floatval($obj_sales[0]->dis_amount) : 0.00;

        $ar_cart = array();

        $ar_cart['date'] = $date;
        $ar_cart['bill_no'] = $bill_no;
        $ar_cart['g_total_payable'] = $g_total_payable;
        $ar_cart['g_total_paid'] = $g_total_paid;
        $ar_cart['g_total_balance'] = $g_total_balance;
        $ar_cart['dis_amount'] = $dis_amount;

        foreach ($obj_sales as $row) {
            $_data['prod_name'] = $row->productDetails->product_name;
            $_data['qty'] = $row->quantity;
            $_data['price'] = $row->item_selling_price;
            $_data['sub_total'] = $row->item_subtotal;

            $ar_cart[] = $_data;
        }

        return $ar_cart;
    }

    public function saleList() {
        // @todo Please modify the following code to remove attributes that should not be searched.
        $store_id = 1;
        
        if (!Yii::app()->user->isSuperAdmin) {
            $store_id = Yii::app()->user->storeId;
        }
        
        $criteria = new CDbCriteria;
        //var_dump($this->id);exit;
        $criteria->select = 't.sales_id AS id, t.grand_total_payable';
        $criteria->with = array(
            'productDetails' => array(
                'select' => 'GROUP_CONCAT(productDetails.product_name) as product_name',
            ),
        );

        $criteria->compare('t.sales_id', $this->sales_id, true);
        $criteria->compare('product_name', $this->product_name, true);
        $criteria->compare('t.grand_total_payable', $this->grand_total_payable, true);
        
        if($this->advance_sale_list) {
            $criteria->compare('is_advance', 1);
        } else {
            $criteria->compare('is_advance !', 1);
        }
        
        if (!Yii::app()->user->isSuperAdmin) {
            $criteria->compare('productDetails.store_id', $store_id);
            $criteria->compare('t.store_id', $store_id);
        }
        
        $criteria->together = true;
        $criteria->group = 't.sales_id';
        $criteria->order = 't.id DESC';

        return new CActiveDataProvider($this, array(
            'pagination' => array(
                'pageSize' => $this->pageSize,
            ),
            'criteria' => $criteria,
        ));
    }
    
    public function saleReportData($from_date, $to_date) {
        
        $store_id = 1;
        
        if (!Yii::app()->user->isSuperAdmin) {
            $store_id = Yii::app()->user->storeId;
        }
        
        $from_date = (!empty($from_date)) ? $from_date : date('Y-m-d', Settings::getBdLocalTime());
        $to_date = (!empty($to_date)) ? $to_date : date('Y-m-d', Settings::getBdLocalTime());
        
        $criteria = new CDbCriteria;
        //var_dump($this->id);exit;
        $criteria->select = 't.id, t.sales_id, t.ref_num, t.quantity, t.serial_num, t.item_selling_price, t.item_subtotal, t.dis_amount, t.grand_total_paid, t.grand_total_balance, t.grand_total_payable, t.is_advance';
        $criteria->with = array(
            'productDetails' => array(
                'select' => 'productDetails.product_name',
                'joinType' => 'LEFT JOIN',
            ),
        );

        $criteria->compare('DATE(t.sale_date) >', $from_date);
        $criteria->compare('DATE(t.sale_date) <', $to_date);
        
        if($this->advance_sale_list) {
            $criteria->compare('is_advance', 1);
        }
        
        if (!Yii::app()->user->isSuperAdmin) {
            $criteria->compare('productDetails.store_id', $store_id);
            $criteria->compare('t.store_id', $store_id);
        }
        
        $criteria->together = true;
        $criteria->order = 't.id DESC';
        
        $data = $this->findAll($criteria);
        
        return (!empty($data)) ? $this->formatSaleReportData($data) : FALSE;
    }
    
    private function formatSaleReportData($obj_data) {
        
        $formatted_data = array();
        
        foreach ($obj_data as $row) {
            $sale_ids[] = $row->sales_id;
        }
        
        $sale_ids = array_unique($sale_ids);
        
        foreach ($sale_ids as $sale_id){
            
            $_data = array();
            foreach ($obj_data as $row) {
                
                if ($sale_id == $row->sales_id){
                    
                    $_data['bill_total'] = ( empty($row->grand_total_payable) || ($row->grand_total_payable <= 0) ) ? 0.00 : $row->grand_total_payable;
                    $_data['amount_given'] = ( empty($row->grand_total_paid) || ($row->grand_total_paid <= 0) ) ? 0.00 : $row->grand_total_paid;
                    $_data['discount'] = ( empty($row->dis_amount) || ($row->dis_amount <= 0) ) ? 0.00 : $row->dis_amount;
                    $_data['balance'] = ( empty($row->grand_total_balance) || ($row->grand_total_balance <= 0) ) ? 0.00 : $row->grand_total_balance;
                    
                    $cart['prod_name'] = $row->productDetails->product_name;
                    $cart['is_advance'] = $row->is_advance;
                    $cart['ref_num'] = $row->ref_num;
                    $cart['qty'] = $row->quantity;
                    $cart['price'] = $row->item_selling_price;
                    $cart['item_sub_total'] = $row->item_subtotal;
                    
                    $_data[] = $cart;
                }
                
            }
            
            $formatted_data[$sale_id][] = $_data;
            
        }
        
        return $formatted_data;
    }

    public function getSalesInfo($id = NULL, $sale_id = NULL, $ref_num = NULL, $prod_id = NULL) {
        
        $store_id = 1;
        
        if (!Yii::app()->user->isSuperAdmin) {
            $store_id = Yii::app()->user->storeId;
        }
        
        $criteria = new CDbCriteria();
        
        if(!empty($id)){
            $criteria->compare('t.id', $id);
        }
        
        if(!empty($sale_id)){
            $criteria->compare('t.sales_id', $sale_id);
        }
        
        if(!empty($ref_num)){
            $criteria->compare('t.ref_num', $ref_num);
        }
        
        if(!empty($prod_id)){
            $criteria->compare('t.product_details_id', $prod_id);
        }
        
        $criteria->with = array(
            'productDetails' => array(
                'select' => 'productDetails.id, productDetails.product_name',
                'joinType' => 'INNER JOIN',
            ),
        );
        
        if (!Yii::app()->user->isSuperAdmin) {
            $criteria->compare('productDetails.store_id', $store_id);
            $criteria->compare('t.store_id', $store_id);
        }
        
        if( (!empty($sale_id) && !empty($ref_num) && !empty($prod_id)) || (!empty($id)) ){
            $model = $this->find($criteria);
        }  else {
            $model = $this->findAll($criteria);
        }
        
        return $model;
    }
    
}
