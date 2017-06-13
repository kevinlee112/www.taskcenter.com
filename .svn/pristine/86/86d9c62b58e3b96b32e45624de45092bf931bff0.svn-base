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
        'database' => Public_Comm::getServerVal('SINASRV_DB_NAME_R'),
        'charset' => 'utf8',
        'errmode' => 2,
        'master' => [
            'database' => Public_Comm::getServerVal('SINASRV_DB_NAME'),
            'host' => Public_Comm::getServerVal('SINASRV_DB_HOST'),
            'port' => Public_Comm::getServerVal('SINASRV_DB_PORT'),
            'user' => Public_Comm::getServerVal('SINASRV_DB_USER'),
            'password' => Public_Comm::getServerVal('SINASRV_DB_PASS'),
        ],
        'slave' => [
            0 => [
                'database' => Public_Comm::getServerVal('SINASRV_DB_NAME_R'),
                'host' => Public_Comm::getServerVal('SINASRV_DB_HOST_R'),
                'port' => Public_Comm::getServerVal('SINASRV_DB_PORT_R'),
                'user' => Public_Comm::getServerVal('SINASRV_DB_USER_R'),
                'password' => Public_Comm::getServerVal('SINASRV_DB_PASS_R'),
            ],//Handle_Config::get("database.test.slave"),
        ],
    ],
    'mdata' => [
        'adapter' => 'Pdo',
        'masterslave' => true,
        'database' => Public_Comm::getServerVal('SINASRV_DB2_NAME'),
        'charset' => 'utf8',
        'errmode' => 2,
        'master' => [
            'database' => Public_Comm::getServerVal('SINASRV_DB2_NAME'),
            'host' => Public_Comm::getServerVal('SINASRV_DB2_HOST'),
            'port' => Public_Comm::getServerVal('SINASRV_DB2_PORT'),
            'user' => Public_Comm::getServerVal('SINASRV_DB2_USER'),
            'password' => Public_Comm::getServerVal('SINASRV_DB2_PASS'),
        ],
        'slave' => [
            0 => [
                'database' => Public_Comm::getServerVal('SINASRV_DB2_NAME_R'),
                'host' => Public_Comm::getServerVal('SINASRV_DB2_HOST_R'),
                'port' => Public_Comm::getServerVal('SINASRV_DB2_PORT_R'),
                'user' => Public_Comm::getServerVal('SINASRV_DB2_USER_R'),
                'password' => Public_Comm::getServerVal('SINASRV_DB2_PASS_R'),
            ],//Handle_Config::get("database.test.slave"),
        ],
    ],
    'redis' => [
        'adapter' => 'NoSQL_Redis',
        'masterslave' => false,
        'host' => current((explode(':', Public_Comm::getServerVal('SINASRV_REDIS_HOST_SHARE3')))),
        'port' => end((explode(':', Public_Comm::getServerVal('SINASRV_REDIS_HOST_SHARE3')))),
        'auth' => Public_Comm::getServerVal('SINASRV_REDIS_AUTH'),
        'charset' => 'utf8',
        'errmode' => 2,
    ],
    'mf_redis' => [
        'adapter' => 'NoSQL_Redis',
        'masterslave' => false,
        'host' => current((explode(':', Public_Comm::getServerVal('SINASRV_REDIS_HOST_SHARE')))),
        'port' => end((explode(':', Public_Comm::getServerVal('SINASRV_REDIS_HOST_SHARE')))),
        'auth' => Public_Comm::getServerVal('SINASRV_REDIS_AUTH'),
        'charset' => 'utf8',
        'errmode' => 2,
    ],
    'wx_redis' => [
        'adapter' => 'NoSQL_Redis',
        'masterslave' => false,
        'host' => current((explode(':', Public_Comm::getServerVal('SINASRV_REDIS_HOST_SHARE2')))),
        'port' => end((explode(':', Public_Comm::getServerVal('SINASRV_REDIS_HOST_SHARE2')))),
        'auth' => Public_Comm::getServerVal('SINASRV_REDIS_AUTH'),
        'charset' => 'utf8',
        'errmode' => 2,
    ],
    
];
