<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


class AppFixtures extends Fixture
{
    public function __construct(
        private UserPasswordHasherInterface $hasher
    ) {}
    public function load(ObjectManager $manager): void
    {
        $user = new User();

        $user->setEmail('imukendi50@gmail.com')
                ->setNom('Isaac')
                ->setPrenom('Mukendi')
                ->setTelephone('+243 815009031')
                ->setBirth(new \DateTimeImmutable('now'))
                ->setRoles(['ROLE_ADMIN'])
                ->setPassword($this->hasher->hashPassword($user,'adminecho262023'))
        ;
        $manager->persist($user);
        $manager->flush();
    }
}
