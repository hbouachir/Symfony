<?php

namespace App\Entity;

use App\Repository\FactureRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=FactureRepository::class)
 */
class Facture
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
      * @Assert\Length(
     *      min = 3,
     *      max = 10,
     *      minMessage = "Le nom doit comporter au moins {{ limit }} caractères",
     *      maxMessage = "Le nom  doit comporter au plus {{ limit }} caractères"
     * )
     */
    private $de;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $numeroFacture;

    /**
     * @ORM\Column(type="date")
     *    * * @Assert\Range(
     *      min = "first day of January",
     *      max = "first day of January next year"
     * )
     */
    private $Date;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $designation;
  /**
     * @ORM\Column(type="integer", precision=10, scale=0)
      * @Assert\NotEqualTo("0")
     */
   
     
    
    private $montant;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDe(): ?string
    {
        return $this->de;
    }

    public function setDe(string $de): self
    {
        $this->de = $de;

        return $this;
    }

    public function getNumeroFacture(): ?string
    {
        return $this->numeroFacture;
    }

    public function setNumeroFacture(string $numeroFacture): self
    {
        $this->numeroFacture = $numeroFacture;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->Date;
    }

    public function setDate(\DateTimeInterface $Date): self 
    {
        $this->Date = $Date;

        return $this;
    }

    public function getDesignation(): ?string
    {
        return $this->designation;
    }

    public function setDesignation(string $designation): self
    {
        $this->designation = $designation;

        return $this;
    }

    public function getMontant(): ?int
    {
        return $this->montant;
    }

    public function setMontant(int $montant): self
    {
        $this->montant = $montant;

        return $this;
    }
}
