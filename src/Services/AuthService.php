<?php

namespace App\Services;

use App\Entity\User;
use ParagonIE\Paseto\Exception\InvalidKeyException;
use ParagonIE\Paseto\Exception\InvalidPurposeException;
use ParagonIE\Paseto\Exception\PasetoException;

class AuthService
{
    protected User $user;

    /**
     * @return array
     * @throws InvalidKeyException
     * @throws InvalidPurposeException
     * @throws PasetoException
     */
    public function respondWithToken(): array
    {
        return $this->user->toArrayWithToken();
    }

}