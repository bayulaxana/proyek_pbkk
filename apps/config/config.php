<?php

use Phalcon\Config;

return new Config(
    [
        'mode' => getenv('APP_MODE'), //DEVELOPMENT, PRODUCTION, DEMO

        'url' => [
            'baseUrl' => getenv('BASE_URL'),
        ],

        'database' => [
            'adapter'   => getenv('DB_ADAPTER'),
            'host'      => getenv('DB_HOST'),
            'port'      => getenv('DB_PORT'),
            'username'  => getenv('DB_USERNAME'),
            'password'  => getenv('DB_PASSWORD'),
            'dbname'    => getenv('DB_NAME'),
            'charset'   => getenv('DB_CHARSET')
        ],
        
        'application' => [
            'libraryDir'    => APP_PATH . "/lib/",
            'cacheDir'      => getenv('APP_MODE') == 'PRODUCTION' ? "/cache/" : APP_PATH . "/cache/",
            'mailCacheDir'  => getenv('APP_MODE') == 'PRODUCTION' ? "/cache/mail/" : APP_PATH . "/cache/mail/",
        ], 

        'version' => '0.1.0',
    ]
);
