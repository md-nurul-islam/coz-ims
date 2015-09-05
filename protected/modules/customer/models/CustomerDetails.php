<?php

/**
 * This is the model class for table "cims_customer_details".
 *
 * The followings are the available columns in table 'cims_customer_details':
 * @property integer $id
 * @property string $customer_name
 * @property string $customer_address
 * @property string $customer_contact1
 * @property string $customer_contact2
 * @property integer $balance
 *
 * The followings are the available model relations:
 * @property ProductStockSales[] $productStockSales
 * @property Transactions[] $transactions
 */
class CustomerDetails extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'cims_customer_details';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('customer_name', 'required'),
            array('customer_name', 'unique'),
            array('balance', 'numerical', 'integerOnly' => true),
            array('customer_name', 'length', 'max' => 200),
            array('customer_address', 'length', 'max' => 500),
            array('customer_contact1, customer_contact2', 'length', 'max' => 100),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, customer_name, customer_contact1, balance', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'productStockSales' => array(self::HAS_MANY, 'ProductStockSales', 'customer_id'),
            'transactions' => array(self::HAS_MANY, 'Transactions', 'customer_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'customer_name' => 'Customer Name',
            'customer_address' => 'Address',
            'customer_contact1' => 'Contact1',
            'customer_contact2' => 'Contact2',
            'balance' => 'Balance',
            'status' => 'Status',
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
        $criteria->compare('customer_name', $this->customer_name, true);
        $criteria->compare('customer_address', $this->customer_address, true);
        $criteria->compare('customer_contact1', $this->customer_contact1, true);
        $criteria->compare('customer_contact2', $this->customer_contact2, true);
        $criteria->compare('balance', $this->balance);

        if (!Yii::app()->user->isSuperAdmin) {
            $criteria->compare('store_id', Yii::app()->user->storeId);
        }

        $criteria->compare('status', 1);
        $criteria->order = 'id DESC';

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return CustomerDetails the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
