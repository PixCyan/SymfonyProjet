<?php

namespace VitrineBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;

class Panier
{

    private $contenu;


    public function __construct() {
        $this->contenu = new ArrayCollection();
    }

    /**
     * Ajoute/lie une categorie à l'article
     */
    public function addContenu($ligneCommande) {
        $this->contenu[] = $ligneCommande;
    }

    /**
     * Supprime une categorie de l'article
     */
    public function removeContenu($ligneCommande) {
        $this->contenu->removeElement($ligneCommande);
    }

    public function ajouterArticle() {

    }

    public function supprimerArticle() {

    }


}
