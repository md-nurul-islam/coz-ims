<?php

if (strpos($_SERVER['SERVER_ADDR'], '192.168.') !== FALSE) {

    $log = array(
        'class' => 'CLogRouter',
        'routes' => array(
            array(
                'class' => 'CWebLogRoute',
                'levels' => 'log, error, warning',
//                'categories' => 'system.db.CDbCommand',
//                'logFile' => 'db.log',
            ),
        ),
    );
} else {
    $log = array(
        'class' => 'CLogRouter',
        'routes' => array(
            array(
                'class' => 'CFileLogRoute',
                'levels' => 'log, error, warning',
            ),
        ),
    );
}
