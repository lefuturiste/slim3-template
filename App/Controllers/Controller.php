<?php
namespace App\Controllers;

use DI\Container;
use Psr\Http\Message\ResponseInterface;
use Slim\Router;
use Slim\Views\Twig;

class Controller{

	/**
	 * @var Router
	 */
	protected $router;

	public function __construct(Container $container, Router $router)
	{
		$this->container = $container;
		$this->router = $router;
	}

	public function redirect(ResponseInterface $response, $location){
		return $response->withStatus(302)->withHeader('Location', $location);
	}

	/**
	 * Helper for render function
	 * Please give file name without extension
	 *
	 * @param ResponseInterface $response
	 * @param $file
	 * @param array $params
	 */
	public function render(ResponseInterface $response, $file, $params = []){
		//require file without .twig extension
		$file = str_replace('.', '/', $file) . '.twig';
		$this->container->get(Twig::class)->render($response, $file, $params);
	}

	public function pathFor($name, $params = []){
		return $this->router->pathFor($name, $params);
	}
}