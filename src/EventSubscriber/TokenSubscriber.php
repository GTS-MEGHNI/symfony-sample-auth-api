<?php

namespace App\EventSubscriber;

use App\Controller\TokenAuthenticatedController;
use App\Exceptions\InvalidTokenException;
use App\Services\TokenService;
use App\Utilities\Utility;
use ParagonIE\Paseto\Exception\PasetoException;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class TokenSubscriber implements EventSubscriberInterface
{
    /**
     * @throws PasetoException
     * @throws InvalidTokenException
     */
    public function onControllerEvent(ControllerEvent $event): void
    {
        $controller = $event->getController();
        if(is_array($controller))
            $controller = $controller[0];

        if($controller instanceof TokenAuthenticatedController) {
            $token = Utility::getBearerToken($event->getRequest());
            if(TokenService::errorInToken($token))
                throw new InvalidTokenException();
        }


    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::CONTROLLER => 'onControllerEvent',
        ];
    }
}
