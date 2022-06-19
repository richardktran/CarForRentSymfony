<?php

namespace App\EventListener;

use App\Constants\ExceptionMessageConstants;
use App\Traits\JsonResponseTrait;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Symfony\Component\Validator\Exception\ValidatorException;

class ExceptionListener
{
    use JsonResponseTrait;

    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();
        if ($exception instanceof ValidatorException) {
            $response = $this->error(ExceptionMessageConstants::BAD_REQUEST, $exception->getCode());
        } elseif ($exception instanceof UnauthorizedHttpException) {
            $response = $this->error(ExceptionMessageConstants::UNAUTHORIZED, $exception->getStatusCode());
        } elseif ($exception instanceof HttpExceptionInterface) {
            $response = $this->error($exception->getMessage(), $exception->getStatusCode());
        } else {
            $response = $this->error($exception->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }


        $event->setResponse($response);
    }
}
