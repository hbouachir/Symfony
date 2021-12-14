<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Livraison
 *
 * @ORM\Table(name="livraison", indexes={@ORM\Index(name="idComm", columns={"idCommande"}), @ORM\Index(name="idLivreur", columns={"idLivreur"})})
 * @ORM\Entity
 */
class Livraison
{
    /**
     * @var string|null
     *
     * @ORM\Column(name="dateLivraison", type="string", length=255, nullable=true)
     */
    private $datelivraison;



    /**
     * @var int
     *
     * @ORM\Column(name="idLivraison", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idlivraison;



    /**
     * @var bool
     *
     * @ORM\Column(name="etatLivraison", type="boolean", nullable=false)
     */
    private $etatlivraison;

    /**
     * @var \Commande
     *
     * @ORM\ManyToOne(targetEntity="Commande")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idCommande", referencedColumnName="idCommande")
     * })
     */
    private $idcommande;

    /**
     * @var \Personne
     *
     * @ORM\ManyToOne(targetEntity="Personne")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idLivreur", referencedColumnName="id")
     * })
     */
    private $idlivreur;

    public function getDatelivraison(): ?string
    {
        return $this->datelivraison;
    }

    public function setDatelivraison(string $datelivraison): self
    {
        $this->datelivraison = $datelivraison;

        return $this;
    }

    public function getIdlivraison(): ?int
    {
        return $this->idlivraison;
    }


    public function getEtatlivraison(): ?bool
    {
        return $this->etatlivraison;
    }

    public function setEtatlivraison(bool $etatlivraison): self
    {
        $this->etatlivraison = $etatlivraison;

        return $this;
    }

    public function getIdcommande(): ?Commande
    {
        return $this->idcommande;
    }

    public function setIdcommande(?Commande $idcommande): self
    {
        $this->idcommande = $idcommande;

        return $this;
    }

    public function getIdlivreur(): ?Personne
    {
        return $this->idlivreur;
    }

    public function setIdlivreur(?Personne $idlivreur): self
    {
        $this->idlivreur = $idlivreur;

        return $this;
    }


}
