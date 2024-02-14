<?php

namespace App\Controller;

use App\DTO\CreatePostPayload;
use App\Entity\Post;
use App\Entity\User;
use App\Utilities\Utility;
use Carbon\Carbon;
use Doctrine\ORM\EntityManagerInterface;
use ParagonIE\Paseto\Exception\PasetoException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

class PostController extends AbstractController implements TokenAuthenticatedController
{
    /**
     * @throws PasetoException
     */
    #[Route(path: 'api/posts', methods: ['POST'])]
    public function create(Request $request, #[MapRequestPayload] CreatePostPayload $payload, EntityManagerInterface $manager): JsonResponse
    {
        $post = new Post();
        $post->setTitle($payload->title);
        $post->setContent($payload->content);
        $post->setCreatedAt(Carbon::now());
        $user = $manager->getRepository(User::class)->find(Utility::getUserId($request));
        $user->addPost($post);
        $manager->persist($user);
        $manager->flush();
        return $this->json($post->toArray(), 201);
    }
}
