<?php

declare(strict_types=1);

use App\Auth\Presentation\AccountController;
use App\Auth\Presentation\AuthController;
use App\Controllers\CompanyController;
use App\Controllers\ExchangeController;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Controllers\IndexController;
use App\Controllers\Mail\MailController;
use App\Controllers\RankingController;
use Slim\App;
use Slim\Routing\RouteCollectorProxy;

//
// Routes
//

return function (App $app) {
    $app->options('/{routes:.*}', fn (Request $request, Response $response) => $response);

    $app->get('/', [IndexController::class, 'index'])->setName('home');

    $app->group('', function (RouteCollectorProxy $group) {
        $group->group('/auth', function (RouteCollectorProxy $group) {
            $group->get('/register', [AuthController::class, 'showRegisterForm'])->setName('auth.register');
            $group->post('/register', [AuthController::class, 'register']);

            $group->get('/login', [AuthController::class, 'showLoginForm'])->setName('auth.login');
            $group->post('/login', [AuthController::class, 'login']);
        });
    })->add(GuestMiddleware::class);

    // User access routes
    $app->group('', function (RouteCollectorProxy $group) {
        // Ranking
        $group->get('/ranking', [RankingController::class, 'index'])->setName('ranking');
        
        // Company management
        $group->get('/company', [CompanyController::class, 'getCompanyList'])->setName('company.list');
        $group->get('/company/create', [CompanyController::class, 'getCompanyNew'])->setName('company.create');
        $group->post('/company/create', [CompanyController::class, 'postCompanyNew']);
        
        // Exchange (stock market)
        $group->get('/exchange/prices', [ExchangeController::class, 'prices'])->setName('exchange.prices');
        $group->get('/exchange', [ExchangeController::class, 'getExchange'])->setName('exchange');
        $group->post('/exchange/sell', [ExchangeController::class, 'postExchangeSell'])->setName('exchange.sell');
        $group->post('/exchange/buy', [ExchangeController::class, 'postExchangeBuy'])->setName('exchange.buy');
        
        // Mail
        $group->get('/mail/received', [MailController::class, 'getReceivedMessages'])->setName('mail.received');
        $group->get('/mail/sent', [MailController::class, 'getSentMessages'])->setName('mail.sent');
        $group->get('/mail/new', [MailController::class, 'getNew'])->setName('mail.new');
        $group->post('/mail/new', [MailController::class, 'postNew']);
        $group->get('/mail/new/{nickname}', [MailController::class, 'getNewWithNickname'])->setName('mail.new.withnickname');
        $group->get('/mail/received/delete/{id}', [MailController::class, 'getDeleteReceived'])->setName('mail.received.delete');
        $group->get('/mail/sent/delete/{id}', [MailController::class, 'getDeleteSent'])->setName('mail.sent.delete');
        
        // Password changing
        $group->get('/auth/password/change', [AccountController::class, 'getChangePassword'])->setName('auth.password.change');
        $group->post('/auth/password/change', [AccountController::class, 'postChangePassword']);
        
        // Logout
        $group->get('/auth/signout', [AuthController::class, 'getSignOut'])->setName('auth.signout');
    });//->add(new UserMiddleware($container));
};
