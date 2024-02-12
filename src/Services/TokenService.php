<?php /** @noinspection SpellCheckingInspection */

namespace App\Services;

use App\Entity\User;
use ParagonIE\Paseto\Builder;
use ParagonIE\Paseto\Exception\InvalidKeyException;
use ParagonIE\Paseto\Exception\InvalidPurposeException;
use ParagonIE\Paseto\Exception\PasetoException;
use ParagonIE\Paseto\Keys\Version4\SymmetricKey;
use ParagonIE\Paseto\Protocol\Version4;
use ParagonIE\Paseto\Purpose;

class TokenService
{
    private const BASE64_SECRET_KEY = 'wHr4Zi9ajx8Qjoacz93LTz18MYSQL642NnVicarVpcHU3oxGlcBWE0bZB6Tdfpu';

    /**
     * @throws InvalidPurposeException
     * @throws PasetoException
     * @throws InvalidKeyException
     */
    public static function createToken(User $user): string
    {
        $secretKey = hash('sha256', static::BASE64_SECRET_KEY, true);
        $token = (new Builder())
            ->setKey(new SymmetricKey($secretKey))
            ->setVersion(new Version4)
            ->setPurpose(Purpose::local())
            ->setIssuedAt()
            ->setNotBefore()
            ->setNonExpiring(true)
            ->setClaims([
                'userId' => $user->getId(),
            ]);
        return $token->toString();
    }

}