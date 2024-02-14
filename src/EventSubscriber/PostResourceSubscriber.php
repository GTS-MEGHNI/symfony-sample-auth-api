<?php

namespace App\EventSubscriber;

use App\Controller\PostMiddleware;
use App\Entity\Post;
use App\Exceptions\PostNotFoundException;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class PostResourceSubscriber implements EventSubscriberInterface
{
    public function __construct(public EntityManagerInterface $manager)
    {

    }

    /**
     * @throws PostNotFoundException
     */
    public function onControllerEvent(ControllerEvent $event): void
    {
        $controller = $event->getController();
        $method = null;
        if (is_array($controller)) {
            $method = $controller[1];
            $controller = $controller[0];
        }

        if ($controller instanceof PostMiddleware) {
            if (in_array($method, ['update', 'delete'])) {
                $post = $this->manager->getRepository(Post::class)->find(intval($event->getRequest()->get('post')));
                if ($post == null)
                    throw new PostNotFoundException($event->getRequest()->get('post'));
            }

        }

    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::CONTROLLER => 'onControllerEvent'
        ];
    }
}
