<?php

namespace App\EventListener;

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

    public function onKernelException(ExceptionEvent $event)
    {
        $exception = $event->getThrowable();
        if ($exception instanceof UnauthorizedHttpException) {
            $response = $this->error("Unauthorized", $exception->getStatusCode());
        } elseif ($exception instanceof HttpExceptionInterface) {
            $response = $this->error($exception->getMessage(), $exception->getStatusCode());
        } elseif ($exception instanceof ValidatorException) {
            $response = $this->error($exception->getMessage(), $exception->getCode());
        } else {
            $response = $this->error($exception->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        // sends the modified response object to the event
        $event->setResponse($response);
    }
}
