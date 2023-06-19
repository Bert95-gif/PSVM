<?php

namespace App\Entity;

use App\Repository\GeneroMusicalRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=GeneroMusicalRepository::class)
 */
class GeneroMusical
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $tipo;

    /**
     * @ORM\ManyToMany(targetEntity=Cancion::class, mappedBy="generos")
     */
    private $canciones;

    public function __construct()
    {
        $this->canciones = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTipo(): ?string
    {
        return $this->tipo;
    }

    public function setTipo(string $tipo): self
    {
        $this->tipo = $tipo;

        return $this;
    }

    /**
     * @return Collection<int, Cancion>
     */
    public function getCanciones(): Collection
    {
        return $this->canciones;
    }

    public function addCancione(Cancion $cancione): self
    {
        if (!$this->canciones->contains($cancione)) {
            $this->canciones[] = $cancione;
            $cancione->addGenero($this);
        }

        return $this;
    }

    public function removeCancione(Cancion $cancione): self
    {
        if ($this->canciones->removeElement($cancione)) {
            $cancione->removeGenero($this);
        }

        return $this;
    }
}
