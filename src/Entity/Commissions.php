<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass="App\Repository\CommissionsRepository")
 */
class Commissions
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=0)
     */
    private $borninf;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=0, nullable=true)
     */
    private $bornesup;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=0, nullable=true)
     */
    private $commissionttc;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBorninf()
    {
        return $this->borninf;
    }

    public function setBorninf($borninf): self
    {
        $this->borninf = $borninf;

        return $this;
    }

    public function getBornesup()
    {
        return $this->bornesup;
    }

    public function setBornesup($bornesup): self
    {
        $this->bornesup = $bornesup;

        return $this;
    }

    public function getCommissionttc()
    {
        return $this->commissionttc;
    }

    public function setCommissionttc($commissionttc): self
    {
        $this->commissionttc = $commissionttc;

        return $this;
    }
}
