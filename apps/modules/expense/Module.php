<?php

namespace ServiceLaundry\Expense;

use Phalcon\Di\DiInterface;
use Phalcon\Loader;
use Phalcon\Mvc\ModuleDefinitionInterface;

class Module implements ModuleDefinitionInterface
{
    public function registerAutoloaders(DiInterface $di = null)
    {
        $loader = new Loader();

        $loader->registerNamespaces([
            'ServiceLaundry\Expense\Controllers\Web'        => __DIR__ . '/controllers',
            'ServiceLaundry\Expense\Models\Web'             => __DIR__ . '/models',
            'ServiceLaundry\Expense\Forms\Web'              => __DIR__ . '/form',
            'ServiceLaundry\Common\Controllers'             => APP_PATH . '/controllers'
        ]);

        $loader->register();
    }

    public function registerServices(DiInterface $di = null)
    {
        $moduleConfig = require __DIR__ . '/config/config.php';

        $di->get('config')->merge($moduleConfig);

        include_once __DIR__ . '/config/services.php';
    }
}