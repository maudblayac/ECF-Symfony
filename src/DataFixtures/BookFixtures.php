<?php

namespace App\DataFixtures;

use App\Entity\Book;
use App\Entity\Author;
use App\Entity\User;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;


class BookFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        // $faker = Factory::create();

        // Création de 10 livres avec Faker
        for ($i = 0; $i < 10; $i++) {
            $book = new Book();
            $book
                ->setTitle('dgddgr')
                ->setDescription('dfgdrgdrgd')
                ->setPublishedAt(new DateTimeImmutable()) 
                ->setCreatedAt(new \DateTimeImmutable())
                ->setUpdateAt(new \DateTimeImmutable())
                ->setAuthor($this->getReference('author_' . rand(0, 9))) 
                ->setUser($this->getReference('user_' . rand(0, 9)));  

            $this->addReference('book_' . $i, $book);
            $manager->persist($book);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            AuthorFixtures::class,
            UserFixtures::class,
        ];
    }
}
