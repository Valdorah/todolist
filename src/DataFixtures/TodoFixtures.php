<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Todo;

use App\DataFixtures\UserFixtures;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class TodoFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $user = $this->getReference(UserFixtures::USER_REFERENCE);

        $todo = new Todo();
        $todo->setTitle('Courses')
            ->setContent('Buy pastas, pizzas and sodas.')
            ->setCreatedAt(new \DateTime())
            ->setAuthor($user);
        $manager->persist($todo);
        
        $todo = new Todo();
        $todo->setTitle('Video games')
            ->setContent('Play Mario Kart and Animal Crossing')
            ->setCreatedAt(new \DateTime())
            ->setAuthor($user);
        $manager->persist($todo);
        
        $todo = new Todo();
        $todo->setTitle('Homeworks')
            ->setContent('Finish my homeworks.')
            ->setCreatedAt(new \DateTime())
            ->setDeadline(new \DateTime('2020-09-21'))
            ->setAuthor($user);
        $manager->persist($todo);

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            UserFixtures::class,
        ];
    }
}
