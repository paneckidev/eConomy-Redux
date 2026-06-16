<?php

declare(strict_types=1);

namespace App\SharedKernel\Infrastructure;

use App\SharedKernel\Application\View;
use Slim\Views\Twig;
use Psr\Http\Message\ResponseInterface as Response;

final class TwigView implements View
{
    public function __construct(
        private Twig $twig
    ) {}

    public function render(Response $response, string $template, array $data = []): Response
    {
        return $this->twig->render($response, $template, $data);
    }

    public function withGlobals(array $data): void
    {
        $env = $this->twig->getEnvironment();

        foreach ($data as $key => $value) {
            $env->addGlobal($key, $value);
        }
    }
}