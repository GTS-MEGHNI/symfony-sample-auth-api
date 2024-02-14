<?php

namespace App\DTO;

use Symfony\Component\Validator\Constraints as Assert;

readonly class CreatePostPayload
{
    public function __construct(
        #[Assert\Length(
            min: 5,
            max: 40,
            minMessage: 'Title should be more than 5 characters',
            maxMessage: 'Title should be less than 40 characters'
        )]
        public string $title,
        #[Assert\Length(
            min: 32,
            max: 512,
            minMessage: 'Content should be more than 32 characters',
            maxMessage: 'Content should be less than 512 characters'
        )]
        public string $content)
    {
    }
}