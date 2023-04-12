<?php

namespace App\DataFixtures;

use App\Entity\Avatar;
use App\Entity\User;
use App\Entity\UserBio;
use App\Entity\UserInfo;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{

    public function __construct(private readonly UserPasswordHasherInterface $hasher)
    {
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        $user = new User();
        $avatar = new Avatar();

        $userInfo = new UserInfo();
        $userInfo
            ->setUsername('CodingCity237')
            ->setFirstname('City')
            ->setLastname('Coding')
            ->setCountry('Cameroon')
            ->setCity('Kribi')
            ->setJobTitle('Operateur - Analyste')
        ;
        $manager->persist($userInfo);

        $userBio = $this->populateUserbio();
        $manager->persist($userBio);

        $user
            ->setEmail('codingcity237@gmail.com')
            ->setRoles(['ROLE_ADMIN'])
            ->setPassword(
                $this->hasher->hashPassword($user, '1234567890')
            )
            ->setAvatar($avatar)
            ->setUserInfo($userInfo)
            ->setUserBio($userBio)
            ->setOwner(true)
        ;
        $manager->persist($user);

        for ($u = 0; $u < 10; $u++) {
            $user = new User();
            $avatar = new Avatar();

            $userInfo = $this->populateUserInfo();
            $manager->persist($userInfo);

            $userBio = $this->populateUserbio();
            $manager->persist($userBio);

            $user
                ->setEmail($faker->email())
                ->setPassword(
                    $this->hasher->hashPassword($user, '1234567890')
                )
                ->setAvatar($avatar)
                ->setUserBio($userBio)
                ->setUserInfo($userInfo)
            ;
            $manager->persist($user);
        }
        $manager->flush();
    }

    private function populateUserInfo(): UserInfo
    {
        $faker = Factory::create('fr_FR');
        $userInfo = new UserInfo();
        $userInfo
            ->setUsername($faker->userName())
            ->setFirstname($faker->firstName())
            ->setLastname($faker->lastName())
            ->setCountry($faker->country())
            ->setCity($faker->city())
            ->setJobTitle($faker->jobTitle())
        ;
        return $userInfo;
    }

    private function populateUserbio(): UserBio
    {
        $faker = Factory::create('fr_FR');
        $userBio = new UserBio();
        $userBio->setBio($faker->paragraphs(1, true));
        return $userBio;
    }
}
