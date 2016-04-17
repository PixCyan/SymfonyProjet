<?php

namespace VitrineBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Categorie
 *
 * @ORM\Table(name="categorie")
 * @ORM\Entity(repositoryClass="VitrineBundle\Repository\CategorieRepository")
 */
class Categorie
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="libelle", type="string", length=255, unique=true)
     */
    private $libelle;


    /**
     * @var string
     *
     * @ORM\Column(name="ordre", type="string", length=255)
     */
    private $ordre;


    /**
     * @ORM\ManyToMany(targetEntity="VitrineBundle\Entity\Article", mappedBy="categories", cascade={"persist"})
     */
    private $articles;

    public function __construct() {
        $this->articles = new ArrayCollection();
    }
    /**
     * Ajoute/lie un article à la categorie
     */
    public function addArticle(Article $article) {
        $this->articles[] = $article;
    }
    /**
     * Supprime un article de la categorie
     */
    public function removeArticle(Article $article) {
        $this->articles->removeElement($article);
    }


    //----------------- Getters & Setters ------------------------

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set libelle
     *
     * @param string $libelle
     * @return Categorie
     */
    public function setLibelle($libelle)
    {
        $this->libelle = $libelle;

        return $this;
    }

    /**
     * Get libelle
     *
     * @return string 
     */
    public function getLibelle()
    {
        return $this->libelle;
    }

    /**
     * @return mixed
     */
    public function getArticles()
    {
        return $this->articles;
    }

    /**
     * @return string
     */
    public function getOrdre()
    {
        return $this->ordre;
    }

    /**
     * @param string $ordre
     */
    public function setOrdre($ordre)
    {
        $this->ordre = $ordre;
    }

    function __toString()
    {
        return $this->getLibelle();
    }


}
