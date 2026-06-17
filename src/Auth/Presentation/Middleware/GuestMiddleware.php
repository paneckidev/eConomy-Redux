<?php

declare(strict_types=1);

namespace App\Auth\Presentation\Middleware;

use App\SharedKernel\Application\SessionStore;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface as Handler;

final class GuestMiddleware implements MiddlewareInterface
{
    public function __construct(
        private SessionStore $session,
        private HttpResponseFactory $responseFactory,
    ) {
    }

    public function process(Request $request, Handler $handler): Response
    {
        if ($this->session->has('user_id'))
        {
            return $this->responseFactory->redirectToRoute($response, 'home');
        }
        
        return $handler->handle($request);