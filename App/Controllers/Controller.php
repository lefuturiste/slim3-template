<?php
namespace App\Controllers;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class Controller{
	public $container;

	protected $mysql;

	protected $log;

	protected $session;

	protected $flash;

	public function __construct($container)
	{
		$this->container = $container;
		//$this->mysql = $container['mysql'];
		$this->log = $container['log'];
		//$this->session = $container['session'];
		$this->mc = $container['minecraft'];
		//$this->flash = $container['flash'];
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
		$this->container->view->render($response, $file, $params);
	}

	public function pathFor($name){
		return $this->container->router->pathFor($name);
	}
}