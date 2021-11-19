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
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

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
     * * @Assert\Choice({"femme", "homme" , "Homme" , "Femme"},
     *    minMessage = "svp ecrire femme ou homme"
     * )
     
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
     * @ORM\ManyToOne(targetEntity=Personne::class, inversedBy="payments")
     */
    private $nom;
       /**
     * @ORM\ManyToOne(targetEntity=Personne::class, inversedBy="Payment")
     */
    private $Personne;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getNom(): ?Personne
    {
        return $this->nom;
    }

    public function setNom(?Personne $nom): self
    {
        $this->nom = $nom;

        return $this;
    }
    public function getPersonne(): ?Personne
    {
        return $this->Personne;
    }

    public function setPersonne(?Personne $Personne): self
    {
        $this->Personne = $Personne;

        return $this;
    }
}
