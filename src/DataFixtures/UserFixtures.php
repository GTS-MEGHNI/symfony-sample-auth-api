<?php

namespace App\DataFixtures;

use App\Entity\Post;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory as Faker;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    private $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    const COUNT = 10;
    public function load(ObjectManager $manager): void
    {
        for ($i = 1; $i <= self::COUNT; $i++) {
            $faker = Faker::create();
            $user = new User();
            $user->setEmail($faker->safeEmail);
            $user->setUsername($faker->userName);
            $user->setPassword($this->passwordHasher->hashPassword($user, 'password'));
            $post = new Post();
            $post->setTitle('Hi this is sa title');
            $user->addPost($post);
            $manager->persist($user);
            $manager->flush();
        }
    }

}
