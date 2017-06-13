<?php

/**
 * Copyright (c) 2016 Leju Inc. All rights reserved.
 * 
 * database.php
 * 
 * @author     yulong8@leju.com
 * @version    $Id$
 */

return [
    // default
    'default' => [
        'adapter' => 'Pdo',
        'masterslave' => true,
        'database' => $_SERVER['SINASRV_DB_NAME_R'],
        'charset' => 'utf8',
        'errmode' => 2,
        'master' => [
            'database' => $_SERVER['SINASRV_DB_NAME'],
            'host' => $_SERVER['SINASRV_DB_HOST'],
            'port' => $_SERVER['SINASRV_DB_PORT'],
            'user' => $_SERVER['SINASRV_DB_USER'],
            'password' => $_SERVER['SINASRV_DB_PASS'],
        ],
        'slave' => [
            0 => [
                'database' => $_SERVER['SINASRV_DB_NAME_R'],
                'host' => $_SERVER['SINASRV_DB_HOST_R'],
                'port' => $_SERVER['SINASRV_DB_PORT_R'],
                'user' => $_SERVER['SINASRV_DB_USER_R'],
                'password' => $_SERVER['SINASRV_DB_PASS_R'],
            ],//Handle_Config::get("database.test.slave"),
        ],
    ],

    // default
    'nansha' => [
        'adapter' => 'Pdo',
        'masterslave' => true,
        'database' => $_SERVER['SINASRV_DB_NS_NAME_R'],
        'charset' => 'utf8',
        'errmode' => 2,
        'master' => [
            'database' => $_SERVER['SINASRV_DB_NS_NAME'],
            'host' => $_SERVER['SINASRV_DB_NS_HOST'],
            'port' => $_SERVER['SINASRV_DB_NS_PORT'],
            'user' => $_SERVER['SINASRV_DB_NS_USER'],
            'password' => $_SERVER['SINASRV_DB_NS_PASS'],
        ],
        'slave' => [
            0 => [
                'database' => $_SERVER['SINASRV_DB_NS_NAME_R'],
                'host' => $_SERVER['SINASRV_DB_NS_HOST_R'],
                'port' => $_SERVER['SINASRV_DB_NS_PORT_R'],
                'user' => $_SERVER['SINASRV_DB_NS_USER_R'],
                'password' => $_SERVER['SINASRV_DB_NS_PASS_R'],
            ],//Handle_Config::get("database.test.slave"),
        ],
    ],
    'redis' => [
        'adapter' => 'NoSQL_Redis',
        'masterslave' => false,
        'host' => current((explode(':', $_SERVER['SINASRV_REDIS_HOST_SHARE3']))),
        'port' => end((explode(':', $_SERVER['SINASRV_REDIS_HOST_SHARE3']))),
        'auth' => $_SERVER['SINASRV_REDIS_AUTH'],
        'charset' => 'utf8',
        'errmode' => 2,
    ],
    'mf_redis' => [
        'adapter' => 'NoSQL_Redis',
        'masterslave' => false,
        'host' => current((explode(':', $_SERVER['SINASRV_REDIS_HOST_SHARE']))),
        'port' => end((explode(':', $_SERVER['SINASRV_REDIS_HOST_SHARE']))),
        'auth' => $_SERVER['SINASRV_REDIS_AUTH'],
        'charset' => 'utf8',
        'errmode' => 2,
    ],
    'wx_redis' => [
        'adapter' => 'NoSQL_Redis',
        'masterslave' => false,
        'host' => current((explode(':', $_SERVER['SINASRV_REDIS_HOST_SHARE2']))),
        'port' => end((explode(':', $_SERVER['SINASRV_REDIS_HOST_SHARE2']))),
        'auth' => $_SERVER['SINASRV_REDIS_AUTH'],
        'charset' => 'utf8',
        'errmode' => 2,
    ],
    
];
