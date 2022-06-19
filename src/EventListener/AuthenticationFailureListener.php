<?php

namespace App\EventListener;

use App\Constants\ExceptionMessageConstants;
use App\Traits\JsonResponseTrait;
use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationFailureEvent;
use Lexik\Bundle\JWTAuthenticationBundle\Response\JWTAuthenticationFailureResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class AuthenticationFailureListener
{
    use JsonResponseTrait;

    public function onAuthenticationFailureResponse(AuthenticationFailureEvent $event): void
    {
        $response = $this->error(ExceptionMessageConstants::CREDENTIALS_INVALID);

        $event->setResponse($response);
    }
}
