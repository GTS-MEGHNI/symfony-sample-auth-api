<?php

namespace App\Utilities;

use App\Entity\User;
use App\Services\TokenService;
use Doctrine\ORM\EntityManagerInterface;
use ParagonIE\Paseto\Exception\PasetoException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

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

    /**
     * @throws PasetoException
     */
    public static function getUserFromBearerToken(RequestStack $requestStack, EntityManagerInterface $manager): User
    {
        return $manager->getRepository(User::class)
            ->find(self::getUserId($requestStack->getCurrentRequest()));
    }
}