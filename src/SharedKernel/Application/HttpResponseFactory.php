<?php

declare(strict_types=1);

namespace App\SharedKernel\Application;

use Psr\Http\Message\ResponseInterface as Response;

interface HttpResponseFactory
{
    public function redirect(
        Response $response,
        string $url,
        int $status = 302
    ): Response;

    public function redirectToRoute(
        Response $response,
        string $routeName,
        array $data = [],
        array $queryParams = [],
        int $status = 302
    ): Response;
}