<?php

namespace VitrineBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * LigneDeCommande
 *
 * @ORM\Table(name="ligne_de_commande")
 * @ORM\Entity(repositoryClass="VitrineBundle\Repository\LigneDeCommandeRepository")
 */
class LigneDeCommande
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
     * @var int
     *
     * @ORM\Column(name="quantite", type="integer")
     */
    private $quantite;

    /**
     * @ORM\ManyToOne(targetEntity="VitrineBundle\Entity\Commande", inversedBy="lignesDeCommande")
     */
    private $commande;

    /**
     * @ORM\ManyToOne(targetEntity="VitrineBundle\Entity\Article", inversedBy="lignesDeCommande")
     */
    private  $artcile;


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
     * @return int
     */
    public function getQuantite()
    {
        return $this->quantite;
    }

    /**
     * @param int $quantite
     */
    public function setQuantite($quantite)
    {
        $this->quantite = $quantite;
    }

    /**
     * @return mixed
     */
    public function getCommande()
    {
        return $this->commande;
    }

    /**
     * @param mixed $commande
     */
    public function setCommande($commande)
    {
        $this->commande = $commande;
    }

    /**
     * @return mixed
     */
    public function getArtcile()
    {
        return $this->artcile;
    }

    /**
     * @param mixed $artcile
     */
    public function setArtcile($artcile)
    {
        $this->artcile = $artcile;
    }
}

