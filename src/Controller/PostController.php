<?php

namespace App\Controller;

use App\DTO\CreatePostPayload;
use App\Entity\Post;
use App\Entity\User;
use App\Services\PostService;
use App\Utilities\Utility;
use Carbon\Carbon;
use Doctrine\ORM\EntityManagerInterface;
use ParagonIE\Paseto\Exception\PasetoException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

class PostController extends AbstractController implements TokenAuthenticatedController
{
    /**
     * @throws PasetoException
     */
    #[Route(path: 'api/posts', methods: ['POST'])]
    public function create(Request $request,
                           #[MapRequestPayload] CreatePostPayload $payload,
                           PostService $service): JsonResponse
    {
        $service->create($request, $payload);
        return $this->json($service->getPostAsArray(), Response::HTTP_CREATED);
    }
}
