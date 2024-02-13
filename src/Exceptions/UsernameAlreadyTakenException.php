<?php

namespace App\Exceptions;

use Exception;
use JsonException;
use Symfony\Component\HttpFoundation\JsonResponse;

class UsernameAlreadyTakenException extends Exception
{

    public function getJsonResponse(): JsonResponse
    {
        return new JsonResponse([
            'status' => 'error',
            'message' => 'The selected usernmae has already been taken'
        ], 422);
    }

}