<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    private UserPasswordHasherInterface $userPasswordHasher;

    public function __construct(UserPasswordHasherInterface $userPasswordHasher) {
        $this->userPasswordHasher = $userPasswordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        // Création de l'utilisateur Classique
        $user = new User();
        $user
            ->setEmail('user@mail.com')
            ->setRoles(['ROLE_USER'])
            ->setPassword($this->userPasswordHasher->hashPassword(
                $user,
                'password'
            ))
            ->setCreatedAt(new \DateTimeImmutable('2020-10-20'))
            ->setUpdateAt(new \DateTimeImmutable('2021-11-05'));
        $manager->persist($user);

        // Création de 10 utilisateurs avec Faker
        for ($i = 0; $i < 9; $i++) {
            $additionalUser = new User();
            $additionalUser
                ->setEmail($faker->email())
                ->setRoles(['ROLE_USER']) 
                ->setPassword($this->userPasswordHasher->hashPassword(
                    $additionalUser,
                    'password'
                ))
                ->setCreatedAt(new \DateTimeImmutable())
                ->setUpdateAt(new \DateTimeImmutable());
            $this->addReference('user_' . $i, $additionalUser);
            $manager->persist($additionalUser);
        }

        $manager->flush();
    }
}