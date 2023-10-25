<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Group;
use App\Entity\Person;
use App\Repository\GroupRepository;
use App\Repository\PersonRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

final class PersonFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        /** @var PersonRepository $personRepository */
        $personRepository = $manager->getRepository(Person::class);

        /** @var GroupRepository $groupRepository */
        $groupRepository = $manager->getRepository(Group::class);

        $groups = $groupRepository->findAll();

        foreach ($groups as $group) {
            for ($index = 1; $index <= 10; ++$index) {
                $personRepository->create(
                    (new Person())
                        ->setFirstName($faker->firstName())
                        ->setLastName($faker->lastName())
                        ->setEmail(sprintf('person+%d@email.com', $index))
                        ->setGroup($group)
                );
            }
        }
    }

    /**
     * @return array<array-key, class-string<Fixture>>
     */
    public function getDependencies(): array
    {
        return [GroupFixtures::class];
    }
}
