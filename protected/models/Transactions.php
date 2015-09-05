<?php

/**
 * This is the model class for table "cims_transactions".
 *
 * The followings are the available columns in table 'cims_transactions':
 * @property integer $id
 * @property string $type
 * @property integer $customer_id
 * @property integer $supplier_id
 * @property string $subtotal
 * @property string $payment
 * @property string $balance
 * @property string $due
 * @property string $date
 * @property string $rid
 * @property string $receiptid
 *
 * The followings are the available model relations:
 * @property ProductStockSales[] $productStockSales
 * @property SupplierDetails $supplier
 * @property CustomerDetails $customer
 */
class Transactions extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'cims_transactions';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('customer_id, supplier_id', 'numerical', 'integerOnly'=>true),
			array('type', 'length', 'max'=>50),
			array('subtotal, payment, balance', 'length', 'max'=>10),
			array('rid', 'length', 'max'=>120),
			array('receiptid', 'length', 'max'=>200),
			array('due, date', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, type, customer_id, supplier_id, subtotal, payment, balance, due, date, rid, receiptid', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'productStockSales' => array(self::HAS_MANY, 'ProductStockSales', 'transaction_id'),
			'supplier' => array(self::BELONGS_TO, 'SupplierDetails', 'supplier_id'),
			'customer' => array(self::BELONGS_TO, 'CustomerDetails', 'customer_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'type' => 'Type',
			'customer_id' => 'Customer',
			'supplier_id' => 'Supplier',
			'subtotal' => 'Subtotal',
			'payment' => 'Payment',
			'balance' => 'Balance',
			'due' => 'Due',
			'date' => 'Date',
			'rid' => 'Rid',
			'receiptid' => 'Receiptid',
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
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('type',$this->type,true);
		$criteria->compare('customer_id',$this->customer_id);
		$criteria->compare('supplier_id',$this->supplier_id);
		$criteria->compare('subtotal',$this->subtotal,true);
		$criteria->compare('payment',$this->payment,true);
		$criteria->compare('balance',$this->balance,true);
		$criteria->compare('due',$this->due,true);
		$criteria->compare('date',$this->date,true);
		$criteria->compare('rid',$this->rid,true);
		$criteria->compare('receiptid',$this->receiptid,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Transactions the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
