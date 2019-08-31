<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass="App\Repository\RetraitRepository")
 */
class Retrait
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Utilisateur")
     */
    private $guichetier;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Typedepiece")
     */
    private $typedepiece;

    /**
     * @ORM\Column(type="bigint", nullable=true)
     */
    private $numeropiece;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $code;

 
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getGuichetier(): ?Utilisateur
    {
        return $this->guichetier;
    }

    public function setGuichetier(?Utilisateur $guichetier): self
    {
        $this->guichetier = $guichetier;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getTypedepiece(): ?Typedepiece
    {
        return $this->typedepiece;
    }

    public function setTypedepiece(?Typedepiece $typedepiece): self
    {
        $this->typedepiece = $typedepiece;

        return $this;
    }

    public function getNumeropiece(): ?int
    {
        return $this->numeropiece;
    }

    public function setNumeropiece(?int $numeropiece): self
    {
        $this->numeropiece = $numeropiece;

        return $this;
    }

    public function getCode(): ?int
    {
        return $this->code;
    }

    public function setCode(?int $code): self
    {
        $this->code = $code;

        return $this;
    }

  
}
