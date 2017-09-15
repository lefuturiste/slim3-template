<?php
/*
|--------------------------------------------------------------------------
| Entry point of application
|--------------------------------------------------------------------------
|
| This file manage http entry point of application
|
*/
require '../vendor/autoload.php';

/*
|--------------------------------------------------------------------------
| Required Configuration
|--------------------------------------------------------------------------
|
| Config are generated by \App\Config class
|
*/
$config = \Config\Config::get(dirname(__DIR__) . '/App/config/', dirname(__DIR__));

/*
|--------------------------------------------------------------------------
| Function File
|--------------------------------------------------------------------------
|
| Include App/functions.php
| This file provide all helpers functions
|
*/
include '../App/functions.php';

/*
|--------------------------------------------------------------------------
| Instantiated new Application
|--------------------------------------------------------------------------
|
| Slim application provide routing, container dependency and http management
| He have a debug setting : displayErrorDetails (true/false)
| If this setting is true, Application will be show Errors details.
| You must indicate false setting for production environment.
|
*/
$app = new \Slim\App([
	'settings' => [
		'debug' => $config['app_debug'],
		'displayErrorDetails' => $config['app_debug']
	]
]);

/*
|--------------------------------------------------------------------------
| Container requirements
|--------------------------------------------------------------------------
|
| Include App/container.php
| In this file we have all container dependency who is registered
|
*/
require '../App/container.php';

/*
|--------------------------------------------------------------------------
| Middleware requirements
|--------------------------------------------------------------------------
|
| Add Middleware to App
|
*/
include("../App/bootstrap/middleware.php");

/*
|--------------------------------------------------------------------------
| Routing requirements
|--------------------------------------------------------------------------
|
| Include all routes files
|
*/
include("../App/routes/web.php");
//include("../App/routes/api.php");

$app->run();
