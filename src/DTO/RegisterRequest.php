<?php

namespace App\DTO;

use App\Entity\User;
use App\Validator\EmailShouldBeUnique;
use App\Validator\Unique;
use App\Validator\UsernameShouldBeUnique;
use Symfony\Component\Validator\Constraints as Assert;

readonly class RegisterRequest
{

    public function __construct(
        #[Assert\NotBlank(), Assert\Length(min: 3, max: 30)]
        public string $firstName,
        #[Assert\NotBlank(), Assert\Length(min: 3, max: 30)]
        public string $lastName,
        #[Assert\NotBlank(), Assert\Length(min: 3, max: 30), UsernameShouldBeUnique()]
        public string $username,
        #[Assert\NotBlank(), Assert\Email, EmailShouldBeUnique()]
        public string $email,
        #[Assert\NotBlank(), Assert\Length(min: 8, max: 20)]
        public string $password,
        #[Assert\NotNull(), Assert\Type('bool')]
        public bool $isSubscribedToNewsLetter)
    {
    }

}