<?php

namespace App\Controllers;

use Monolog\Logger;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class PagesController extends Controller
{
	public function getHome(ServerRequestInterface $request, ResponseInterface $response)
	{
		$this->container->get(Logger::class)->info('Hello world!');
		return $response->write('Hello world!');
//		return a 404 Not Found Exception
//		throw new NotFoundException($request, $response);
	}
}