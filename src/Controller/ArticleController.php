<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
#[Route('/dashboard/article'), IsGranted('IS_AUTHENTICATED_FULLY')]
class ArticleController extends AbstractController
{
    #[Route('/index/{page?1}/{nbre?5}', name: 'app_article')]
    public function index(ArticleRepository $article,$page,$nbre): Response
    {
        return $this->render('article/index.html.twig',[
            'articles'=> $article->findBy([],[],$nbre,($page-1)*$nbre),
            'isPaginated'=>true,
            'nbrePage'=>ceil($article->count([])/$nbre),
            'page'=>$page,
            'nbre'=>$nbre
        ]);
    }

    #[Route('/new', name: 'app_article_addarticle', methods: ['GET', 'POST'])]
    public function addArticle(Article $article=null, ArticleRepository $articleRepository,Request $request): Response
    {
        $article = new Article();
        $form=$this->createForm(ArticleType::class,$article);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $article->setDateAffihcer(
                new  \DateTimeImmutable(
                    $form->get('dateAffihcer')
                        ->getViewData()
                ))->setCorps(strip_tags($request->request->get('corps')));

            $articleRepository->save($article,true);
            return  $this->redirectToRoute('app_article',[],Response::HTTP_SEE_OTHER);
        }
        return $this->render('article/new.html.twig',[
            'formArticle'=>$form->createView()
        ]);
    }

    #[Route('/show/{id}', name: 'app_article_show',methods: ['GET'])]
    public function show(Article $article):Response{
        return $this->render('article/show.html.twig',[
            'articles'=>$article
        ]);
    }
    #[Route('/edit/{id}', name: 'app_article_editer',   methods: ['GET', 'POST'])]
    public function editer(ArticleRepository $articleRepository, Request $request, Article $article):Response{
        $form=$this->createForm(ArticleType::class,$article);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $article->setDateAffihcer(
                new  \DateTimeImmutable(
                    $form->get('dateAffihcer')
                        ->getViewData()
                ))
                ->setCorps(strip_tags($form->get('corps')->getViewData()));
            $articleRepository->save($article, true);
            $this->redirectToRoute('app_article');
        }
        return $this->render('article/edit.html.twig',[
            'form'=>$form->createView(),
        ]);
    }
}
