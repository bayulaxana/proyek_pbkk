<?php

$container['router'] = function() use ($defaultModule, $modules) {

	$router = new \Phalcon\Mvc\Router(false);
	$router->clear();

	/**
	 * Default Routing
	 */
	$router->add('/', [
	    'namespace' 	=> $modules[$defaultModule]['webControllerNamespace'],
		'module' 		=> $defaultModule,
	    'controller' 	=> isset($modules[$defaultModule]['defaultController']) ? $modules[$defaultModule]['defaultController'] : 'index',
	    'action' 		=> isset($modules[$defaultModule]['defaultAction']) ? $modules[$defaultModule]['defaultAction'] : 'index'
	]);
	
	/**
	 * Not Found Routing
	 */
	$router->notFound(
		[
			'namespace' 	=> 'ServiceLaundry\Common\Controllers',
			'controller' 	=> 'Error',
			'action'     	=> 'error404',
		]
	);

	/*
	* Cek routing module dashboard
	*/

	
    $router->removeExtraSlashes(true);
    
	return $router;
};