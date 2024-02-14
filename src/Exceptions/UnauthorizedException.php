<?php

namespace App\Exceptions;

use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;

class UnauthorizedException extends Exception
{
    public function getJsonResponse(): JsonResponse
    {
        return new JsonResponse([
            'status' => 'error',
            'message' => 'You are unauthorized to perform this action'
        ], 403);
    }
}