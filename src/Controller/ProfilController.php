<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/dashboard/profil'), IsGranted('IS_AUTHENTICATED_FULLY')]
class ProfilController extends AbstractController
{
    #[Route('/show/{id}', name: 'app_profil', methods: ['GET'])]
    public function index(User $user): Response
    {
        return $this->render('profil/index.html.twig', [
            'profil' => $user,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_profil_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request,
                         User $user,
                         UserRepository $userRepository,
                         UserPasswordHasherInterface $userPasswordHasher): Response
    {
        $form = $this->createForm(UserType::class, $user)->remove('roles');
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $user->setPassword($userPasswordHasher->hashPassword($user, $form->get('password')->getViewData()));
            $userRepository->save($user,true);

            $this->addFlash('success', 'Profil modifié avec succès.');
            return $this->redirectToRoute('app_admistrator');
        }

        return $this->render('profil/edit.html.twig', [
            'utilisateur' => $user,
            'userForm' => $form->createView(),
        ]);
    }

}
