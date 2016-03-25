<?php

namespace VitrineBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContext;
use VitrineBundle\Entity\Article;
use VitrineBundle\Entity\Categorie;
use VitrineBundle\Entity\Client;

class SecurityController extends Controller
{
    public function indexAction($visiteur, Request $request)
    {
        $this->getUser();
        return $this->render('VitrineBundle:Default:index.html.twig', array('visiteur' => $visiteur));
    }

    public function loginAction() {
        $request = $this->getRequest();
        $session = $request->getSession();
        // récupérer les erreurs de login s'il y en a
        if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
            $error = $request->attributes->get(SecurityContext::AUTHENTICATION_ERROR);
        } else {
            $error = $session->get(SecurityContext::AUTHENTICATION_ERROR);
            $session->remove(SecurityContext::AUTHENTICATION_ERROR);
        }
        return $this->render('VitrineBundle:Security:login.html.twig', array(
            // dernier login entré par l'utilisateur
            'last_username' => $session->get(SecurityContext::LAST_USERNAME),
            'error'
            => $error,
        ));
}

}