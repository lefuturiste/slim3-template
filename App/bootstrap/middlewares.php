<?php
/*
|--------------------------------------------------------------------------
| Middleware requirements
|--------------------------------------------------------------------------
|
| Add Middleware to App
|
*/
/*
|--------------------------------------------------------------------------
| Whoops errors format
| Must be APP_DEBUG = true
|--------------------------------------------------------------------------
*/
use Zeuxisoo\Whoops\Provider\Slim\WhoopsGuard;

if (getenv('APP_DEBUG')){
	$whoopsGuard = new WhoopsGuard();
	$whoopsGuard->setApp($app);
	$whoopsGuard->setRequest($container->get('request'));
	$whoopsGuard->setHandlers([]);
	$whoopsGuard->install();
}