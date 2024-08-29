<?php

namespace App\DataFixtures;

use App\Entity\Author;
use App\Entity\User; 
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AuthorFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        // Création de l'auteur classique
        $author = new Author();
        $author
            ->setName('Paul')
            ->setFirstName('Homer')
            ->setDateBirth(new \DateTime())
            ->setCreatedAt(new \DateTimeImmutable('2020-10-20'))
            ->setUpdateAt(new \DateTimeImmutable('2021-11-05'))
            ->setUser($this->getReference('user_0')); 
        $manager->persist($author);

        // Création de 10 auteurs avec Faker
        for ($i = 0; $i < 10; $i++) {
            $additionalAuthor = new Author();
            $additionalAuthor
                ->setName($faker->lastName)
                ->setFirstName($faker->firstName)
                ->setDateBirth($faker->dateTimeBetween('-70 years', '-18 years'))
                ->setCreatedAt(new \DateTimeImmutable())
                ->setUpdateAt(new \DateTimeImmutable())
                ->setUser($this->getReference('user_' . rand(0, 9)));
            $this->addReference('author_' . $i, $additionalAuthor);
            $manager->persist($additionalAuthor);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
        ];
    }
}
