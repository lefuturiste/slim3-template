<?php

namespace App;

use DI\Container;
use Slim\Handlers\NotFound;
use Slim\Views\Twig;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

class NotFoundHandler extends NotFound
{

	/**
	 * @var Container
	 */
	private $container;

	public function __construct(Container $container)
	{
		$this->container = $container;
	}

	public function __invoke(ServerRequestInterface $request, ResponseInterface $response)
	{
		parent::__invoke($request, $response);

		$this->container->get(Twig::class)->render($response, 'errors/404.twig');

		return $response->withStatus(404);
	}

}