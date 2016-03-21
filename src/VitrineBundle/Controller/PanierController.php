<?php

namespace VitrineBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use VitrineBundle\Entity\Article;
use VitrineBundle\Entity\Panier;

class PanierController extends Controller {

    public function showPanierAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $session = $request->getSession();
        $panier = $session->get('panier');
        $contenuPanier = $panier->getContenu();

        return $this->render('VitrineBundle:panier:panier.html.twig', array('produits' => $contenuPanier));
    }

    public function ajouterPanierAction(Request $request, $id, $quantite = 1) {
        //TODO ajouterPanier
        $session = $request->getSession();
        if(!$session->get('panier')) {
            $panier = new Panier();
        } else {
            $panier = $session->get('panier');
        }
        $panier->ajouterArticle($id);
        $session->set('panier', $panier);
        return $this->forward('VitrineBundle:Panier:showPanier');
    }

    public function supprimerPanierAction(Request $request, $article) {
        //TODO ajouterPanier
        return $this->forward('VitrineBundle:Panier:ajouterPanier');
    }

}
