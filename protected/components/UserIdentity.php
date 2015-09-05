<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
    /**
	 * @var object $model
	 */
    private $__model;
    
    /**
	 * @var integer user id
	 */
    private $_id;
    
    /**
	 * @var string username from api request
	 */
    private $__api_username;
    
    /**
	 * @var string password from api request
	 */
    private $__api_password;
    
    /**
	 * @var string username from DB
	 */
    private $__ar_username;
    
    /**
	 * @var string password from DB
	 */
    private $__ar_password;
    
    /**
	 * @var string salt from DB
	 */
    private $__ar_salt;
    
    public function __construct($api_model, $ar_model){
        
        // username and password from api request
        $this->__api_username = $api_model->username;
        $this->__api_password = $api_model->hashed_password;
        
        // username and password from db
        $this->__ar_username = $ar_model->username;
        $this->__ar_password = $ar_model->hashed_password;
        $this->__ar_salt = $ar_model->salt;
        
        $this->__model = $ar_model;
    }
    
	/**
	 * Authenticates a user.
	 * The example implementation makes sure if the username and password
	 * are both 'demo'.
	 * In practical applications, this should be changed to authenticate
	 * against some persistent user identity storage (e.g. database).
	 * @return boolean whether authentication succeeds.
	 */
    public function authenticate()
    {
        if($this->__api_username !== $this->__ar_username){
            
            $this->errorCode = self::ERROR_USERNAME_INVALID;
            return false;
            
        }elseif($this->__ar_password !== hash( 'sha512', $this->__ar_salt . $this->__api_password)){

            $this->errorCode = self::ERROR_PASSWORD_INVALID;
            return false;
            
        }else{
            
            $this->_id = $this->__model->id;
            $this->setState('name', $this->fullName());
            $this->setState('isSuperAdmin', $this->isSuperAdmin());
            $this->setState('isStoreAdmin', $this->isStoreAdmin());
            $this->setState('isSalesOperator', $this->isSalesOperator());
            $store_id = $this->storeId();
            $this->setState('storeId', $store_id);
            if($store_id > 0) {
                $this->setState('storeName', $this->__model->storeInfo->name);
                $this->setState('storeAddress', $this->__model->storeInfo->address . ' ' . $this->__model->storeInfo->place . ' ' . $this->__model->storeInfo->city);
            }
            
            $this->errorCode = self::ERROR_NONE;
            
            return true;    
        }
        
        return false;
    }
    
    public function getId()
    {
        return $this->_id;
    }
    
    private function isSuperAdmin(){
        return ($this->__model->user_type == 1) ? true : false;
    }
    
    private function isStoreAdmin(){
        return ($this->__model->user_type == 2) ? true : false;
    }
    
    private function isSalesOperator(){
        return ($this->__model->user_type == 3) ? true : false;
    }
    
    private function storeId(){
        return $this->__model->store_id;
    }
    
    private function fullName(){
        return $this->__model->full_name;
    }
        
}