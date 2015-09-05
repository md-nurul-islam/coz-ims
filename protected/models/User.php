<?php

/**
 * This is the model class for table "users".
 *
 * The followings are the available columns in table 'users':
 * @property integer $id
 * @property string $username
 * @property string $email
 * @property string $full_name
 * @property string $hashed_password
 * @property string $salt
 * @property integer $store_id
 * @property integer $status
 */
class User extends CActiveRecord {
    
    public $rememberMe;
    public $current_password;
    public $new_password;
    public $repeat_password;

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'cims_user';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('username, hashed_password', 'required'),
            array('id, store_id, user_type, status', 'numerical', 'integerOnly' => true),
            array('username', 'length', 'max' => 50),
            array('username, email, full_name, hashed_password, salt', 'length', 'max' => 150),
            
            array('current_password, new_password, repeat_password', 'required', 'on' => 'changePassword'),
            array('repeat_password', 'compare', 'compareAttribute'=>'new_password', 'on' => 'changePassword', 'message' => 'New Password and Repeat Password must be same.'),
            array('new_password, repeat_password', 'length', 'min' => 8),
            
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, username, full_name, store_id, email, status, user_type', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'storeInfo' => array(self::BELONGS_TO, 'StoreDetails', 'store_id')
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'username' => 'Username',
            'full_name' => 'Full Name',
            'email' => 'Email',
            'hashed_password' => 'Password',
            'store_id' => 'Store Name',
            'status' => 'Status',
            'user_type' => 'User Type',
            'current_password' => 'Current Password',
            'new_password' => 'New Password',
            'repeat_password' => 'Repeat Password',
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
        $criteria->compare('username', $this->username);
        $criteria->compare('email', $this->email, true);
        $criteria->compare('full_name', $this->full_name, true);
        $criteria->compare('store_id', $this->store_id);
        $criteria->compare('status', $this->status);
        $criteria->compare('user_type', $this->user_type);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Users the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * Logs in the user using the given username and password in the model.
     * @return boolean whether login is successful
     */
    public function login() {
        $user = $this->checkUser();
        
         $salt = $this->generateSalt();
            
//        var_dump($salt);
//
//        var_dump($this->genPassword($salt, $this->hashed_password));
//        exit;
        
        if ($user !== false) {
            
            $userIdentity = new UserIdentity($this, $user);

            if ($userIdentity->authenticate()) {
                
                $duration = ($this->rememberMe == 1) ? 86400 : 0; // 1 Day
                
                Yii::app()->user->login($userIdentity, $duration);
                
                return true;
            } else {
                
                Yii::app()->user->setFlash('error', 'Username or password invalid.');
                return false;
            }
        } else {
            
            Yii::app()->user->setFlash('error', 'Username or password invalid.');
            return false;
        }
    }

    /**
     * Finds user by provided username.
     * @return If found then returns user object else returns false.
     */
    public function checkUser($username = '', $api_token = '') {
        $username = (empty($username)) ? $this->username : $username;
        
        $criteria = new CDbCriteria;
        $criteria->select = 'id, username, hashed_password, salt, email, store_id, status, user_type, full_name';
        $criteria->compare('username', $username);
        $criteria->compare('status', 1);
        
        $user = $this->with('storeInfo')->find($criteria);
        
        return (!empty($user)) ? $user : false;
    }

    public function checkCurrentPassword($user, $params) {
        
        if($user->hashed_password != hash( 'sha512', $user->salt . $this->current_password) ) {
            $this->addError($attribute, 'Current password is incorrect.');
        }

    }

    private function generateSalt() {
        
        $salt = time() . rand(0, 100000);
        $salt = md5($salt);
        return $salt;
    }

    public function getPasswordSalt() {
        return $this->generateSalt();
    }

    public function getPassword($salt, $pwd_str) {
        return $this->genPassword($salt, $pwd_str);
    }

    /**
     * Finds user by provided date.
     * @return If found then returns user object else returns false.
     */
    public function getBirthDays($date = '', $school_id = '') {
        $date = (!empty($date)) ? date('m-d', strtotime($date)) : date('m-d', time());
        $school_id = (!empty($school_id)) ? $school_id : Yii::app()->user->schoolId;

        $criteria = new CDbCriteria();
        $criteria->select = 't.id, admin, employee, student, parent';
        $criteria->compare("DATE_FORMAT(studentDetails.date_of_birth, '%m-%d')", $date);
        $criteria->compare("DATE_FORMAT(employeeDetails.date_of_birth, '%m-%d')", $date, false, 'OR');
        $criteria->compare("DATE_FORMAT(guardiansDetails.dob, '%m-%d')", $date, false, 'OR');
        $criteria->compare('t.school_id', $school_id);
        $criteria->compare('t.is_deleted', 0);

        $data = $this->with('studentDetails', 'employeeDetails', 'guardiansDetails')->findAll($criteria);

        if (!empty($data)) {
            return $formatted_data = $this->formatData($data);
        }

        return false;
    }

    private function genPassword($salt, $pwd_string) {

        return hash('sha512', $salt . $pwd_string);
    }

}
