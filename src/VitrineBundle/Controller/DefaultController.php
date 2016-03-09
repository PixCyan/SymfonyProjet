<?php

namespace VitrineBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use VitrineBundle\Entity\Article;
use VitrineBundle\Entity\Categorie;

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
        $em = $this->getDoctrine()->getManager();
        if($article = $em->getRepository(Article::class)->findOneById(0) != null) {
            $this->initBDD();
        }
        $produits = $em->getRepository(Article::class)->findAll();
        return $this->render('VitrineBundle:Default:default:catalogue.html.twig', array('produits' => $produits));
    }


    private function initBDD() {
        $em = $this->getDoctrine()->getManager();

        $cat = new Categorie();
        $cat->setLibelle("Métiers");
        $em->persist($cat);

        $cat2 = new Categorie();
        $cat2->setLibelle("Humeurs");
        $em->persist($cat2);

        $art = new Article();
        $art->setLibelle("Testeur de matelas");
        $art->addCategorie($cat);
        $cat->addArticle($art);
        $art->setPrix(150000);
        $art->setStock(4);
        $em->persist($art);

        $art2 = new Article();
        $art2->setLibelle("Joyeux");
        $art2->addCategorie($cat2);
        $cat2->addArticle($art2);
        $art2->setPrix(120000);
        $art2->setStock(25);
        $em->persist($art2);

        $em->flush();
    }

}
