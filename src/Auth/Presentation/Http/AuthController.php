<?php

declare(strict_types=1);

namespace App\Auth\Presentation;

use App\Auth\Domain\ValueObject\Email;
use App\Auth\Domain\ValueObject\HashedPassword;
use App\Auth\Domain\ValueObject\UserId;
use App\Models\User;
use App\SharedKernel\Application\SessionStore;
use App\SharedKernel\Application\View;
use App\SharedKernel\Application\HttpResponseFactory;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Ramsey\Uuid\Uuid;

final class AuthController
{
    public function __construct(
        private SessionStore $session,
        private HttpResponseFactory $responseFactory,
        private View $view,
    ) {}

    /**
     * Sign user out and redirect to home
     */
    public function getSignOut(Request $request, Response $response): Response
    {
        $this->session->destroy();

        return $this->responseFactory->redirectToRoute($response, 'home');
    }

    /**
     * Render sign up form
     */
    public function getSignUp(Request $request, Response $response): Response
    {
        return $this->view->render($response, 'auth/signup');
    }

    /**
     * Render sign in form
     */
    public function getSignIn(Request $request, Response $response): Response
    {
        return $this->view->render($response, 'auth/signin');
    }

    /**
     * Register a new user, log in and redirect to home
     */
    public function postRegister(Request $request, Response $response): Response
    {
        // if ($this->validator->validateRegisterForm($request)->getErrorsCount() > 0)
        // {
        //     $_SESSION['errors'] = $this->validator->getErrors();
        //     return $this->responseFactory->redirectToRoute($response, 'auth.signup');
        // }

        $body = $request->getParsedBody();
        
        $user = User::register(
            id: new UserId(Uuid::uuid7()->toString()),
            email: new Email($body['email']),
            passwordHash: new HashedPassword(password_hash($body['password'], PASSWORD_DEFAULT)),
            registeredAt: new \DateTimeImmutable()
        );

        // $this->flash->addMessage('success', 'Zostałeś zarejestrowany oraz zalogowany');

        $this->session->set('user', $user->id);

        return $this->responseFactory->redirectToRoute($response, 'home');
    }

    /**
     * Try to sign user in
     */
    public function postSignIn(Request $request, Response $response): Response
    {
        // if ($this->validator->validateLoginForm($request)->getErrorsCount() > 0)
        // {
        //     $_SESSION['errors'] = $this->validator->getErrors();
        //     return $this->responseFactory->redirectToRoute($response, 'auth.signin');
        // }
        
        // $auth = $this->auth->attempt(
        //     $request->getParam('email'),
        //     $request->getParam('password')
        // );

        // if (!$auth)
        // {
        //     $this->flash->addMessage('danger', 'Podano błędne dane');
        //     return $this->responseFactory->redirectToRoute($response, 'auth.signin');
        // }

        // return $this->responseFactory->redirectToRoute($response, 'home');

        dd('postSignIn');
    }
}
