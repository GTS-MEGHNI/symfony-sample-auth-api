<?php

namespace App\Controller;

use App\DTO\LoginRequest;
use App\DTO\RegisterRequest;
use App\Exceptions\InvalidPasswordException;
use App\Services\LoginService;
use App\Services\RegisterService;
use ParagonIE\Paseto\Exception\InvalidKeyException;
use ParagonIE\Paseto\Exception\InvalidPurposeException;
use ParagonIE\Paseto\Exception\PasetoException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

class AuthController extends AbstractController
{
    /**
     * @param LoginRequest $request
     * @param LoginService $service
     * @return JsonResponse
     * @throws InvalidKeyException
     * @throws InvalidPasswordException
     * @throws InvalidPurposeException
     * @throws PasetoException
     */
    #[Route('api/login', name: 'api_login', methods: ['POST'])]
    public function login(#[MapRequestPayload] LoginRequest $request, LoginService $service): JsonResponse
    {
        $service->authenticate($request);
        return $this->json($service->respondWithToken());
    }

    /**
     * @throws InvalidPurposeException
     * @throws PasetoException
     * @throws InvalidKeyException
     */
    #[Route(path: 'api/register', methods: ['POST'])]
    public function register(#[MapRequestPayload] RegisterRequest $request, RegisterService $service): JsonResponse
    {
        $service->registerUser($request);
        return $this->json($service->respondWithToken());
    }


}
