<?php

namespace App\Utilities;

use App\Services\TokenService;
use ParagonIE\Paseto\Exception\PasetoException;
use Symfony\Component\HttpFoundation\Request;

class Utility
{
    public static function getBearerToken(Request $request): ?string
    {
        $authorizationHeader = $request->headers->get('Authorization');
        if ($authorizationHeader && preg_match('#Bearer\s+(.+)#i', $authorizationHeader, $matches)) {
            return $matches[1];
        } else {
            return null;
        }
    }

    /**
     * @throws PasetoException
     */
    public static function getUserId(Request $request): int
    {
        $token = self::getBearerToken($request);
        $parsedToken = TokenService::parseToken($token);
        return $parsedToken->getClaims()['userId'];
    }
}