<?php

namespace App\Controller;

use App\Repository\ContactRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    #[Route('/listeContact/{page?1}/{nbre?10}', name: 'app_contact')]
    public function index( ContactRepository $contactRepository, $page, $nbre): Response
    {
        return $this->render('contact/index.html.twig', [
            'contact' => $contactRepository->findBy([],[],$nbre,($page-1)*$nbre),
            'isPaginated'=>true,
            'nbrePage'=>ceil($contactRepository->count([])/$nbre),
            'page'=>$page,
            'nbre'=>$nbre
        ]);
    }
}
