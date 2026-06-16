<?php

declare(strict_types=1);

namespace App\SharedKernel\Application;

use Psr\Http\Message\ResponseInterface as Response;

interface View {
    public function render(Response $response, string $template, array $data = []): Response;

    public function withGlobals(array $data): void;
}