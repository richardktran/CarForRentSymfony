<?php

namespace App\EventListener;

use App\Traits\JsonResponseTrait;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

class ExceptionListener
{
    use JsonResponseTrait;

    public function onKernelException(ExceptionEvent $event)
    {
        $exception = $event->getThrowable();
        if ($exception instanceof HttpExceptionInterface) {
            $response = $this->error($exception->getMessage(), $exception->getStatusCode());
        } else {
            $response = $this->error("Internal error", $exception->getStatusCode());
        }

        // sends the modified response object to the event
        $event->setResponse($response);
    }
}
