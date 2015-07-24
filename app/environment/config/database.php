<?php

$config['database'] = array(
    'default'       => 'mysql',

    'connections'   => array(
        'mysql'     => array(
            'driver'    => 'mysql',
            'host'      => isset($_SERVER['DB1_HOST']) ? $_SERVER['DB1_HOST'] : 'localhost',
            'database'  => isset($_SERVER['DB1_NAME']) ? $_SERVER['DB1_NAME'] : '',
            'username'  => isset($_SERVER['DB1_USER']) ? $_SERVER['DB1_USER'] : 'root',
            'password'  => isset($_SERVER['DB1_PASS']) ? $_SERVER['DB1_PASS'] : '',
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => ''
        )
    )
);