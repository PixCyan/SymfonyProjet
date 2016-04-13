<?php

namespace VitrineBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;

class Panier
{

    private $contenu;


    public function __construct() {
        $this->contenu = [];
    }

    /**
     * Ajoute/lie une categorie à l'article
     */
    public function ajouterArticle($article, $quantite = 1) {
        if(empty($this->contenu[$article])) {
            $this->contenu[$article] = $quantite;
        } else {
            $c = $this->getContenu();
            $this->contenu[$article] += 1;
        }
    }

    /**
     * Supprime une categorie de l'article
     */
    public function supprimerArticle($article) {
       //TODO supprimer
        if($this->contenu[$article] > 1) {
            $c = $this->getContenu();
            $this->contenu[$article] -= 1;
        } else {
            unset($this->contenu[$article]);
        }
    }

    /*public function viderPanier() {
        $this->contenu = [];
    }*/

    /**
     * @return array
     */
    public function getContenu()
    {
        return $this->contenu;
    }

}
