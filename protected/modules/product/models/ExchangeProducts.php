<?php

/**
 * This is the model class for table "cims_exchange_products".
 *
 * The followings are the available columns in table 'cims_exchange_products':
 * @property integer $id
 * @property string $sales_id
 * @property integer $main_product_details_id
 * @property integer $exchange_product_details_id
 * @property string $grand_total_payable
 * @property string $grand_total_paid
 * @property string $grand_total_balance
 * @property string $due_payment_date
 * @property integer $payment_method
 * @property string $note
 * @property string $dis_amount
 * @property integer $store_id
 *
 * The followings are the available model relations:
 * @property StoreDetails $store
 * @property ProductStockSales $sales
 * @property ProductDetails $mainProductDetails
 * @property ProductDetails $exchangeProductDetails
 */
class ExchangeProducts extends CActiveRecord {
    
    public $main_product_name;
    public $ex_product_name;
    public $pageSize;

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'cims_exchange_products';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('main_product_details_id, exchange_product_details_id, payment_method, store_id', 'numerical', 'integerOnly' => true),
            array('sales_id', 'length', 'max' => 15),
            array('grand_total_payable, grand_total_paid, grand_total_balance, dis_amount', 'length', 'max' => 13),
            array('due_payment_date, note', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, sales_id, main_product_details_id, exchange_product_details_id, grand_total_payable, grand_total_paid, grand_total_balance, due_payment_date, payment_method, note, dis_amount, store_id', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'store' => array(self::BELONGS_TO, 'StoreDetails', 'store_id'),
            'sales' => array(self::BELONGS_TO, 'ProductStockSales', 'sales_id'),
            'mainProductDetails' => array(self::BELONGS_TO, 'ProductDetails', 'main_product_details_id'),
            'exchangeProductDetails' => array(self::BELONGS_TO, 'ProductDetails', 'exchange_product_details_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'sales_id' => 'Sale ID',
            'main_product_details_id' => 'Main Item',
            'exchange_product_details_id' => 'Item',
            'grand_total_payable' => 'Grand Total',
            'grand_total_paid' => 'Total Paid',
            'grand_total_balance' => 'Return',
            'due_payment_date' => 'Due Date',
            'payment_method' => 'Method',
            'note' => 'Note',
            'dis_amount' => 'Dis Amount',
            'store_id' => 'Store',
            'exchange_date' => 'Date',
            'exchange_product_subtotal' => 'Total',
            'exchange_product_quantity' => 'Qty',
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

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('sales_id', $this->sales_id, true);
        $criteria->compare('main_product_details_id', $this->main_product_details_id);
        $criteria->compare('exchange_product_details_id', $this->exchange_product_details_id);
        $criteria->compare('grand_total_payable', $this->grand_total_payable, true);
        $criteria->compare('grand_total_paid', $this->grand_total_paid, true);
        $criteria->compare('grand_total_balance', $this->grand_total_balance, true);
        $criteria->compare('due_payment_date', $this->due_payment_date, true);
        $criteria->compare('payment_method', $this->payment_method);
        $criteria->compare('note', $this->note, true);
        $criteria->compare('dis_amount', $this->dis_amount, true);
        $criteria->compare('store_id', $this->store_id);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return ExchangeProducts the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    
    public function exchangeList() {
        
        $criteria = new CDbCriteria;
        $criteria->select = 't.sales_id AS id, t.grand_total_payable';
        $criteria->with = array(
            'exchangeProductDetails' => array(
                'select' => 'GROUP_CONCAT(exchangeProductDetails.product_name) as ex_product_name',
            ),
        );
        
        $criteria->compare('t.sales_id', $this->sales_id);
//        $criteria->compare('main_product_name', $this->main_product_name, true);
        $criteria->addCondition("t.exchange_product_details_id IS NOT NULL");
        $criteria->compare('ex_product_name', $this->ex_product_name, true);
        
        if (!Yii::app()->user->isSuperAdmin) {
            $criteria->compare('t.store_id', Yii::app()->user->storeId);
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
    
    public function getExchanges($id, $b_ex = false) {
        
        $store_id = 1;
        
        if (!Yii::app()->user->isSuperAdmin) {
            $store_id = Yii::app()->user->storeId;
        }
        
        $criteria = new CDbCriteria;
        
        if($b_ex) {
            $ar_with = array('exchangeProductDetails');
            $criteria->addCondition("t.exchange_product_details_id IS NOT NULL");
            $criteria->compare('exchangeProductDetails.store_id', $store_id);
        }else{
            $ar_with = array('mainProductDetails');
            $criteria->addCondition("t.main_product_details_id IS NOT NULL");
            $criteria->compare('mainProductDetails.store_id', $store_id);
        }
        
        $criteria->with = $ar_with;
        
        $criteria->compare('sales_id', $id);
        
        if (!Yii::app()->user->isSuperAdmin) {
            $criteria->compare('t.store_id', Yii::app()->user->storeId);
        }
        
        $criteria->order = 't.id DESC';

        $data = $this->findAll($criteria);
        $data = $this->formatExchangesRecords($data, $b_ex);
        return $data;
    }
    
    public function formatExchangesRecords($obj_sales, $b_ex = FALSE) {
        
        $ar_cart = array();
        
        $key = 'mainProductDetails';
        $qty = 'main_product_quantity';
        $sub_total = 'main_product_subtotal';
        
        if($b_ex){
            
            $date = date('d-m-Y', strtotime($obj_sales[0]->exchange_date));
            $bill_no = $obj_sales[0]->sales_id;
            $adjust = $obj_sales[0]->exchange_adjust_amount;
            $g_total_payable = $obj_sales[0]->grand_total_payable;
            $g_total_paid = $obj_sales[0]->grand_total_paid;
            $g_total_balance = $obj_sales[0]->grand_total_balance;
            $dis_amount = (!empty($obj_sales[0]->dis_amount) || (floatval($obj_sales[0]->dis_amount) > 0) ) ? floatval($obj_sales[0]->dis_amount) : 0.00;
            
            $ar_cart['bill_no'] = $bill_no;
            $ar_cart['g_total_payable'] = $g_total_payable;
            $ar_cart['g_total_paid'] = $g_total_paid;
            $ar_cart['g_total_balance'] = $g_total_balance;
            $ar_cart['dis_amount'] = $dis_amount;
            $ar_cart['adjust'] = $adjust;
            $ar_cart['date'] = $date;
            
            $key = 'exchangeProductDetails';
            $qty = 'exchange_product_quantity';
            $sub_total = 'exchange_product_subtotal';
        
        }

        foreach ($obj_sales as $row) {
            
            $_data['prod_name'] = $row->$key->product_name;
            $_data['qty'] = $row->$qty;
            $_data['sub_total'] = $row->$sub_total;

            $ar_cart[] = $_data;
        }
        
        return $ar_cart;
    }
    
    public function exchangeReportData($from_date, $to_date, $b_ex = FALSE) {
        
        $from_date = (!empty($from_date)) ? $from_date : date('Y-m-d', Settings::getBdLocalTime());
        $to_date = (!empty($to_date)) ? $to_date : date('Y-m-d', Settings::getBdLocalTime());
        
        $criteria = new CDbCriteria;
        $criteria->select = 't.id, t.sales_id, t.main_product_quantity, t.main_product_subtotal, t.exchange_ref_num, t.exchange_product_quantity, t.exchange_product_subtotal, t.dis_amount, t.grand_total_paid, t.grand_total_balance, t.grand_total_payable, t.exchange_adjust_amount';
        
        if($b_ex) {
            $ar_with = array('exchangeProductDetails');
            $criteria->addCondition("t.exchange_product_details_id IS NOT NULL");
        }else{
            $ar_with = array('mainProductDetails');
            $criteria->addCondition("t.main_product_details_id IS NOT NULL");
        }
        
        $criteria->with = $ar_with;

        $criteria->compare('DATE(t.exchange_date) >', $from_date);
        $criteria->compare('DATE(t.exchange_date) <', $to_date);
        
        if (!Yii::app()->user->isSuperAdmin) {
            $criteria->compare('t.store_id', Yii::app()->user->storeId);
        }
        
        $criteria->together = true;
        $criteria->order = 't.id DESC';
        
        $data = $this->findAll($criteria);
        
        return (!empty($data)) ? $this->formatExchangeReportData($data, $b_ex) : FALSE;
    }
    
    private function formatExchangeReportData($obj_data, $b_ex = FALSE) {
        
        $formatted_data = array();
        
        $key = 'mainProductDetails';
        $qty = 'main_product_quantity';
        $sub_total = 'main_product_subtotal';
        
        if($b_ex){
            
            $key = 'exchangeProductDetails';
            $qty = 'exchange_product_quantity';
            $sub_total = 'exchange_product_subtotal';
        
        }
        
        foreach ($obj_data as $row) {
            $sale_ids[] = $row->sales_id;
        }
        
        $sale_ids = array_unique($sale_ids);
        
        foreach ($sale_ids as $sale_id){
            
            $_data = array();
            foreach ($obj_data as $row) {
                
                if ($sale_id == $row->sales_id){
                    
                    if($b_ex){
                        
                        $_data['bill_total'] = ( empty($row->grand_total_payable) || ($row->grand_total_payable <= 0) ) ? 0.00 : $row->grand_total_payable;
                        $_data['amount_given'] = ( empty($row->grand_total_paid) || ($row->grand_total_paid <= 0) ) ? 0.00 : $row->grand_total_paid;
                        $_data['discount'] = ( empty($row->dis_amount) || ($row->dis_amount <= 0) ) ? 0.00 : $row->dis_amount;
                        $_data['balance'] = ( empty($row->grand_total_balance) || ($row->grand_total_balance <= 0) ) ? 0.00 : $row->grand_total_balance;
                        $_data['adjust'] = ( empty($row->exchange_adjust_amount) || ($row->exchange_adjust_amount <= 0) ) ? 0.00 : $row->exchange_adjust_amount;
                        
                        $cart['ref_num'] = $row->exchange_ref_num;
                    }
                    
                    $cart['prod_name'] = $row->$key->product_name;
                    $cart['qty'] = $row->$qty;
                    $cart['item_sub_total'] = $row->$sub_total;
                    
                    $_data[] = $cart;
                }
                
            }
            
            if($b_ex){
                $formatted_data[$sale_id]['ex_product'] = $_data;
            }else{
                $formatted_data[$sale_id]['main_product'] = $_data;
            }
        }
        
        return $formatted_data;
    }

}
