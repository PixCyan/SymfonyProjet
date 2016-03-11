<?php

namespace VitrineBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use VitrineBundle\Entity\Commande;

class DefaultController extends Controller {

    public function showPaniertAction($id) {
        $em = $this->getDoctrine()->getManager();
        $commande = $em->getRepository(Commande::class)->findOneById($id);
        $articlesPanier = $commande->getLignesDeCommande();
        return $this->render('VitrineBundle:panier:panier.html.twig', array('panier' => $articlesPanier));
    }

}
