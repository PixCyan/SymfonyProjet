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
        $em = $this->getDoctrine()->getManager();
        if($article = $em->getRepository(Article::class)->findAll() == null) {
            //$this->initBDD();
            $command = new RemplirBDDCommand();
            $command->setContainer($this->container);
            $input = new ArrayInput(array());
            $output = new NullOutput();
            $resultCode = $command->run($input, $output);
        }
        $articles = $em->getRepository(Article::class)->articleLesPlusVendus();

        return $this->render('VitrineBundle:Default:index.html.twig', array('visiteur' => $client, 'articles' => $articles));
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
            $command = new RemplirBDDCommand();
            $command->setContainer($this->container);
            $input = new ArrayInput(array('some-param' => 10, '--some-option' => true));
            $output = new NullOutput();
            $resultCode = $command->run($input, $output);
        }
        $produits = $em->getRepository(Article::class)->findAll();
        $session = $request->getSession();
        $panier = $this->traitementPanier($session->get('panier'));

        return $this->render('VitrineBundle:Default:catalogue.html.twig', array(
            'produits' => $produits,
            'visiteur' => $client,
            'panier' => $panier));
    }

    public function articleByCatAction(Request $request, $idCategorie) {
        $client = $this->getUser();
        $em = $this->getDoctrine()->getManager();
        $cat = $em->getRepository(Categorie::class)->findOneById($idCategorie);
        $produits = $cat->getArticles();
        $session = $request->getSession();
        $panier = $this->traitementPanier($session->get('panier'));
        return $this->render('VitrineBundle:article:articleParCategorie.html.twig', array('produits' => $produits, 'categorie' =>$cat,
            'visiteur' => $client,
            'panier' => $panier));
    }

    public function maSelectionAction(Request $request) {
        $client = $this->getUser();
        if($client) {
            $selection = $client->getListeSouhaits();
        } else {
            throw $this->createNotFoundException('Vous n\'êtes pas connecté !');
        }
        $session = $request->getSession();
        $panier = $this->traitementPanier($session->get('panier'));
        return $this->render('VitrineBundle:user:selectionClient.html.twig', array(
            'selection' => $selection,
            'visiteur' => $client,
            'panier' => $panier));
    }

    public function ajouterListeSouhaitsAction(Request $request, $id) {
        $client = $this->getUser();
        if(!$client) {
            throw $this->createNotFoundException('Vous n\'êtes pas connecté !');
        }
        $em = $this->getDoctrine()->getManager();
        $article = $em->getRepository(Article::class)->findOneById($id);
        $liste = $client->getListeSouhaits();
        if(!$liste->getArticles()->contains($article)) {
            $liste->addArticle($article);
            $article->addListeSouhait($liste);
            $em->merge($liste);
            $em->merge($article);
            $em->flush();
        }
        return $this->redirectToRoute('maSelection');
    }

    public function retirerListeSouhaitsAction(Request $request, $id) {
        $client = $this->getUser();
        if(!$client) {
            throw $this->createNotFoundException('Vous n\'êtes pas connecté !');
        }
        $em = $this->getDoctrine()->getManager();
        $article = $em->getRepository(Article::class)->findOneById($id);
        $liste = $client->getListeSouhaits();
        if($liste->getArticles()->contains($article)) {
            $liste->removeArticle($article);
            $article->removeListeSouhait($liste);
            $em->merge($liste);
            $em->merge($article);
            $em->flush();
        }
        return $this->redirectToRoute('maSelection');
    }


    private function traitementPanier($panier) {
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
        return $panier;
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
