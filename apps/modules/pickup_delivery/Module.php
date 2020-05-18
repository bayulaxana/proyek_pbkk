<?php

namespace ServiceLaundry\PickupDelivery;

use Phalcon\Di\DiInterface;
use Phalcon\Loader;
use Phalcon\Mvc\ModuleDefinitionInterface;

class Module implements ModuleDefinitionInterface
{
    public function registerAutoloaders(DiInterface $di = null)
    {
        $loader = new Loader();

        $loader->registerNamespaces([
            'ServiceLaundry\PickupDelivery\Controllers\Web'     => __DIR__ . '/controllers',
            'ServiceLaundry\PickupDelivery\Models\Web'          => __DIR__ . '/models',
            'ServiceLaundry\PickupDelivery\Forms\Web'           => __DIR__ . '/form',
            'ServiceLaundry\Common\Controllers'                 => APP_PATH . '/controllers',
            'ServiceLaundry\Order\Models\Web'                   => APP_PATH . '/modules/order/models',
            'ServiceLaundry\Dashboard\Models\Web'               => APP_PATH . '/modules/dashboard/models'
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