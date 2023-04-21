<?php

namespace App\Twig;

use App\Repository\CategorieRepository;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class Categories extends AbstractExtension
{
    private $categorie;
    public function __construct(CategorieRepository $categorieRepository)
    {
        $this->categorie=$categorieRepository;
    }

    public function getFunctions()
    {
        return [
          new TwigFunction('category',[$this,'giveCategory'])
        ];
    }

    public function giveCategory(){
        return $this->categorie->findBy(['statut'=>true]);
    }

}