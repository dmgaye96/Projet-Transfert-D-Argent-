<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass="App\Repository\EnvoiRepository")
 */
class Envoi
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dateenvoi;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nomE;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $prenomE;

    /**
     * @ORM\Column(type="bigint")
     */
    private $telephoneE;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $AdresseE;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=0)
     */
    private $montant;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Typedepiece")
     * @ORM\JoinColumn(nullable=false)
     */
    private $piece;

    /**
     * @ORM\Column(type="bigint", nullable=true)
     */
    private $Numeropiece;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Pays")
     */
    private $paysenvoi;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Pays")
     */
    private $pays;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $datedelivrance;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $datedevalidite;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nomB;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $prenomB;

    /**
     * @ORM\Column(type="bigint")
     */
    private $telephoneB;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $adresseB;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateenvoi(): ?\DateTimeInterface
    {
        return $this->dateenvoi;
    }

    public function setDateenvoi(?\DateTimeInterface $dateenvoi): self
    {
        $this->dateenvoi = $dateenvoi;

        return $this;
    }

    public function getNomE(): ?string
    {
        return $this->nomE;
    }

    public function setNomE(string $nomE): self
    {
        $this->nomE = $nomE;

        return $this;
    }

    public function getPrenomE(): ?string
    {
        return $this->prenomE;
    }

    public function setPrenomE(string $prenomE): self
    {
        $this->prenomE = $prenomE;

        return $this;
    }

    public function getTelephoneE(): ?int
    {
        return $this->telephoneE;
    }

    public function setTelephoneE(int $telephoneE): self
    {
        $this->telephoneE = $telephoneE;

        return $this;
    }

    public function getAdresseE(): ?string
    {
        return $this->AdresseE;
    }

    public function setAdresseE(?string $AdresseE): self
    {
        $this->AdresseE = $AdresseE;

        return $this;
    }

    public function getMontant()
    {
        return $this->montant;
    }

    public function setMontant($montant): self
    {
        $this->montant = $montant;

        return $this;
    }

    public function getPiece(): ?Typedepiece
    {
        return $this->piece;
    }

    public function setPiece(?Typedepiece $piece): self
    {
        $this->piece = $piece;

        return $this;
    }

    public function getNumeropiece(): ?int
    {
        return $this->Numeropiece;
    }

    public function setNumeropiece(?int $Numeropiece): self
    {
        $this->Numeropiece = $Numeropiece;

        return $this;
    }

    public function getPaysenvoi(): ?Pays
    {
        return $this->paysenvoi;
    }

    public function setPaysenvoi(?Pays $paysenvoi): self
    {
        $this->paysenvoi = $paysenvoi;

        return $this;
    }

    public function getPays(): ?Pays
    {
        return $this->pays;
    }

    public function setPays(?Pays $pays): self
    {
        $this->pays = $pays;

        return $this;
    }

    public function getDatedelivrance(): ?\DateTimeInterface
    {
        return $this->datedelivrance;
    }

    public function setDatedelivrance(?\DateTimeInterface $datedelivrance): self
    {
        $this->datedelivrance = $datedelivrance;

        return $this;
    }

    public function getDatedevalidite(): ?\DateTimeInterface
    {
        return $this->datedevalidite;
    }

    public function setDatedevalidite(?\DateTimeInterface $datedevalidite): self
    {
        $this->datedevalidite = $datedevalidite;

        return $this;
    }

    public function getNomB(): ?string
    {
        return $this->nomB;
    }

    public function setNomB(string $nomB): self
    {
        $this->nomB = $nomB;

        return $this;
    }

    public function getPrenomB(): ?string
    {
        return $this->prenomB;
    }

    public function setPrenomB(string $prenomB): self
    {
        $this->prenomB = $prenomB;

        return $this;
    }

    public function getTelephoneB(): ?int
    {
        return $this->telephoneB;
    }

    public function setTelephoneB(int $telephoneB): self
    {
        $this->telephoneB = $telephoneB;

        return $this;
    }

    public function getAdresseB(): ?string
    {
        return $this->adresseB;
    }

    public function setAdresseB(?string $adresseB): self
    {
        $this->adresseB = $adresseB;

        return $this;
    }
}
