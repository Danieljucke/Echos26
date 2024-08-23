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

        $user->setEmail('admin@info.com')
                ->setNom('Admin')
                ->setPrenom('user')
                ->setTelephone('+243 80000000000')
                ->setBirth(new \DateTimeImmutable('now'))
                ->setRoles(['ROLE_ADMIN'])
                ->setPassword($this->hasher->hashPassword($user,'adminecho262023'))
        ;
        $manager->persist($user);
        $manager->flush();
    }
}
