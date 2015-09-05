<?php

/**
 * This is the model class for table "cims_supplier_details".
 *
 * The followings are the available columns in table 'cims_supplier_details':
 * @property integer $id
 * @property string $supplier_name
 * @property string $supplier_address
 * @property string $supplier_contact1
 * @property string $supplier_contact2
 * @property integer $balance
 *
 * The followings are the available model relations:
 * @property ProductDetails[] $productDetails
 * @property ProductStockEntries[] $productStockEntries
 * @property ProductStockSales[] $productStockSales
 * @property Transactions[] $transactions
 */
class SupplierDetails extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'cims_supplier_details';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('supplier_name', 'required'),
            array('supplier_name', 'unique'),
            array('balance', 'numerical', 'integerOnly' => true),
            array('supplier_name', 'length', 'max' => 255),
            array('supplier_contact1, supplier_contact2', 'length', 'max' => 100),
            array('supplier_address', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, supplier_name, supplier_address, supplier_contact1, balance', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'productDetails' => array(self::HAS_MANY, 'ProductDetails', 'supplier_id'),
            'productStockEntries' => array(self::HAS_MANY, 'ProductStockEntries', 'supplier_id'),
            'productStockSales' => array(self::HAS_MANY, 'ProductStockSales', 'supplier_id'),
            'transactions' => array(self::HAS_MANY, 'Transactions', 'supplier_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'supplier_name' => 'Name',
            'supplier_address' => 'Address',
            'supplier_contact1' => 'Contact1',
            'supplier_contact2' => 'Contact2',
            'balance' => 'Balance',
            'is_default' => 'Default',
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

        $criteria->select = 'id, supplier_name, supplier_address, supplier_contact1, balance';

        $criteria->compare('id', $this->id);
        $criteria->compare('supplier_name', $this->supplier_name, true);
        $criteria->compare('supplier_address', $this->supplier_address, true);
        $criteria->compare('supplier_contact1', $this->supplier_contact1, true);
        $criteria->compare('balance', $this->balance);
        $criteria->compare('status', 1);
        
        /* if (!Yii::app()->user->isSuperAdmin) {
            $criteria->compare('store_id', Yii::app()->user->storeId);
        } */

        $criteria->order = 'id DESC';

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return SupplierDetails the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
