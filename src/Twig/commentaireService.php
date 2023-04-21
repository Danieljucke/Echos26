<?php

namespace App\Twig;

use App\Repository\CommentaireRepository;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class commentaireService extends AbstractExtension
{
    private $commentaire;
    public function __construct( CommentaireRepository $commentaire)
    {
        return $this->commentaire=$commentaire;
    }

    public function getFunctions():array
    {
        return [
            new TwigFunction('afficher_commentaire','giveAllCommentaire')
        ];
    }

    public function giveAllCommentaire(){
        return $this->commentaire->findAll();
    }
}