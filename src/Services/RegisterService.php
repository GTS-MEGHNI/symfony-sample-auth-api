<?php

namespace App\Services;

use App\DTO\RegisterRequest;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class RegisterService extends AuthService
{
    public function __construct(public UserPasswordHasherInterface $hasher,
                                public EntityManagerInterface $manager)
    {

    }

    public function registerUser(RegisterRequest $request)
    {
        $this->user = new User();
        $this->user->setEmail($request->email);
        $this->user->setUsername($request->username);
        $this->user->setPassword($this->hasher->hashPassword($this->user, $request->password));
        $this->manager->persist($this->user);
        $this->manager->flush();
    }

}