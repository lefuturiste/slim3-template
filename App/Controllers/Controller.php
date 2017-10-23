<?php
namespace App\Controllers;

use Monolog\Logger;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Slim\Router;
use Slim\Views\Twig;

class Controller{

	/**
	 * @var Twig
	 */
	protected $view;
	/**
	 * @var Logger
	 */
	protected $log;
	/**
	 * @var Router
	 */
	protected $router;

	public function __construct(Logger $log, Router $router, Twig $view)
	{
		$this->view = $view;
		$this->log = $log;
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
		$this->view->render($response, $file, $params);
	}

	public function pathFor($name, $params = []){
		return $this->router->pathFor($name, $params);
	}
}