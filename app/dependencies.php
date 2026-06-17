<?php

declare(strict_types=1);

use App\Auth\Presentation\AccountController;
use App\Auth\Presentation\AuthController;
use App\Controllers\CompanyController;
use App\Controllers\ExchangeController;
use DI\ContainerBuilder;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;
use App\Controllers\IndexController;
use App\Controllers\Mail\MailController;
use App\Controllers\RankingController;
use App\SharedKernel\Application\HttpResponseFactory;
use App\SharedKernel\Application\IdGenerator;
use App\SharedKernel\Application\View;
use App\SharedKernel\Infrastructure\MonologLogger;
use App\SharedKernel\Infrastructure\RamseyIdGenerator;
use App\SharedKernel\Infrastructure\SlimHttpResponseFactory;
use App\SharedKernel\Infrastructure\TwigView;
use Slim\App as SlimApp;
use Slim\Factory\AppFactory;
use Slim\Interfaces\RouteParserInterface;
use Slim\Views\Twig;
use Slim\Views\TwigMiddleware;

return function (ContainerBuilder $containerBuilder) {
    $containerBuilder->addDefinitions([
        SlimApp::class => fn (ContainerInterface $c) => AppFactory::createFromContainer($c),

        IndexController::class => DI\autowire(),
        AuthController::class => DI\autowire(),
        RankingController::class => DI\autowire(),
        CompanyController::class => DI\autowire(),
        ExchangeController::class => DI\autowire(),
        MailController::class => DI\autowire(),
        AccountController::class => DI\autowire(),

        IdGenerator::class => DI\autowire(RamseyIdGenerator::class),
        LoggerInterface::class => fn () => MonologLogger::create(),
        HttpResponseFactory::class => DI\autowire(SlimHttpResponseFactory::class),
        View::class => fn (ContainerInterface $c) => new TwigView($c->get(Twig::class)),

        RouteParserInterface::class => fn (ContainerInterface $c)
            => $c->get(SlimApp::class)->getRouteCollector()->getRouteParser(),
            
        Twig::class => fn () => Twig::create(BASE_DIR . '/resources/views', [
            'cache' => $_ENV['TWIG_CACHE'] ?? false
        ]),

        TwigMiddleware::class => fn (ContainerInterface $c) => TwigMiddleware::create(
            $c->get(SlimApp::class),
            $c->get(Twig::class)
        ),
    ]);
};
