<?php

declare(strict_types=1);

namespace App\Auth\Presentation;

use App\SharedKernel\Application\View;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

final class AccountController
{
    public function __construct(
        private View $view,
    ) {}

    /**
     * Render password change form
     */
    public function getChangePassword(Request $request, Response $response): Response
    {
        return $this->view->render($response, 'auth/account/password/change');
    }

    /**
     * Try to change user's password
     */
    public function postChangePassword(Request $request, Response $response): Response
    {
        // if ($this->validator->validatePasswordChangeForm($request)->getErrorsCount() > 0)
        // {
        //     $_SESSION['errors'] = $this->validator->getErrors();
        //     return $response->withRedirect($this->router->pathFor('auth.password.change'));
        // }

        // $this->auth->user()->setPassword($request->getParam('password1'));

        // $this->flash->addMessage('success', 'Hasło zostało zmienione');

        // return $response->withRedirect($this->router->pathFor('auth.password.change'));

        dd('postChangePassword');
    }
}
