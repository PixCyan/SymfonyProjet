<?php

namespace VitrineBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use VitrineBundle\Entity\Article;
use VitrineBundle\Entity\Client;
use VitrineBundle\Entity\Commande;
use VitrineBundle\Entity\LigneDeCommande;
use VitrineBundle\Form\CommandeType;

/**
 * Commande controller.
 *
 */
class CommandeController extends Controller
{
    /**
     * Lists all Commande entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $commandes = $em->getRepository('VitrineBundle:Commande')->findAll();

        return $this->render('commande/index.html.twig', array(
            'commandes' => $commandes,
        ));
    }

    /**
     * Creates a new Commande entity.
     *
     */
    public function newAction(Request $request)
    {
        $commande = new Commande();
        $form = $this->createForm('VitrineBundle\Form\CommandeType', $commande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($commande);
            $em->flush();

            return $this->redirectToRoute('commande_show', array('id' => $commande->getId()));
        }

        return $this->render('commande/new.html.twig', array(
            'commande' => $commande,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Commande entity.
     *
     */
    public function showAction(Commande $commande)
    {
        $deleteForm = $this->createDeleteForm($commande);

        return $this->render('commande/show.html.twig', array(
            'commande' => $commande,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Commande entity.
     *
     */
    public function editAction(Request $request, Commande $commande)
    {
        $deleteForm = $this->createDeleteForm($commande);
        $editForm = $this->createForm('VitrineBundle\Form\CommandeType', $commande);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($commande);
            $em->flush();

            return $this->redirectToRoute('commande_edit', array('id' => $commande->getId()));
        }

        return $this->render('commande/edit.html.twig', array(
            'commande' => $commande,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Commande entity.
     *
     */
    public function deleteAction(Request $request, Commande $commande)
    {
        $form = $this->createDeleteForm($commande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($commande);
            $em->flush();
        }

        return $this->redirectToRoute('commande_index');
    }

    /**
     * Creates a form to delete a Commande entity.
     *
     * @param Commande $commande The Commande entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Commande $commande) {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('commande_delete', array('id' => $commande->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    public function passerCommandeAction(Request $request) {
        //TODO passerCommande découper en deux méthodes
        $em = $this->getDoctrine()->getManager();
        $session = $request->getSession();
        //TODO getUser() client passer commande
        $client = $em->getRepository(Client::class)->findOneById($this->getUser());
        $panier = $session->get('panier');
        if($panier) {
            $contenuPanier = $panier->getContenu();
            if($contenuPanier) {
                $commande = new Commande();
                $i = 0;
                foreach($contenuPanier as $key => $quantite) {
                    $article = $em->getRepository(Article::class)->findOneById($key);
                    $article->setNbVentes($article->getNbventes()+$quantite);
                    $ligneCommande = new LigneDeCommande();
                    $ligneCommande->setArticle($article);
                    $ligneCommande->setQuantite($quantite);
                    $ligneCommande->setCommande($commande);
                    $commande->addLigneDeCommande($ligneCommande);
                    $commande->setClient($client);
                    $commande->setEtat(false);
                    $client->addCommande($commande);

                    $em->persist($commande);
                    $em->persist($ligneCommande);
                    $em->merge($client);

                    $i++;
                }
                $em->flush();
            }
        }
        return $this->redirectToRoute('commandes');
    }

    public function showCommandesAction() {
        $client = $this->getUser();
        return $this->render('VitrineBundle:user:commandesClient.html.twig', array('client' => $client));
    }
}
