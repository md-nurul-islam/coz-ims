<?php

class Settings{
    
    
    /**
     * static funtion to convert time to Bangladeshi local time.
     * @param void.
     * @return returns timestamp.
    */
    public static function getBdLocalTime(){
        date_default_timezone_set('Asia/Dhaka');
        return time();
    }
    
    public static $_payment_types = array('1'=>'Cash','2'=>'Cheque');
    
    public static $_month_full_name_for_datepicker = array('January', 'Februaru', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
    
    public static $_user_types = array(
        '1' => 'Super User',
        '2' => 'Store Admin',
        '3' => 'Sales Operator',
    );
}

?>