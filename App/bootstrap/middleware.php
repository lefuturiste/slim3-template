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
$whoopsGuard = new \Zeuxisoo\Whoops\Provider\Slim\WhoopsGuard();
$whoopsGuard->setApp($app);
$whoopsGuard->setRequest($container['request']);
$whoopsGuard->setHandlers([]);
$whoopsGuard->install();