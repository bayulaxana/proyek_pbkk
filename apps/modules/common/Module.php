<?php

namespace ServiceLaundry\Dashboard;

use Phalcon\Di\DiInterface;
use Phalcon\Loader;
use Phalcon\Mvc\ModuleDefinitionInterface;

class Module implements ModuleDefinitionInterface
{
    public function registerAutoloaders(DiInterface $di = null)
    {
        $loader = new Loader();

        $loader->registerNamespaces([
            'ServiceLaundry\Common\Controllers\Web'      => __DIR__ . '/controllers',
            'ServiceLaundry\Common\Models\Web'           => __DIR__ . '/models',
            'ServiceLaundry\Common\Forms\Web'            => __DIR__ . '/forms',
	    'ServiceLaundry\Common\Models\Web		 => __DIR__ . '/models,
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