<?php

namespace App\Controller;

use App\DTO\CreatePostPayload;
use App\Entity\Post;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

class PostController extends AbstractController implements TokenAuthenticatedController
{
    #[Route(path: 'api/posts', requirements: ['userId' => '\d+'], methods: ['POST'])]
    public function create(#[MapRequestPayload] CreatePostPayload $payload, EntityManagerInterface $manager)
    {
        $post = new Post();
        $post->setTitle($payload->title);
        $user->addPost($post);
        $manager->persist($user);
        $manager->flush();
        return $this->json($post->toArray(), 201);
    }
}
