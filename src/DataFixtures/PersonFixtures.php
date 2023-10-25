<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Person;
use App\Repository\PersonRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

final class PersonFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        /** @var PersonRepository $personRepository */
        $personRepository = $manager->getRepository(Person::class);

        for ($index = 1; $index <= 50; ++$index) {
            $personRepository->create(
                Person::createPerson([
                    'firstName' => $faker->firstName(),
                    'lastName' => $faker->lastName(),
                    'email' => sprintf('person+%d@email.com', $index),
                ])
            );
        }
    }
}
