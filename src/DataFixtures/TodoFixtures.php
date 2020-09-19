<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Todo;

class TodoFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $todo = new Todo();
        $todo->setTitle('Courses')
            ->setContent('Buy pastas, pizzas and sodas.')
            ->setCreatedAt(new \DateTime());
        $manager->persist($todo);
        
        $todo = new Todo();
        $todo->setTitle('Video games')
            ->setContent('Play Mario Kart and Animal Crossing')
            ->setCreatedAt(new \DateTime());
        $manager->persist($todo);
        
        $todo = new Todo();
        $todo->setTitle('Homeworks')
            ->setContent('Finish my homeworks.')
            ->setCreatedAt(new \DateTime())
            ->setDeadline(new \DateTime('2020-09-21'));
        $manager->persist($todo);

        $manager->flush();
    }
}
