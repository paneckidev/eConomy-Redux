<?php

declare(strict_types=1);

use DI\ContainerBuilder;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Monolog\Processor\UidProcessor;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;
use App\Controllers\IndexController;
use App\SharedKernel\Application\View;
use App\SharedKernel\Infrastructure\TwigView;
use Slim\Views\Twig;
use Twig\Loader\FilesystemLoader;

use function DI\autowire;

//
// Dependencies
//

return function (ContainerBuilder $containerBuilder) {
    $containerBuilder->addDefinitions([
        
    
        LoggerInterface::class => function () {
            $logger = new Logger($_ENV['LOGGER_NAME']);

            $processor = new UidProcessor();
            $logger->pushProcessor($processor);

            $handler = new StreamHandler($_ENV['LOGGER_PATH'], $_ENV['LOGGER_LEVEL']);
            $logger->pushHandler($handler);

            return $logger;
        },

        IndexController::class => DI\autowire(),

        RouteParserInterface::class => function () use ($app) {
            return $app->getRouteCollector()->getRouteParser();
        },

        View::class => function (ContainerInterface $c)
        {
            $loader = new FilesystemLoader();
            $loader->addPath(BASE_DIR . '/resources/views');

            $twig = new Twig($loader, [
                'cache' => $_ENV['TWIG_CACHE'] ?? false
            ]);

            $twig->addExtension(new \Slim\Views\TwigExtension($c->get(RouteParserInterface::class), ''));

            $env = $twig->getEnvironment();

            $env->addGlobal('current_path', $_SERVER['REQUEST_URI'] ?? '/');
            $env->addGlobal('htmx_request', ($_SERVER['HTTP_HX_REQUEST'] ?? '') === 'true');

            return new TwigView($twig);
        }
    ]);
};
