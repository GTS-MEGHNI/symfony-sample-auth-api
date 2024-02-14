<?php

namespace App\DTO;

use App\Validator\EmailShouldExist;
use Symfony\Component\Validator\Constraints as Assert;

readonly class LoginRequest
{
    public function __construct(
        #[Assert\Email(), EmailShouldExist()]
        public string $email,
        #[Assert\Length(min: 8, max: 60)]
        public string $password)
    {

    }
}