<?php

namespace App\Exceptions;

use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class EmailAlreadyTakenException extends Exception
{
    public function getJsonResponse(): JsonResponse
    {
        return new JsonResponse([
            'status' => 'error',
            'message' => 'The email has already been taken'
        ], 422);
    }
}