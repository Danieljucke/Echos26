<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Entity\User;
use App\Repository\ArticleRepository;
use App\Repository\CommentaireRepository;
use App\Repository\ContactRepository;
use App\Repository\ImageRepository;
use App\Repository\UserRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
#[Route('/dashboard'), IsGranted('IS_AUTHENTICATED_FULLY')]
class AdmistratorController extends AbstractController
{
    #[Route('/accueil', name: 'app_admistrator',methods: ['GET'])]
    public function index(UserRepository $userRepository,
                          CommentaireRepository $commentaireRepository,
                          ArticleRepository $articleRepository,ImageRepository $imageRepository): Response
    {
        return $this->render('admistrator/index.html.twig',[
            'userCompte'=>$userRepository->count([]),
            'commentaireCount'=>$commentaireRepository->count([]),
            'articleCount'=>$articleRepository->count([]),
            'commentaire'=>$commentaireRepository->findBy([],['id'=>'DESC']),
            'articles'=>$articleRepository->findBy([],['id'=>'DESC']),
            'image'=>$imageRepository->count([])
        ]);
    }
    #[Route('/liste/{page?1}/{nbre?10}',name: 'app_admistrator_showuseronlist')]
    public function showUserOnList(UserRepository $userRepository, $page,$nbre):Response{
        return $this->render('admistrator/liste.html.twig',[
            'utilisateur'=>$userRepository->findBy([],[],$nbre,($page-1)*$nbre),
            'isPaginated'=>true,
            'nbrePage'=>ceil($userRepository->count([])/$nbre),
            'page'=>$page,
            'nbre'=>$nbre
        ]);
    }
    #[Route('/show/{id}', name: 'app_admistrator_showuser', methods: ['GET'])]
    public function showUser(User $user):Response{
        return $this->render('admistrator/showUser.html.twig',[
            'utilisateur'=>$user
        ]);
    }

}
