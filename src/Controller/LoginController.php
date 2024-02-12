<?php

namespace App\Controller;

use App\DTO\LoginRequest;
use App\Exceptions\InvalidPasswordException;
use App\Services\LoginService;
use ParagonIE\Paseto\Exception\InvalidKeyException;
use ParagonIE\Paseto\Exception\InvalidPurposeException;
use ParagonIE\Paseto\Exception\PasetoException;
use Random\RandomException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

class LoginController extends AbstractController
{
    /**
     * @param LoginRequest $request
     * @param LoginService $service
     * @return Response
     * @throws InvalidPasswordException
     * @throws InvalidKeyException
     * @throws InvalidPurposeException
     * @throws PasetoException
     */
    #[Route('api/login', name: 'app_login', methods: ['POST'])]
    public function index(#[MapRequestPayload] LoginRequest $request, LoginService $service): Response
    {
        $service->authenticate($request);
        return $this->json($service->respondWithToken());
    }
}
