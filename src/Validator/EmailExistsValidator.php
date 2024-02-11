<?php

namespace App\Validator;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class EmailExistsValidator extends ConstraintValidator
{
    public function __construct(public EntityManagerInterface $manager, public RequestStack $requestStack)
    {

    }

    public function validate($value, Constraint $constraint): void
    {
        $userRepository = $this->manager->getRepository(User::class);
        $user = $userRepository->findOneByEmail($value);
        if ($user == null)
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ value }}', $value)
                ->addViolation();
    }
}
