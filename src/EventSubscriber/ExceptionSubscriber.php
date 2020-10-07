<?php

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;

class ExceptionSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [
           KernelEvents::EXCEPTION => 'onKernelException',
        ];
    }

    public function onKernelException(ExceptionEvent $event)
    {
        $exception = $event->getThrowable();

        $response = new JsonResponse(
            [ 'error' => 'Internal error' ],
            JsonResponse::HTTP_INTERNAL_SERVER_ERROR
        );

        if ($exception instanceof HttpExceptionInterface) {
            $response = new JsonResponse(
                 [ 'error' => $exception->getMessage()],
                 $exception->getStatusCode()
            );
        }

        $event->setResponse($response);
    }
}
