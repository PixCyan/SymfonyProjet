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
        if(empty($this->contenu[$article])) {
            $this->contenu[$article] = $quantite;
        } else {
            $c = $this->getContenu();
            $this->contenu[$article] = $c[$article]+1;
        }
    }

    /**
     * Supprime une categorie de l'article
     */
    public function supprimerArticle($id) {
       //TODO supprimer
        $em = $this->getDoctrine()->getManager();
        $article = $em->getRepository(Article::class)->findOneById($id);
        unset($this->contenu[$article]);
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
