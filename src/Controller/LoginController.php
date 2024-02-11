<?php

namespace App\Controller;

use App\DTO\LoginRequest;
use App\Services\LoginService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

class LoginController extends AbstractController
{
    #[Route('api/login', name: 'app_login')]
    public function index(#[MapRequestPayload] LoginRequest $request, LoginService $service): Response
    {
        $service->authenticate($request);
        return $this->json($service->respondWithToken());
    }
}
