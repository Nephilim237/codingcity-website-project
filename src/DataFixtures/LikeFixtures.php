<?php

namespace App\DataFixtures;

use App\Repository\Post\PostRepository;
use App\Repository\UserRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class LikeFixtures extends Fixture implements DependentFixtureInterface
{

    public function __construct(private readonly PostRepository $postRepository, private readonly UserRepository $userRepository)
    {
    }

    /**
     * @return string[]
     */
    public function getDependencies(): array
    {
        return [
            PostFixtures::class,
            UserFixtures::class
        ];
    }

    /**
     * @param ObjectManager $manager
     * @return void
     */
    public function load(ObjectManager $manager): void
    {
        $users = $this->userRepository->findAll();
        $posts = $this->postRepository->findAll();

        foreach ($posts as $post) {
            for ($l = 0; $l < mt_rand(0, 50); $l++) {
                $post->addUserLike(
                    $users[mt_rand(0, count($users) - 1)]
                );
            }

        }

        $manager->flush();
    }
}