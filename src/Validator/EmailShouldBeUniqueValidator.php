<?php

namespace App\Validator;

use App\Entity\User;
use App\Exceptions\EmailAlreadyTakenException;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class EmailShouldBeUniqueValidator extends ConstraintValidator
{
    public function __construct(public readonly EntityManagerInterface $entityManager)
    {

    }


    /**
     * @throws EmailAlreadyTakenException
     */
    public function validate($value, Constraint $constraint): void
    {
        $repository = $this->entityManager->getRepository(User::class);
        $row = $repository->findOneByEmail($value);
        if($row != null) {
            throw new EmailAlreadyTakenException();
        }
    }
}
