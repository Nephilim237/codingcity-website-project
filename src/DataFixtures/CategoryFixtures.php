<?php

namespace App\DataFixtures;

use App\Entity\Post\Category;
use App\Repository\Post\PostRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class CategoryFixtures extends Fixture implements DependentFixtureInterface
{
    public function __construct(private readonly PostRepository $postRepository) {

    }
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        $categories = [];
        for ($c = 0; $c < 10; $c++) {
            $category = new Category();
            $category
                ->setTitle($faker->word() .' '. $c)
                ->setDescription(
                    mt_rand(0, 1) === 1 ? $faker->realText(254) : ''
                )
            ;
            $manager->persist($category);
            $categories[] = $category;
        }

        $posts = $this->postRepository->findAll();

        foreach ($posts as $post) {
            for ($p = 0; $p < mt_rand(1, 5); $p++) {
                $post->addCategory(
                    $categories[mt_rand(0, count($categories) - 1)]
                );
            }
        }

        $manager->flush();
    }

    /**
     * @return string[]
     */
    public function getDependencies(): array
    {
        return [PostFixtures::class];
    }
}
