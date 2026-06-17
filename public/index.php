<?php

declare(strict_types=1);

use DI\ContainerBuilder;
use Slim\App;

define('BASE_DIR', dirname(__DIR__));

require BASE_DIR . '/vendor/autoload.php';

function dd(...$data) {
	var_dump($data);
	die;
}

// Load dotenv configuration
$dotenv = Dotenv\Dotenv::createImmutable(BASE_DIR);
$dotenv->safeLoad();

// TODO: Move this to middleware
session_start();

// Instantiate PHP-DI ContainerBuilder
$containerBuilder = new ContainerBuilder();

if (false) { // Should be set to true in production
	$containerBuilder->enableCompilation(BASE_DIR . '/var/cache');
}

// Set up dependencies
$dependencies = require BASE_DIR . '/app/dependencies.php';
$dependencies($containerBuilder);

// Build PHP-DI Container instance
$container = $containerBuilder->build();

// Instantiate the app
$app = $container->get(App::class);

// Register middleware
$middleware = require BASE_DIR . '/app/middleware.php';
$middleware($app);

// Register routes
$routes = require BASE_DIR . '/app/routes.php';
$routes($app);

// Add Routing Middleware
$app->addRoutingMiddleware();

// Add Body Parsing Middleware
$app->addBodyParsingMiddleware();

// Add Error Middleware
$errorMiddleware = $app->addErrorMiddleware(true, true, true);

// Run app
$app->run();
