<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i <= 3; $i++) {
            $user = new User();

            $user->setUserName('user' . $i);
            $user->setIsVerified(true);
            $user->setEmail("bibi" . $i . "@hotmail.fr");
            $user->setRoles(['ROLE_USER']);
            $user->setPassword($this->passwordEncoder->encodePassword($user, 'bibi'));
            $manager->persist($user);
            $manager->flush();
            $this->addReference($user->getUsername(), $user);
        }
    }
}
