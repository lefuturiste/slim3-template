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

//set config
$config = new lefuturiste\config\Config(dirname(__DIR__) . '/App/config/', dirname(__DIR__));
global $config;

/*
|--------------------------------------------------------------------------
| Function File
|--------------------------------------------------------------------------
|
| Include App/functions.php
| This file provide all helpers functions
|
*/
include '../App/bootstrap/functions.php';


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
$app = new \App\App();

//set config container
$container = $app->getContainer();
$container->set('config', $config->config);

/*
|--------------------------------------------------------------------------
| Middleware requirements
|--------------------------------------------------------------------------
|
| Add Middleware to App
|
*/
include("../App/bootstrap/middlewares.php");

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
