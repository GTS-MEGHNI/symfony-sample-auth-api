<?php

namespace App\Exceptions;

use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;

class EmailNotFoundException extends Exception
{
    public function getJsonResponse(): JsonResponse
    {
        return new JsonResponse([
            'status' => 'error',
            'message' => 'The email was not found in our records'
        ], 422);
    }

}