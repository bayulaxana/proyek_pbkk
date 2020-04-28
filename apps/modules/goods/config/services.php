<?php

use Phalcon\Mvc\View;

$di['view'] = function () {
    $view = new View();
    $view->setViewsDir(__DIR__ . '/../');

    $view->registerEngines(
        [
            ".volt" => "voltService",
        ]
        );

    return $view;
};
