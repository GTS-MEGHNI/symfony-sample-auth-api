<?php

namespace App\DTO;

use Symfony\Component\Validator\Constraints as Assert;

readonly class CreatePostPayload
{
    public function __construct(
        #[Assert\NotBlank(), Assert\Length(min: 5, max: 40)]
        public string $title,
        #[Assert\NotBlank(), Assert\Length(min: 32, max: 512)]
        public string $content
    )
    {
    }
}