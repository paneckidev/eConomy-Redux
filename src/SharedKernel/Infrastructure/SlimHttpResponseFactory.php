<?php

declare(strict_types=1);

namespace App\SharedKernel\Infrastructure;

use App\SharedKernel\Application\HttpResponseFactory;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Interfaces\RouteParserInterface;

final readonly class SlimHttpResponseFactory implements HttpResponseFactory
{
    public function __construct(
        private RouteParserInterface $routeParser
    ) {
    }

    public function redirect(
        Response $response,
        string $url,
        int $status = 302
    ): Response
    {
        return $response
            ->withHeader('Location', $url)
            ->withStatus($status);
    }

    public function redirectToRoute(
        Response $response,
        string $routeName,
        array $data = [],
        array $queryParams = [],
        int $status = 302
    ): Response
    {
        $url = $this->routeParser->urlFor(
            $routeName,
            $data,
            $queryParams
        );
    
        return $this->redirect($response, $url, $status);
    }
}