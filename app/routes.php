<?php

declare(strict_types=1);

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Controllers\IndexController;
use Slim\App;

//
// Routes
//

return function (App $app) {
    $app->options('/{routes:.*}', fn (Request $request, Response $response) => $response);

    $app->get('/', [IndexController::class, 'index']);
};
