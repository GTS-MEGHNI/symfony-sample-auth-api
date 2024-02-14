<?php

namespace App\Exceptions;

use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;

class PostNotFoundException extends Exception
{
    /** @noinspection PhpMissingParentConstructorInspection */
    public function __construct(public string $postId)
    {
    }

    public function getJsonResponse(): JsonResponse
    {
        return new JsonResponse([
            'status' => 'error',
            'message' => 'The post with the id ' . $this->postId . ' was not found'
        ], 404);
    }
}