<?php

namespace App\EventListener;

use App\Traits\JsonResponseTrait;
use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationFailureEvent;
use Lexik\Bundle\JWTAuthenticationBundle\Response\JWTAuthenticationFailureResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class AuthenticationFailureListener
{
    use JsonResponseTrait;

    public function onAuthenticationFailureResponse(AuthenticationFailureEvent $event)
    {
        $response = $this->error('Credentials invalid', Response::HTTP_BAD_REQUEST);

        $event->setResponse($response);
    }
}
