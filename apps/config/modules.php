<?php

return array(
    'common' => [
        'namespace'                     => 'ServiceLaundry\Common',
        'webControllerNamespace'        => 'ServiceLaundry\Common\Controllers\Web',
        'apiControllerNamespace'        => '',
        'className'                     => 'ServiceLaundry\Common\Module',
        'path'                          => APP_PATH . '/modules/dashboard/Module.php',
        'defaultRouting'                => true,
        'defaultController'             => 'Index',
        'defaultAction'                 => 'index'
    ],

    'dashboard' => [
        'namespace'                     => 'ServiceLaundry\Dashboard',
        'webControllerNamespace'        => 'ServiceLaundry\Dashboard\Controllers\Web',
        'apiControllerNamespace'        => '',
        'className'                     => 'ServiceLaundry\Dashboard\Module',
        'path'                          => APP_PATH . '/modules/dashboard/Module.php',
        'defaultRouting'                => true,
        'defaultController'             => 'Index',
        'defaultAction'                 => 'index'
    ],

    'expense' => [
        'namespace'                     => 'ServiceLaundry\Expense',
        'webControllerNamespace'        => 'ServiceLaundry\Expense\Controllers\Web',
        'apiControllerNamespace'        => '',
        'className'                     => 'ServiceLaundry\Expense\Module',
        'path'                          => APP_PATH . '/modules/expense/Module.php',
        'defaultRouting'                => true,
        'defaultController'             => 'Index',
        'defaultAction'                 => 'index'
    ],

    'order' => [
        'namespace'                     => 'ServiceLaundry\Order',
        'webControllerNamespace'        => 'ServiceLaundry\Order\Controllers\Web',
        'apiControllerNamespace'        => '',
        'className'                     => 'ServiceLaundry\Order\Module',
        'path'                          => APP_PATH . '/modules/order/Module.php',
        'defaultRouting'                => true,
        'defaultController'             => 'Index',
        'defaultAction'                 => 'index'
    ],

    'pickup_delivery' => [
        'namespace'                     => 'ServiceLaundry\PickupDelivery',
        'webControllerNamespace'        => 'ServiceLaundry\PickupDelivery\Controllers\Web',
        'apiControllerNamespace'        => '',
        'className'                     => 'ServiceLaundry\PickupDelivery\Module',
        'path'                          => APP_PATH . '/modules/pickup_delivery/Module.php',
        'defaultRouting'                => true,
        'defaultController'             => 'Index',
        'defaultAction'                 => 'index'
    ],

    'goods' => [
        'namespace'                     => 'ServiceLaundry\Goods',
        'webControllerNamespace'        => 'ServiceLaundry\Goods\Controllers\Web',
        'apiControllerNamespace'        => '',
        'className'                     => 'ServiceLaundry\Goods\Module',
        'path'                          => APP_PATH . '/modules/goods/Module.php',
        'defaultRouting'                => true,
        'defaultController'             => 'Index',
        'defaultAction'                 => 'index'
    ]
);