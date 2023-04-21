<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Commentaire;
use App\Entity\Contact;
use App\Form\CommentaireType;
use App\Form\ContacterType;
use App\Repository\ArticleRepository;
use App\Repository\CategorieRepository;
use App\Repository\CommentaireRepository;
use App\Repository\ContactRepository;
use App\Service\Init;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mime\Email;

class MagasinController extends AbstractController
{
    #[Route('/', name: 'app_magasin')]
    public function index(ArticleRepository $repository): Response
    {
        return $this->render('magasin/index.html.twig',[
            "showArticle"=>$repository->findBy(['Section'=>'entete', 'statut'=>true])
        ]);
    }

    #[Route('/article/{id}', name: 'app_magasin_showsinglearticle', methods: ['GET','POST'])]
    public function showSingleArticle(
        Article $article,
        CommentaireRepository $commentaireRepository,
        Request $request
    ): Response {

        $commentaire = new Commentaire();
        $form = $this->createForm(CommentaireType::class, $commentaire, [
            'action' => $this
                ->generateUrl('app_magasin_showsinglearticle', [
                    'id' => $article->getId()
                ]),
            'method' => 'POST'
        ])
            ->remove('HeurePost')
            ->remove('article')
            ->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $commentaire
                ->setHeurePost(new \DateTimeImmutable('now'))
                ->setArticle($article);
            $commentaireRepository->save($commentaire,true);

            return $this->redirectToRoute('app_magasin_showsinglearticle', ['id' => $article->getId()]);
        }

        return $this->render('magasin/singlearticle.html.twig', [
            'article' => $article,
            'nbrcomment' => $commentaireRepository->count(['article' => $article]),
            'commentaire' => $commentaireRepository->findBy(['article' => $article]),
            'form' => $form->createView(),
        ]);
    }


    #[Route('/showByCat/{id}', name: 'app_magasin_showarticlebycat', methods: ['GET'])]
    public function showArticleByCat(ArticleRepository $articleRepository, int $id, CategorieRepository $categorieRepository): Response
    {
        $categorie = $categorieRepository->find($id);
        return $this->render('magasin/byCat.html.twig', [
            'articles' => $articleRepository->findBy(['categorie' => $categorie]),
            'categorie' => $categorie ? $categorie->getLibelle() : null,
        ]);
    }



    /**
     * @throws TransportExceptionInterface
     */
    #[Route('/contacter', name: 'app_magasin_contacter',methods: ['GET','POST'])]
    public function contacter(MailerInterface $mailer, ContactRepository $repository, Request $request):Response
    {
        $contact =new Contact();
        $form=$this->createForm(ContacterType::class,$contact);
        $form->handleRequest($request);
        $mail = $form->get('email')->getData();
        $sujet = $form->get('sujet')->getData();
        $message = $form->get('message')->getData();
        if ($form->isSubmitted() && $form->isValid())
        {
            $repository->save($contact, true);
            $email = (new Email())
                ->from($mail)
                ->to('tjwrite24@gmail.com')
                ->subject($sujet)
                ->text($message);
            $mailer->send($email);
            return $this->redirectToRoute('app_magasin', [], Response::HTTP_SEE_OTHER);
        }

       return $this->render('magasin/Contact.html.twig',[
           'formCon'=>$form->createView()
       ]);
    }
}
