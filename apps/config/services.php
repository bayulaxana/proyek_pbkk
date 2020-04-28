<?php

use Phalcon\Session\Adapter\Stream as SessionStream;
use Phalcon\Session\Manager as SessionManager;
use Phalcon\Security;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Events\Event;
use Phalcon\Events\Manager;
use Phalcon\Mvc\View;
use Phalcon\Mvc\ViewBaseInterface;
use Phalcon\Mvc\View\Engine\Volt;
use Phalcon\Http\Response\Cookies;
use Phalcon\Flash\Direct as FlashDirect;
use Phalcon\Flash\Session as FlashSession;
use Phalcon\Escaper;
use Phalcon\Mvc\Model\Manager as modelManager;

$container['config'] = function() use ($config) {
	return $config;
};

$container->setShared('session', function() {

    $session = new SessionManager();
    $files = new SessionStream([
        'savePath'  => APP_PATH . '/tmp',
    ]);
    $session->setAdapter($files);
	$session->start();

	return $session;
});


$container['url'] = function() use ($config) {
	$url = new \Phalcon\Url();

    $url->setBaseUri($config->url['baseUrl']);

	return $url;
};

$container['voltService'] = function (ViewBaseInterface $view) use ($container, $config) {
    
    $volt = new Volt($view, $container);

    if (!is_dir($config->application->cacheDir)) {
        mkdir($config->application->cacheDir);
    }

    $compileAlways = $config->mode == 'DEVELOPMENT' ? true : false;

    $volt->setOptions(
        [
            'always'    => $compileAlways,
            'extension' => '.compiled',
            'separator' => '_',
            'stat'      => true,
            'path'      => $config->application->cacheDir,
            'prefix'    => '-prefix-',
        ]
    );
    
    return $volt;
};

$container['view'] = function () {
    $view = new View();
    $view->setViewsDir(APP_PATH . '/common/views/');

    $view->registerEngines(
        [
            ".volt" => "voltService",
        ]
    );

    return $view;
};

$container->set(
    'security',
    function () {
        $security = new Security();
        $security->setWorkFactor(12);

        return $security;
    },
    true
);

$container->set(
    'cookies',
    function () {
        $cookies = new Cookies();

        $cookies->useEncryption(false);

        return $cookies;
    }
);

$container->set(
    'flash',
    function () {
        $escaper    = new Escaper();
        $flash      = new FlashDirect($escaper);
        $flash->setImplicitFlush(false);
        $flash->setCssClasses([        
                'error'   => 'alert alert-danger',
                'success' => 'alert alert-success', 
                'notice'  => 'alert alert-info',
                'warning' => 'alert alert-warning'
        ]);
        return $flash;
    }
);

$container['db'] = function () {
    $config = $this->getConfig();

    $class = $config->database->adapter;
    $params = [
        'host'      => $config->database->host,
        'username'  => $config->database->username,
        'password'  => $config->database->password,
        'dbname'    => $config->database->dbname,
        'port'      => $config->database->port,
        'charset'   => $config->database->charset
    ];

    return new $class($params);
};

$container->set('modelsManager',function(){
    $modelsManager  = new ModelManager();
    return $modelsManager;
});

/*
* Event Manager for Dispatcher
*/
$container['dispatcher'] = function() {

    $eventsManager = new Manager();

    $eventsManager->attach(
        'dispatch:beforeException',
        function (Event $event, Dispatcher $dispatcher, Exception $exception) {
            if ($exception instanceof DispatchException) {
                $dispatcher->forward(
                    [
                        'controller' => 'index',
                        'action'     => 'fourOhFour',
                    ]
                );
                return false;
            }
        }
    );

    $dispatcher = new Dispatcher();
    $dispatcher->setEventsManager($eventsManager);

    return $dispatcher;
};