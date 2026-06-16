<?php

declare(strict_types=1);

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\SharedKernel\Application\View;
use Psr\Log\LoggerInterface;

class IndexController
{
    public function __construct(
        private View $view,
        private LoggerInterface $logger
    ) {}

    public function index(Request $request, Response $response, array $args): Response
    {
        return $this->view->render($response, 'index.twig');
    }
}
