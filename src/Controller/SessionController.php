<?php

namespace App\Controller;

use App\Entity\Session;
use App\Repository\SessionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SessionController extends AbstractController
{
    #[Route('/session', name: 'app_session')]
    public function index(Request $request, SessionRepository $sessionRepository): Response
    {
        // session_start()
        $session = $request->getSession();
        if ($session->has('nbVisite')) {
            $nbreVisite = $session->get('nbVisite') + 1;

        } else {
            $nbreVisite = 1;
        }
        $session->set('nbVisite', $nbreVisite);
        $newsession = new Session();
        $newsession->setNbnVisite($nbreVisite);
        $sessionRepository->save($newsession);
        return $this->render('magasin/index.html.twig');
    }
}
