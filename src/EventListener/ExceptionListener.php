<?php

namespace App\EventListener;

use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;

final class ExceptionListener
{
    #[AsEventListener(event: 'kernel.exception')]
    public function renderException(ExceptionEvent $event): void
    {
        $event->setResponse(new JsonResponse([
            'status' => 'error',
            'message' => $event->getThrowable()->getMessage()
        ],401));
    }
}
