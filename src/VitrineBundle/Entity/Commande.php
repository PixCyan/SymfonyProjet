<?php

namespace VitrineBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\DateTime;

/**
 * Commande
 *
 * @ORM\Table(name="commande")
 * @ORM\Entity(repositoryClass="VitrineBundle\Repository\CommandeRepository")
 */
class Commande
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
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @var bool
     *
     * @ORM\Column(name="etat", type="boolean")
     */
    private $etat;

    /**
     * @ORM\ManyToOne(targetEntity="VitrineBundle\Entity\Client", inversedBy="commandes")
     */
    private $client;

    /**
     * @ORM\OneToMany(targetEntity="VitrineBundle\Entity\LigneDeCommande", mappedBy="commande")
     */
    private $lignesDeCommande;


    public function __construct()
    {
        $this->lignesDeCommande = new ArrayCollection();
        $this->date = new \DateTime();
    }

    /**
     * Ajoute/lie une ligneDeCommande
     */
    public function addLigneDeCommande(LigneDeCommande $l)
    {
        $this->lignesDeCommande[] = $l;
    }

    /**
     * Supprime une ligneDeCommande
     */
    public function removeLigneDeCommande(LigneDeCommande $l)
    {
        $this->lignesDeCommande->removeElement($l);
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
     * Set date
     *
     * @param \DateTime $date
     * @return Commande
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime 
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set etat
     *
     * @param boolean $etat
     * @return Commande
     */
    public function setEtat($etat)
    {
        $this->etat = $etat;

        return $this;
    }

    /**
     * Get etat
     *
     * @return boolean 
     */
    public function getEtat()
    {
        return $this->etat;
    }

    /**
     * @return mixed
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * @param mixed $client
     */
    public function setClient($client)
    {
        $this->client = $client;
    }

    /**
     * @return mixed
     */
    public function getLignesDeCommande()
    {
        return $this->lignesDeCommande;
    }

}

