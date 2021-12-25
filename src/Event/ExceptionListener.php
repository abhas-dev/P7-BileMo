<?php

namespace App\Event;

use App\Exception\CustomerNotFoundException;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Contracts\EventDispatcher\Event;

class ExceptionListener extends Event
{
    public function onKernelException(ExceptionEvent $event)
    {
        // You get the exception object from the received event
        $exception = $event->getThrowable();
        $data = ["error" => $exception->getMessage()];

        // Customize your response object to display the exception details
        $response = new JsonResponse($data);

        // HttpExceptionInterface is a special type of exception that
        // holds status code and header details

        if ($exception instanceof CustomerNotFoundException) {
            $response->setStatusCode(Response::HTTP_NOT_FOUND);
        } else if ($exception instanceof HttpExceptionInterface) {
            $response->setStatusCode($exception->getStatusCode());
            $response->headers->replace($exception->getHeaders());
        } else {
            dd('a');
            $response->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        // sends the modified response object to the event
        $event->setResponse($response);
    }

}