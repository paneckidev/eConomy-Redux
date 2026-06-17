<?php

declare(strict_types=1);

namespace App\Auth\Application\UseCase\SignOut;

final class SignOutCommand
{
    // public function __construct(
    //     private Auth $auth,
    //     private Router $router,
    // ) {}

    public function execute()
    {
        // $this->auth->logout();
        
        // return $this->router->pathFor('home');

        dd('SignOutCommand');
    }
}