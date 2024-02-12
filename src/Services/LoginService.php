<?php

namespace App\Services;

use App\DTO\LoginRequest;
use App\Entity\User;
use App\Exceptions\InvalidPasswordException;
use Doctrine\ORM\EntityManagerInterface;
use Random\RandomException;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class LoginService
{
    private User $user;

    public function __construct(
        public EntityManagerInterface      $entityManager,
        public UserPasswordHasherInterface $userPasswordHasher)
    {

    }

    /**
     * @throws InvalidPasswordException
     */
    public function authenticate(LoginRequest $request): void
    {
        $userRepository = $this->entityManager->getRepository(User::class);
        $this->user = $userRepository->findOneByEmail($request->email);
        if (!$this->userPasswordHasher->isPasswordValid($this->user, $request->password))
            throw new InvalidPasswordException('Invalid password');
    }

    /**
     * @throws RandomException
     */
    public function respondWithToken(): array
    {
        return $this->user->toArrayWithToken();
    }

}