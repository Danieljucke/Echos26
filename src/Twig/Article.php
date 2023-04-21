<?php

namespace App\Twig;

use App\Repository\ArticleRepository;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class Article extends AbstractExtension
{
    private $article;
    public function __construct( ArticleRepository $articleRepository )
    {
        $this->article=$articleRepository;
    }
    public function getFunctions():array
    {
        return[
            new TwigFunction('articleService',[$this,'giveArticle'])
        ];
    }

    public function giveArticle(){
        return $this
            ->article
            ->findAll();
    }
}