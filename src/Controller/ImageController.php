<?php

namespace App\Controller;

use App\Entity\Image;
use App\Form\ImageType;
use App\Repository\ImageRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/dashboard/image'), IsGranted('IS_AUTHENTICATED_FULLY')]
class ImageController extends AbstractController
{
    #[Route('/liste/{page?1}/{nbre?10}', name: 'app_image_index', methods: ['GET'])]
    public function index(ImageRepository $imageRepository, $page,$nbre): Response
    {
        return $this->render('image/index.html.twig', [
            'images' => $imageRepository->findBy([],[],$nbre,($page-1)*$nbre),
            'isPaginated'=>true,
            'nbrePage'=>ceil($imageRepository->count([])/$nbre),
            'page'=>$page,
            'nbre'=>$nbre
        ]);
    }

    #[Route('/new', name: 'app_image_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ImageRepository $imageRepository, SluggerInterface $slugger): Response
    {
        $image = new Image();
        $form = $this->createForm(ImageType::class, $image)->remove('chemin');
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $File = $form->get('Uploadfile')->getData();

            if ($File) {
                $originalFilename = pathinfo($File->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $File->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $File->move(
                        $this->getParameter('image_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }
                $image->setChemin($newFilename);
                $imageRepository->save($image, true);

                return $this->redirectToRoute('app_image_index', [], Response::HTTP_SEE_OTHER);
            }
        }

        return $this->renderForm('image/new.html.twig', [
            'image' => $image,
            'formImage' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_image_show', methods: ['GET'])]
    public function show(Image $image): Response
    {
        return $this->render('image/show.html.twig', [
            'image' => $image,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_image_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Image $image, ImageRepository $imageRepository): Response
    {
        $form = $this->createForm(ImageType::class, $image);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $imageRepository->save($image, true);

            return $this->redirectToRoute('app_image_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('image/edit.html.twig', [
            'image' => $image,
            'form' => $form,
        ]);
    }

//    #[Route('/{id}', name: 'app_image_delete', methods: ['POST'])]
//    public function delete(Request $request, Image $image, ImageRepository $imageRepository): Response
//    {
//        if ($this->isCsrfTokenValid('delete'.$image->getId(), $request->request->get('_token'))) {
//            $imageRepository->remove($image, true);
//        }
//
//        return $this->redirectToRoute('app_image_index', [], Response::HTTP_SEE_OTHER);
//    }
}
