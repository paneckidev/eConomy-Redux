<?php

declare(strict_types=1);

use Slim\App;
use Slim\Views\TwigMiddleware;

//
// Application middleware
//

return function (App $app) {
    $app->add(TwigMiddleware::class);
};
