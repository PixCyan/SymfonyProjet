<?php

namespace VitrineBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use VitrineBundle\Entity\Article;
use VitrineBundle\Entity\Commande;

class DefaultController extends Controller {

    public function showPaniertAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $session = $request->getSession();
        $panier = $session->get('panier');
        $contenuPanier = $panier->getConetnu();
        $produit = array();
        $i = 0;
        foreach($contenuPanier as $key => $value) {
            $article = $em->getRepository(Article::class)->findOneById($key);
            if(!$article) {
                $produit[$i] = $article;
            }
            $i++;
        }


        return $this->render('VitrineBundle:panier:panier.html.twig', array());
    }

    public function ajouterPaniertAction(Request $request, $article, $quantite) {
        //TODO ajouterPanier
        return $this->render('VitrineBundle:panier:panier.html.twig', array());
    }

    public function supprimerPaniertAction(Request $request, $article) {
        //TODO ajouterPanier
        return $this->render('VitrineBundle:panier:panier.html.twig', array());
    }

}
