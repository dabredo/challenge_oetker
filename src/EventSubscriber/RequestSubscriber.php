<?php

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use App\Controller\AuthenticationRequiredInterface;

class RequestSubscriber implements EventSubscriberInterface
{
    // TODO: Move to secure place
    private const API_KEY = '12345';

    public function onKernelController(ControllerEvent $event): void
    {
        $request = $event->getRequest();
        $controller = $event->getController();

        if (
            is_array($controller) &&
            $controller[0] instanceof AuthenticationRequiredInterface &&
            $request->headers->get('api-key') !== self::API_KEY
        ) {
            throw new UnauthorizedHttpException('', 'Unauthorized');
        }

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
