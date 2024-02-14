<?php

namespace App\Security\Voter;

use App\Entity\Post;
use App\Exceptions\UnauthorizedException;
use App\Utilities\Utility;
use Doctrine\ORM\EntityManagerInterface;
use ParagonIE\Paseto\Exception\PasetoException;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;


class BlogPostVoter extends Voter
{
    public const EDIT = 'POST_EDIT';
    public const VIEW = 'POST_VIEW';
    public const DELETE = 'POST_DELETE';

    public function __construct(public RequestStack $requestStack, public EntityManagerInterface $manager)
    {

    }

    protected function supports(string $attribute, mixed $subject): bool
    {
        return in_array($attribute, [self::EDIT, self::VIEW, self::DELETE])
            && $subject instanceof Post;
    }

    /**
     * @throws PasetoException
     * @throws UnauthorizedException
     */
    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        $user = Utility::getUserFromBearerToken($this->requestStack, $this->manager);

        $check = match ($attribute) {
            self::DELETE, self::EDIT => $subject->getAuthor()->getId() == $user->getId(),
            default => false,
        };

        if(!$check) {
            throw new UnauthorizedException();
        }

        return true;
    }
}
