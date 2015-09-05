<?php

/**
 * This is the model class for table "cims_store_details".
 *
 * The followings are the available columns in table 'cims_store_details':
 * @property integer $id
 * @property string $name
 * @property string $log
 * @property string $type
 * @property string $address
 * @property string $place
 * @property string $city
 * @property string $phone
 * @property string $email
 * @property string $web
 * @property string $pin
 */
class StoreDetails extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'cims_store_details';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name, address, place, city', 'required'),
            array('name, log, type, address, place, city, phone, email, pin', 'length', 'max' => 100),
            array('web', 'length', 'max' => 255),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, name, log, type, address, place, city, phone, email, web, pin', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'name' => 'Name',
            'log' => 'Log',
            'type' => 'Type',
            'address' => 'Address',
            'place' => 'State',
            'city' => 'City',
            'phone' => 'Phone',
            'email' => 'Email',
            'web' => 'Web',
            'pin' => 'Pin',
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
        $criteria->compare('name', $this->name, true);
        $criteria->compare('log', $this->log, true);
        $criteria->compare('type', $this->type, true);
        $criteria->compare('address', $this->address, true);
        $criteria->compare('place', $this->place, true);
        $criteria->compare('city', $this->city, true);
        $criteria->compare('phone', $this->phone, true);
        $criteria->compare('email', $this->email, true);
        $criteria->compare('web', $this->web, true);
        $criteria->compare('pin', $this->pin, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return StoreDetails the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
