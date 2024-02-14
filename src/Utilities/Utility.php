<?php

namespace App\Utilities;

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
}