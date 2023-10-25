<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Tag;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

final class TagFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        for ($index = 1; $index <= 25; ++$index) {
            $manager->persist((new Tag())->setName($faker->words(1, true)));
        }

        $manager->flush();
    }
}