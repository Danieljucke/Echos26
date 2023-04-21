<?php

namespace App\DataFixtures;

use App\Entity\Categorie;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategorieFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        $data_cat=[
            'Politique',
            'Economie',
            'Education',
            'Santé',
            'Culture',
            'Société',
            'Sécurité',
            'Environnement',
            'Entreprenariat'
        ];
        for($i=0;$i<count($data_cat);$i++){
            $categorie = new Categorie();
            $categorie->setLibelle($data_cat[$i])
                        ->setCreatedAt(new \DateTimeImmutable('now'))
                        ->setModifiedAt(new \DateTimeImmutable('now'))
                        ->setStatut(true);
            $manager->persist($categorie);
        }
        $manager->flush();
    }
}