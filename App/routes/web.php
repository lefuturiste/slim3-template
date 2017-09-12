<?php
/*
|--------------------------------------------------------------------------
| Web routing
|--------------------------------------------------------------------------
|
| Register it all your normal routes
|
*/

$app->get('/', \App\Controllers\PagesController::class . ':getHome')->setName('home');