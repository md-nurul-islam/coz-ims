<?php

$yii = dirname(__FILE__) . '/../../framworks/yii1/yii.php';
if (strpos($_SERVER['SERVER_ADDR'], '192.168.') !== FALSE) {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    $yii = dirname(__FILE__) . '/../../frameworks/yii/yii.php';
    defined('YII_DEBUG') or define('YII_DEBUG', true);
    defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL', 3);
}

$config = dirname(__FILE__) . '/protected/config/main.php';

require_once($yii);
Yii::createWebApplication($config)->run();
