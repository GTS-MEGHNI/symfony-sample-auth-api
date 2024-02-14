<?php

namespace App\Controller;

use App\DTO\CreateUpdatePostPayload;
use App\Entity\Post;
use App\Services\PostService;
use ParagonIE\Paseto\Exception\PasetoException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class PostController extends AbstractController implements TokenAuthenticatedController, PostMiddleware
{
    /**
     * @throws PasetoException
     */
    #[Route(path: 'api/posts', methods: ['POST'])]
    public function create(Request                                      $request,
                           #[MapRequestPayload] CreateUpdatePostPayload $payload,
                           PostService                                  $service): JsonResponse
    {
        $service->create($request, $payload);
        return $this->json($service->getPostAsArray(), Response::HTTP_CREATED);
    }

    #[Route(path: 'api/posts/{post}', methods: ['PATCH'])]
    #[IsGranted('POST_EDIT', subject: 'post')]
    public function update(Post                                         $post,
                           #[MapRequestPayload] CreateUpdatePostPayload $payload,
                           PostService                                  $service): JsonResponse
    {
        $service->update($post, $payload);
        return $this->json($service->getPostAsArray(), Response::HTTP_CREATED);
    }

    #[Route(path: 'api/posts/{post}', methods: ['DELETE'])]
    #[IsGranted('POST_DELETE', subject: 'post')]
    public function delete(Post        $post,
                           PostService $service): JsonResponse
    {
        $service->delete($post);
        return $this->json('', Response::HTTP_NO_CONTENT);
    }
}
