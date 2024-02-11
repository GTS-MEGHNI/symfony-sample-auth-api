<?php

namespace App\Services;

use App\DTO\LoginRequest;
use App\Entity\User;
use App\Exceptions\InvalidPasswordException;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class LoginService
{
    public function __construct(
        public EntityManagerInterface $entityManager,
        public UserPasswordHasherInterface $userPasswordHasher)
    {

    }

    public function authenticate(LoginRequest $request)
    {
        $userRepository = $this->entityManager->getRepository(User::class);
        $user = $userRepository->findOneByEmail($request->email);
        if(!$this->userPasswordHasher->isPasswordValid($user, $request->password))
            throw new InvalidPasswordException('Invalid password');
    }

}