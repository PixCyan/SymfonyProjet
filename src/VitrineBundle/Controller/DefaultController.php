<?php

namespace VitrineBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($visiteur) {
        return $this->render('VitrineBundle:Default:index.html.twig', array('visiteur' => $visiteur));
    }

    //Fonction pour les mentions légales
    public function mentionsAction() {
        return $this->render('VitrineBundle:Default:mentions.html.twig');
    }

    //Fonction de test
    public function helloAction($visiteur) {
        return $this->render('default/hello.html.twig', array('visiteur' => $visiteur));
    }

    //Fonction de catalogue
    public function catalogueAction() {
        //TODO catalogueAction

        return $this->render('default/catalogue.html.twig', array('visiteur' => "test"));
    }

}
