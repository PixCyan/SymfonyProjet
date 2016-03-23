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
        $panier = array();
        if($contenuPanier) {
            $i = 0;
            foreach($contenuPanier as $key => $produit) {
                $em = $this->getDoctrine()->getManager();
                $article = $em->getRepository(Article::class)->findOneById($key);
                $panier[$i] = array('article' => $article, 'quantite' => $produit);
                $i++;
            }
        }
        return $this->render('VitrineBundle:panier:panier.html.twig', array('produits' => $panier));
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

    public function supprimerPanierAction(Request $request, $id) {
        //TODO ajouterPanier
        $session = $request->getSession();
        if(!$session->get('panier')) {
            $panier = new Panier();
        } else {
            $panier = $session->get('panier');
        }
        $panier->supprimerArticle($id);
        $session->set('panier', $panier);

        return $this->forward('VitrineBundle:Panier:showPanier');
    }

}
