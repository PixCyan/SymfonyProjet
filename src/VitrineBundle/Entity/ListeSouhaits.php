<?php

namespace VitrineBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * ListeSouhaits
 *
 * @ORM\Table(name="listeSouhaits")
 * @ORM\Entity(repositoryClass="VitrineBundle\Repository\ListeSouhaitsRepository")
 */
class ListeSouhaits
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
     * @ORM\Column(name="nom", type="string", length=255)
     */
    private $nom;

    /**
     * @ORM\OneToOne(targetEntity="VitrineBundle\Entity\Client", inversedBy="listeSouhaits")
     */
    private $client;

    /**
     * @ORM\ManyToMany(targetEntity="VitrineBundle\Entity\Article", mappedBy="listesSouhaits")
     */
    private $articles;

    public function __construct()
    {
        $this->articles = new ArrayCollection();
        $this->setNom("Ma liste de Souhaits");
    }

    /**
     * Ajoute/lie un article
     */
    public function addArticle(Article $article)
    {
        $this->articles[] = $article;
    }

    /**
     * Supprime un article
     */
    public function removeArticle(Article $article)
    {
        $this->articles->removeElement($article);
    }

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
     * Set nom
     *
     * @param string $nom
     * @return ListeSouhaits
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string 
     */
    public function getNom()
    {
        return $this->nom;
    }
}
