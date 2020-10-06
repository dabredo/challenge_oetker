<?php

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class RequestSubscriber implements EventSubscriberInterface
{
    public function onKernelController(ControllerEvent $event): void
    {
        $request = $event->getRequest();

        if ($request->headers->get('Content-Type') === 'application/json') {
            $data = json_decode($request->getContent(), true);
            if (is_null($data)) {
                throw new BadRequestHttpException("Request format incorrect");
            }

            $request->request->replace(is_array($data) ? $data : []);
        }
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::CONTROLLER => 'onKernelController',
        ];
    }
}
