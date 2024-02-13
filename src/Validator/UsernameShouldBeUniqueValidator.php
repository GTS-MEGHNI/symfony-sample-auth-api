<?php

namespace App\Validator;

use App\Entity\User;
use App\Exceptions\UsernameAlreadyTakenException;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class UsernameShouldBeUniqueValidator extends ConstraintValidator
{
    public function __construct(public readonly EntityManagerInterface $entityManager)
    {
    }

    /**
     * @throws UsernameAlreadyTakenException
     */
    public function validate($value, Constraint $constraint): void
    {
        $repository = $this->entityManager->getRepository(User::class);
        $user = $repository->findOneByUsername($value);

        if($user != null)
            throw new UsernameAlreadyTakenException();
    }
}
