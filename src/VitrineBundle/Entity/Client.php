<?php

namespace VitrineBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Client
 *
 * @ORM\Table(name="client")
 * @ORM\Entity(repositoryClass="VitrineBundle\Repository\ClientRepository")
 */
class Client implements UserInterface, \Serializable {
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
     * @var string
     *
     * @ORM\Column(name="prenom", type="string", length=255)
     */
    private $prenom;

    /**
     * @var string
     *
     * @ORM\Column(name="mail", type="string", length=255)
     */
    private $mail;

    /**
     * @var string
     *
     * @ORM\Column(name="motDePasse", type="string", length=255)
     */
    private $motDePasse;

    /**
     * @var array
     *
     * @ORM\Column(name="roles", type="array", nullable=true)
     */
    private $roles;

    /**
     * @var string
     *
     * @ORM\Column(name="ancienMotDePasse", type="string", length=255, nullable=true)
     */
    private $ancienMdp;

    /**
     * @ORM\OneToMany(targetEntity="VitrineBundle\Entity\Commande", mappedBy="client", cascade={"remove"})
     */
    private $commandes;


    public function __construct() {
        $this->commandes = new ArrayCollection();
        $this->roles = array();
    }

    /**
     * Ajoute/lie une categorie à l'article
     */
    public function addCommande(Commande $commande) {
        $this->commandes[] = $commande;
    }

    /**
     * Supprime une categorie de l'article
     */
    public function removeCommande(Commande $commande) {
        $this->commandes->removeElement($commande);
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
     * Set nom
     *
     * @param string $nom
     * @return Client
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

    /**
     * Set mail
     *
     * @param string $mail
     * @return Client
     */
    public function setMail($mail) {
        $this->mail = $mail;

        return $this;
    }

    /**
     * Get mail
     *
     * @return string 
     */
    public function getMail() {
        return $this->mail;
    }

    /**
     * Set prenom
     *
     * @param string $prenom
     * @return Client
     */
    public function setPrenom($prenom) {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * Get prenom
     *
     * @return string 
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * @return string
     */
    public function getMotDePasse()
    {
        return $this->motDePasse;
    }

    /**
     * @param string $mdp
     */
    public function setMotDePasse($mdp)
    {
        $this->motDePasse = $mdp;
    }

    /**
     * @return string
     */
    public function getAncienMdp()
    {
        return $this->ancienMdp;
    }

    /**
     * @param string $ancienMdp
     */
    public function setAncienMdp($ancienMdp)
    {
        $this->ancienMdp = $ancienMdp;
    }

    /**
     * @return mixed
     */
    public function getCommandes()
    {
        return $this->commandes;
    }


    //Function sécurité/login
    public function getUsername() {
        return $this->mail; // l'email est utilisé comme login
    }

    public function getSalt() {
        return null; // inutile avec l’encryptage choisi
    }

    public function getPassword() {
        return $this->motDePasse;
    }

    public function getRoles() {
        if ($this->isAdministrateur()) {
            // Si le client est administrateur
            return array('ROLE_ADMIN');
        } else {
            return array('ROLE_USER');
        }
    }

    public function addRole($role)
    {
        if(!isset($this->roles[$role])) {
            $this->roles[$role] = $role;
        }

        return $this;
    }

    public function removeRole($role)
    {
        if (in_array($role, $this->roles, true)) {
            unset($this->roles[$role]);
        }
        return $this;
    }


    public function eraseCredentials(){
        // rien à faire ici
    }

    public function serialize() {
        // pour pouvoir sérialiser le Client en session
        return serialize(array($this->id));
    }

    public function unserialize($serialized) {
        list ($this->id) = unserialize($serialized);
    }

    public function isAdministrateur() {
        if(isset($this->roles['ROLE_ADMIN'])) {
            return true;
        } else {
            return false;
        }
    }

}
