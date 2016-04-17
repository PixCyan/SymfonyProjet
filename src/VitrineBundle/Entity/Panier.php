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
        $etat = "ok";
        if(empty($this->contenu[$article->getId()])) {
            if($quantite <= $article->getStock()) {
                $this->contenu[$article->getId()] = $quantite;
            } else {
                $etat = "La quantité demandée est supérieur au stock de cet article.";
            }
        } else {
            if($this->contenu[$article->getId()] + $quantite <=  $article->getStock()) {
                $this->contenu[$article->getId()] += 1;
            } else {
                $etat = "La quantité demandée est supérieur au stock de cet article.";
            }
        }
        return $etat;
    }

    /**
     * Supprime une categorie de l'article
     */
    public function supprimerArticle($article) {
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
