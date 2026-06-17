<?php

namespace App\Middleware\AuthMiddleware;

use App\Middleware\Middleware;

class UserMiddleware extends Middleware
{
    /**
     * User middleware
     *
     * @param Request $request
     * @param Response $response
     * @param Middleware $next
     * @return Response
     */
    public function __invoke($request, $response, $next)
    {
        if (!$this->auth->check())
        {
            $this->flash->addMessage('danger', 'Zaloguj się aby dostać się do tej podstrony');
            return $response->withRedirect($this->router->pathFor('auth.signin'));
        }
        
        return $next($request, $response);
    }
}
