<?php

namespace App\DataFixtures;

use App\Entity\Type;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class TypeFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        $data_type=[
            'Urgence',
            'Dernière nouvelle',
            'A la une',
            'Nouvelles tendances'
        ];
        for ($i=0;$i<count($data_type);$i++)
        {
            $type= new Type();
            $type->setLibelle($data_type[$i])
                ->setCreatedAt(new \DateTimeImmutable('now'))
                ->setModifiedAt(new \DateTimeImmutable('now'))
                ->setStatut(true);
            $manager->persist($type);
        }
        $manager->flush();
    }
}
