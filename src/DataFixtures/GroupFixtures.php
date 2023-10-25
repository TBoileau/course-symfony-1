<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Group;
use App\Entity\Tag;
use App\Repository\TagRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

final class GroupFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        /** @var TagRepository $tagRepository */
        $tagRepository = $manager->getRepository(Tag::class);

        $tags = $tagRepository->findAll();

        for ($index = 0; $index < 5; ++$index) {
            $group = (new Group())->setName($faker->words(2, true));

            $groupTags = array_merge(
                array_slice($tags, $index * 5, 10),
                ($index * 5) + 10 > count($tags) ? array_slice($tags, 0, 5) : []
            );

            foreach ($groupTags as $tag) {
                $group->addTag($tag);
            }

            $manager->persist($group);
        }

        $manager->flush();
    }

    /**
     * @return array<array-key, class-string<Fixture>>
     */
    public function getDependencies(): array
    {
        return [TagFixtures::class];
    }
}