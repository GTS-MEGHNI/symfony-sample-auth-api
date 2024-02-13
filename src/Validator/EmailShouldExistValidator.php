<?php

namespace App\Validator;

use App\Entity\User;
use App\Exceptions\EmailNotFoundException;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class EmailShouldExistValidator extends ConstraintValidator
{
    public function __construct(public EntityManagerInterface $manager, public RequestStack $requestStack)
    {

    }

    /**
     * @throws EmailNotFoundException
     */
    public function validate($value, Constraint $constraint): void
    {
        $userRepository = $this->manager->getRepository(User::class);
        $user = $userRepository->findOneByEmail($value);
        if ($user == null)
            throw new EmailNotFoundException();

    }
}
