<?php

namespace App\EventListener;

use App\Exceptions\EmailAlreadyTakenException;
use App\Exceptions\EmailNotFoundException;
use App\Exceptions\InvalidPasswordException;
use App\Exceptions\UsernameAlreadyTakenException;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;

final class ExceptionListener
{
    const CLASSES_TO_LISTEN = [
        InvalidPasswordException::class,
        EmailAlreadyTakenException::class,
        EmailNotFoundException::class,
        UsernameAlreadyTakenException::class
    ];

    /** @noinspection PhpPossiblePolymorphicInvocationInspection
     * @noinspection PhpUnused
     */
    #[AsEventListener(event: 'kernel.exception')]
    public function renderException(ExceptionEvent $event): void
    {
        $throwable = $event->getThrowable();
        if(in_array(get_class($event->getThrowable()), self::CLASSES_TO_LISTEN)) {
            $event->setResponse($throwable->getJsonResponse());
        }
    }
}
