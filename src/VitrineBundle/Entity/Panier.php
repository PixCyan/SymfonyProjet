<?php

namespace VitrineBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;

class Panier
{

    private $contenu;


    public function __construct() {
        $this->contenu = array();
    }

    /**
     * Ajoute/lie une categorie à l'article
     */
    public function ajouterArticle($article, $quantite = 1) {
        if($this->contenu[$article->getId()] != null) {
            $c[$article->getId()] = $quantite;
        }
    }

    /**
     * Supprime une categorie de l'article
     */
    public function supprimerArticle($article) {
       //TODO supprimer
        unset($this->contenu[$article->getId()]);
        //$array = array_values($array);
    }


    public function viderPanier() {
        //TODO viderPanier
        $this->contenu = array();
    }

    /**
     * @return array
     */
    public function getContenu()
    {
        return $this->contenu;
    }

}
