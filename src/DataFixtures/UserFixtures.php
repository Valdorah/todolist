<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

use App\Entity\User;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    public const USER_REFERENCE = 'user-fixtures';

    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        $user1 = new User();

        $user1->setUsername('Valdorah');
        $user1->setPassword($this->passwordEncoder->encodePassword(
            $user1,
            'test1234'
        ));

        $manager->persist($user1);
        
        $user2 = new User();

        $user2->setUsername('Toto');
        $user2->setPassword($this->passwordEncoder->encodePassword(
            $user2,
            'test1234'
        ));

        $manager->persist($user2);
        
        $manager->flush();

        $this->addReference(self::USER_REFERENCE, $user1);
    }
}
