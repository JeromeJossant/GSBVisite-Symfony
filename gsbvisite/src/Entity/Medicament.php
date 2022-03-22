<?php

namespace App\Entity;

use App\Repository\MedicamentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MedicamentRepository::class)
 */
class Medicament
{
    /**
     * @ORM\Id
     * @ORM\Column(type="string", length=255)
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nomCommercial;

    /**
     * @ORM\ManyToOne(targetEntity=Famille::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $famille;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $composition;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $effets;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $contreIndications;


    public function __construct()
    {
        $this->offrirs = new ArrayCollection();
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getNomCommercial(): ?string
    {
        return $this->nomCommercial;
    }

    public function setNomCommercial(string $nomCommercial): self
    {
        $this->nomCommercial = $nomCommercial;

        return $this;
    }

    public function getFamille(): ?Famille
    {
        return $this->famille;
    }

    public function setFamille(?Famille $famille): self
    {
        $this->famille = $famille;

        return $this;
    }

    public function getComposition(): ?string
    {
        return $this->composition;
    }

    public function setComposition(string $composition): self
    {
        $this->composition = $composition;

        return $this;
    }

    public function getEffets(): ?string
    {
        return $this->effets;
    }

    public function setEffets(string $effets): self
    {
        $this->effets = $effets;

        return $this;
    }

    public function getContreIndications(): ?string
    {
        return $this->contreIndications;
    }

    public function setContreIndications(string $contreIndications): self
    {
        $this->contreIndications = $contreIndications;

        return $this;
    }
    public function __ToString(){
        return $this->nomCommercial;
    }

}
