<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass="App\Repository\CompteRepository")
 */
class Compte
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     */
    private $numerocompte;

    /**
     * @ORM\Column(type="decimal", precision=9)
     */
    private $solde;

    /**
     * @ORM\ManyToOne(targetEntity="Partenaire", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $partenaire;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumerocompte(): ?string
    {
        return $this->numerocompte;
    }

    public function setNumerocompte(string $numerocompte): self
    {
        $this->numerocompte = $numerocompte;

        return $this;
    }

    public function getSolde(): ?int
    {
        return $this->solde;
    }

    public function setSolde(int $solde): self
    {
        $this->solde = $solde;

        return $this;
    }

    public function getPartenaire(): ?partenaire
    {
        return $this->partenaire;
    }

    public function setPartenaire(partenaire $partenaire): self
    {
        $this->partenaire = $partenaire;

        return $this;
    }
}
