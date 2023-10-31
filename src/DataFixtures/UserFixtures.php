<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

final class UserFixtures extends Fixture
{
    public function __construct(private readonly UserPasswordHasherInterface $passwordHasher)
    {
    }

    public function load(ObjectManager $manager): void
    {
        for ($index = 1; $index <= 10; ++$index) {
            $user = new User();
            $user->setEmail(sprintf('user+%d@email.com', $index));

            $user->setPassword(
                $this->passwordHasher->hashPassword(
                    $user,
                    'password'
                )
            );

            if ($index === 1) {
                $user->setAdmin(true);
            }

            $manager->persist($user);
        }

        $manager->flush();
    }
}