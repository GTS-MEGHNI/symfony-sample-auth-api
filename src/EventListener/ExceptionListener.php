<?php

namespace App\EventListener;

use App\Exceptions\InvalidPasswordException;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;

final class ExceptionListener
{
    #[AsEventListener(event: 'kernel.exception')]
    public function renderException(ExceptionEvent $event): void
    {
        if ($event->getThrowable() instanceof InvalidPasswordException)
            $event->setResponse(new JsonResponse([
                'status' => 'error',
                'message' => $event->getThrowable()->getMessage()
            ], 401));
    }
}
