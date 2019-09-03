<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\PartenaireRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass="App\Repository\PartenaireRepository")
 */
class Partenaire 
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"liste-compte"})
     */
    private $raisonsociale;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"liste-compte"})
     */
    private $ninea;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"liste-compte"})
     */
    private $adresse;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Utilisateur", mappedBy="partenaire")
     */
    private $utilisateur;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Utilisateur", mappedBy="partenaire")
     */
    private $no;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $statut;

    public function __construct()
    {
        $this->utilisateur = new ArrayCollection();
        $this->no = new ArrayCollection();
    }

    public function getId(): ?int 
    {
        return $this->id;
    }

    public function getRaisonsociale(): ?string
    {
        return $this->raisonsociale;
    }

    public function setRaisonsociale(string $raisonsociale): self
    {
        $this->raisonsociale = $raisonsociale;

        return $this;
    }

    public function getNinea(): ?string
    {
        return $this->ninea;
    }

    public function setNinea(string $ninea): self
    {
        $this->ninea = $ninea;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    /**
     * @return Collection|utilisateur[]
     */
    public function getUtilisateur(): Collection
    {
        return $this->utilisateur;
    }

    public function addUtilisateur(utilisateur $utilisateur): self
    {
        if (!$this->utilisateur->contains($utilisateur)) {
            $this->utilisateur[] = $utilisateur;
            $utilisateur->setPartenaire($this);
        }

        return $this;
    }

    public function removeUtilisateur(utilisateur $utilisateur): self
    {
        if ($this->utilisateur->contains($utilisateur)) {
            $this->utilisateur->removeElement($utilisateur);
            // set the owning side to null (unless already changed)
            if ($utilisateur->getPartenaire() === $this) {
                $utilisateur->setPartenaire(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Utilisateur[]
     */
    public function getNo(): Collection
    {
        return $this->no;
    }

    public function addNo(Utilisateur $no): self
    {
        if (!$this->no->contains($no)) {
            $this->no[] = $no;
            $no->setPartenaire($this);
        }

        return $this;
    }

    public function removeNo(Utilisateur $no): self
    {
        if ($this->no->contains($no)) {
            $this->no->removeElement($no);
            // set the owning side to null (unless already changed)
            if ($no->getPartenaire() === $this) {
                $no->setPartenaire(null);
            }
        }

        return $this;
    }

    public function getStatut(): ?string
    {
        return $this->statut;
    }

    public function setStatut(?string $statut): self
    {
        $this->statut = $statut;

        return $this;
    }
}
