<?php

namespace App;

use Slim\Handlers\NotFound;
use Slim\Views\Twig;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

class NotFoundHandler extends NotFound {

    private $view;

    public function __construct(Twig $view) {
        $this->view = $view;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response) {
        parent::__invoke($request, $response);

        $this->view->render($response, 'errors/error.twig', [
            "title" => "404 - Page non trouvé",
            "error_summary" => "La page que vous cherchez est introuvable",
            "action_title" => "Go to main page",
            "action_url" => $request->getUri()->getBasePath()
        ]);

        return $response->withStatus(404);
    }

}