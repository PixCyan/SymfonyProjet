<?php

namespace VitrineBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Article
 *
 * @ORM\Table(name="article")
 * @ORM\Entity(repositoryClass="VitrineBundle\Repository\ArticleRepository")
 */
class Article
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
     * @var int
     *
     * @ORM\Column(name="prix", type="float")
     */
    private $prix;

    /**
     * @var int
     *
     * @ORM\Column(name="stock", type="integer")
     */
    private $stock;

    /**
     * @var int
     *
     * @ORM\Column(name="nbVentes", type="integer")
     */
    private $nbVentes;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @ORM\ManyToMany(targetEntity="VitrineBundle\Entity\Categorie", inversedBy="articles", cascade={"persist"})
     * @ORM\JoinTable(name="articlesHasCategories")
     */
    private $categories;

    /**
     * @ORM\OneToMany(targetEntity="VitrineBundle\Entity\LigneDeCommande", mappedBy="article")
     */
    private $lignesDeCommande;

    /**
     * @ORM\OneToMany(targetEntity="VitrineBundle\Entity\Image", mappedBy="article", cascade={"persist"})
     */
    private $images;

    /**
     * @ORM\ManyToMany(targetEntity="VitrineBundle\Entity\ListeSouhaits", inversedBy="articles", cascade={"persist"})
     * @ORM\JoinTable(name="listeSouhaitsHasArticles")
     */
    private $listesSouhaits;

    public function __construct()
    {
        $this->categories = new ArrayCollection();
        $this->lignesDeCommande = new ArrayCollection();
        $this->images = new ArrayCollection();
        $this->listesSouhaits = new ArrayCollection();
        $this->nbVentes = 0;
    }

    /**
     * Ajoute/lie une categorie à l'article
     */
    public function addCategorie(Categorie $categorie)
    {
        $this->categories[] = $categorie;
    }

    /**
     * Supprime une categorie de l'article
     */
    public function removeCategorie(Categorie $categorie)
    {
        $this->categories->removeElement($categorie);
    }

    /**
     * Ajoute/lie une ligneDeCommande à l'article
     */
    public function addLigneDeCommande(LigneDeCommande $l)
    {
        $this->lignesDeCommande[] = $l;
    }

    /**
     * Supprime une lignesDeCommande de l'article
     */
    public function removeLigneDeCommande(LigneDeCommande $l)
    {
        $this->lignesDeCommande->removeElement($l);
    }

    /**
     * Ajoute/lie une image à l'article
     */
    public function addImage(Image $image)
    {
        $this->images[] = $image;
    }

    /**
     * Supprime une image de l'article
     */
    public function removeImage(Image $image)
    {
        $this->images->removeElement($image);
    }

    /**
     * Ajoute/lie une liste de souhait à l'article
     */
    public function addListeSouhait(ListeSouhaits $liste)
    {
        $this->listesSouhaits[] = $liste;
    }

    /**
     * Supprime une liste de souhait à l'article
     */
    public function removeListeSouhait(ListeSouhaits $liste)
    {
        $this->listesSouhaits->removeElement($liste);
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
     * @return Article
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
     * Set prix
     *
     * @param integer $prix
     * @return Article
     */
    public function setPrix($prix)
    {
        $this->prix = $prix;

        return $this;
    }

    /**
     * Get prix
     *
     * @return integer
     */
    public function getPrix()
    {
        return $this->prix;
    }

    /**
     * Set stock
     *
     * @param integer $stock
     * @return Article
     */
    public function setStock($stock)
    {

        if(($this->getStock() - $stock) <= 0) {
            $this->stock = 0;
        } else {
            $this->stock = $stock;
        }
        return $this;
    }

    /**
     * Get stock
     *
     * @return integer
     */
    public function getStock()
    {
        return $this->stock;
    }

    /**
     * Get categories
     *
     * @return array
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * @return mixed
     */
    public function getLignesDeCommande()
    {
        return $this->lignesDeCommande;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return int
     */
    public function getNbVentes()
    {
        return $this->nbVentes;
    }

    /**
     * @param int $nbVentes
     */
    public function setNbVentes($nbVentes)
    {
        $this->nbVentes = $nbVentes;
    }

    /**
     * @return mixed
     */
    public function getImages()
    {
        return $this->images;
    }

    /**
     * @param mixed $images
     */
    public function setImages($images)
    {
        $this->images = $images;
    }

    /**
     * @return mixed
     */
    public function getListesSouhaits()
    {
        return $this->listesSouhaits;
    }

    /**
     * @param mixed $listesSouhaits
     */
    public function setListesSouhaits($listesSouhaits)
    {
        $this->listesSouhaits = $listesSouhaits;
    }
}

