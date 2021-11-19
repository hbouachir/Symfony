<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

class nomRecherche
{

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Payment")
     */
    private $nom;


    public function getNom(): ?Payment
    {
        return $this->nom;
    }

    public function setNom(?nom $nom): self
    {
        $this->nom = $nom;

        return $this;
    }



}