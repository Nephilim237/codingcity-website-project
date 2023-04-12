<?php

namespace App\DataFixtures;

use App\Entity\Post\Post;
use App\Entity\Post\Thumbnail;
use App\Entity\Post\Video;
use App\Repository\UserRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class PostFixtures extends Fixture implements DependentFixtureInterface
{
    public function __construct(private readonly UserRepository $userRepository)
    {
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        $users = $this->userRepository->findAll();

        for ($p = 0; $p <= 100; $p++) {

            $video = new Video();
            $video->setLink('https://www.youtube.com/embed/Sjd3_e2la7Q');

            $thumbnail = new Thumbnail();
            $thumbnail->setImageName($faker->image('public/uploads/images/posts/banner', 750, 350, 'animals', false, true));

            $manager->persist($thumbnail);

            $post = new Post();
            $post
                ->setTitle($faker->sentence(mt_rand(2, 8)))
                ->setContent($faker->paragraphs(mt_rand(3, 6), true))
                ->setState($faker->randomElement(['STATE_DRAFT', 'STATE_PUBLISHED']))
                ->setThumbnail($thumbnail)
                ->setVideo($video)
                ->setAuthor(
                    $users[mt_rand(0, count($users) - 1)]
                );
            $manager->persist($post);
        }

        $manager->flush();
    }

    /**
     * @return string[]
     */
    public function getDependencies(): array
    {
        return [UserFixtures::class];
    }
}
