<?php

namespace ServiceLaundry\Order;

use Phalcon\Di\DiInterface;
use Phalcon\Loader;
use Phalcon\Mvc\ModuleDefinitionInterface;

class Module implements ModuleDefinitionInterface
{
    public function registerAutoloaders(DiInterface $di = null)
    {
        $loader = new Loader();

        $loader->registerNamespaces([
            'ServiceLaundry\Order\Controllers\Web'  => __DIR__ . '/controllers',
            'ServiceLaundry\Order\Models\Web'       => __DIR__ . '/models',
            'ServiceLaundry\Order\Views\Web'        => __DIR__ . '/views',
            'ServiceLaundry\Order\Forms\Web'        => __DIR__ . '/form',
            'ServiceLaundry\Dashboard\Models\Web'   => APP_PATH . '/modules/dashboard/models',
            'ServiceLaundry\Common\Controllers'     => APP_PATH . '/controllers'
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