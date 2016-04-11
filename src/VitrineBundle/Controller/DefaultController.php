<?php

namespace VitrineBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\NullOutput;
use Symfony\Component\HttpFoundation\Request;
use VitrineBundle\Command\RemplirBDDCommand;
use VitrineBundle\Entity\Article;
use VitrineBundle\Entity\Categorie;
use VitrineBundle\Entity\Client;
use VitrineBundle\Entity\Panier;

class DefaultController extends Controller
{
    public function indexAction(Request $request) {
        $client = $this->getUser();
        return $this->render('VitrineBundle:Default:index.html.twig', array('visiteur' => $client));
    }

    //Fonction pour les mentions légales
    public function mentionsAction() {
        return $this->render('VitrineBundle:Default:mentions.html.twig');
    }

    //Fonction de test
    public function helloAction($visiteur) {
        //TODO supprimer helloAction
        return $this->render('default/hello.html.twig', array('visiteur' => $visiteur));
    }

    //Fonction de catalogue
    public function catalogueAction(Request $request) {
        $client = $this->getUser();
        $em = $this->getDoctrine()->getManager();
        if($article = $em->getRepository(Article::class)->findOneById(1) == null) {
            //$this->initBDD();
            //TODO traitement des données
            $command = new RemplirBDDCommand();
            $command->setContainer($this->container);
            $input = new ArrayInput(array('some-param' => 10, '--some-option' => true));
            $output = new NullOutput();
            $resultCode = $command->run($input, $output);
        }
        $produits = $em->getRepository(Article::class)->findAll();
        $session = $request->getSession();
        $panier = $session->get('panier');
        if($panier) {
            $contenuPanier = $panier->getContenu();
            $panier = [];
            if($contenuPanier) {
                $i = 0;
                foreach($contenuPanier as $key => $produit) {
                    $em = $this->getDoctrine()->getManager();
                    $article = $em->getRepository(Article::class)->findOneById($key);
                    $panier[$i] = array('article' => $article, 'quantite' => $produit);
                    $i++;
                }
            }
        }
        return $this->render('VitrineBundle:Default:catalogue.html.twig', array(
            'produits' => $produits,
            'client' => $client,
            'panier' => $panier));
    }

    public function articleByCatAction($idCategorie) {
        $client = $this->getUser();
        $em = $this->getDoctrine()->getManager();
        $cat = $em->getRepository(Categorie::class)->findOneById($idCategorie);
        $produits = $cat->getArticles();
        return $this->render('VitrineBundle:article:articleParCategorie.html.twig', array('produits' => $produits, 'categorie' =>$cat,
            'client' => $client));
    }

    public function showPaniertAction() {
        $client = $this->getUser();
        $em = $this->getDoctrine()->getManager();
        $cat = $em->getRepository(Panier::class)->findOneById();
        $produits = $cat->getArticles();
        return $this->render('VitrineBundle:article:articleParCategorie.html.twig', array('produits' => $produits, 'categorie' =>$cat,
            'client' => $client));
    }


    //function pour les tests
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

        $client = new Client();
        $client->setNom("Lemoine");
        $client->setPrenom("Paul");
        $client->setMail("paul@gmail.com");

        $em->flush();
    }

}
