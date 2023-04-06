<?php

namespace App\DataFixtures;

use App\Entity\Post\Post;
use App\Entity\Post\Thumbnail;
use App\Entity\Post\Video;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class PostFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        for ($p = 0; $p <= 100; $p++) {
            $post = new Post();
            $thumbnail = new Thumbnail();
            $video = new Video();
            $video->setLink('https://www.youtube.com/embed/Sjd3_e2la7Q');
            $thumbnail->setImageName($faker->image('public/uploads/images/posts/banner', 750, 350, 'animals', false, true));
            $manager->persist($thumbnail);

            $post
                ->setTitle($faker->sentence(mt_rand(2, 8)))
                ->setContent($faker->paragraphs(mt_rand(3, 6), true))
                ->setState($faker->randomElement(['STATE_DRAFT', 'STATE_PUBLISHED']))
                ->setThumbnail($thumbnail)
                ->setVideo($video)
            ;
            $manager->persist($post);
        }

        $manager->flush();
    }
}
