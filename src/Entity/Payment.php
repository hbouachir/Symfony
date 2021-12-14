<?php

namespace App\Entity;

use App\Repository\PaymentRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=PaymentRepository::class)
 */
class Payment
{
    /**
      * @ORM\Column(name="idpayment", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $idpayment;
   

    /**
     * @ORM\Column(type="string", length=255)
     * * @Assert\Length(
     *      min = 3,
     *      max = 10,
     *      minMessage = "Le nom doit comporter au moins {{ limit }} caractères",
     *      maxMessage = "Le nom  doit comporter au plus {{ limit }} caractères"
     * )
     */
    
    private $numeroCompte;
    

    /**
     * @ORM\Column(type="string", length=255)
   
     
     */
  
    
    private $civilite;

    /**
     * @ORM\Column(type="string", length=255)
      * * @Assert\Length(
     *      min = 8,
     *      max = 20,
     *      minMessage = "Le nom doit comporter au moins {{ limit }} caractères",
     *      maxMessage = "Le nom  doit comporter au plus {{ limit }} caractères"
     * )
     */
     
    private $password;

    /**
     * @ORM\Column(type="date")
     * * @Assert\Range(
     *      min = "first day of January",
     *      max = "first day of January next year"
     * )
     */
    private $dateExpiration;

    
    
     /**
     * @var \Commande
     *
     * @ORM\ManyToOne(targetEntity="Commande")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idCommande", referencedColumnName="idCommande")
     * })
     */
    private $idCommande;

    public function getIdpayment(): ?int
    {
        return $this->idpayment;
    }

    public function getNumeroCompte(): ?string
    {
        return $this->numeroCompte;
    }

    public function setNumeroCompte(string $numeroCompte): self
    {
        $this->numeroCompte = $numeroCompte;

        return $this;
    }

    public function getCivilite(): ?string
    {
        return $this->civilite;
    }

    public function setCivilite(string $civilite): self
    {
        $this->civilite = $civilite;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getDateExpiration(): ?\DateTimeInterface
    {
        return $this->dateExpiration;
    }

  
    public function setDateExpiration(\DateTimeInterface $dateExpiration): self
    {
        $this->dateExpiration = $dateExpiration;

        return $this;
    }

  
    
     /**
     * @return \Commande
     */
    public function getIdcommande(): \Commande
    {
        return $this->idCommande;
    }

    /**
     * @param \Commande $idCommande
     * @return Payment
     */
    public function setIdcommande(\Commande $idCommande): Commande
    {
        $this->idCommande = $idCommande;
        return $this;
    }
    
   
}
