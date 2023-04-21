<?php

namespace App\Twig;

use App\Entity\User;
use App\Repository\UserRepository;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class Utilisateur extends AbstractExtension
{
    private  $use1r;
    public function __construct(UserRepository $userRepository)
    {
        $this->user1=$userRepository;
    }

    public function getFunctions()
    {
        return [
            new TwigFunction('utilisateur',[$this,'giveUser'])
        ];
    }

    public function giveUser(){
        return $this->user1->findAll();
    }

}