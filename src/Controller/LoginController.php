<?php

namespace App\Controller;

use App\DTO\LoginRequest;
use App\Exceptions\InvalidPasswordException;
use App\Services\LoginService;
use Random\RandomException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

class LoginController extends AbstractController
{
    /**
     * @throws InvalidPasswordException
     * @throws RandomException
     */
    #[Route('api/login', name: 'app_login', methods: ['POST'])]
    public function index(#[MapRequestPayload] LoginRequest $request, LoginService $service): Response
    {
        $service->authenticate($request);
        return $this->json($service->respondWithToken());
    }
}
