<?php

namespace App\Entity;

use App\Repository\CancionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CancionRepository::class)
 */
class Cancion
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
    private $nombre;

    /**
     * @ORM\Column(type="integer")
     */
    private $anio;

    /**
     * @ORM\Column(type="integer")
     */
    private $duracion;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $interprete;

    /**
     * @ORM\ManyToMany(targetEntity=GeneroMusical::class, inversedBy="canciones")
     */
    private $generos;

    /**
     * @ORM\ManyToMany(targetEntity=ConcursoCanciones::class, mappedBy="canciones")
     */
    private $concursos;

    /**
     * @ORM\OneToMany(targetEntity=VotoCancion::class, mappedBy="cancion")
     */
    private $votoCancions;

    public function __construct()
    {
        $this->generos = new ArrayCollection();
        $this->concursos = new ArrayCollection();
        $this->votoCancions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): self
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function getAnio(): ?int
    {
        return $this->anio;
    }

    public function setAnio(int $anio): self
    {
        $this->anio = $anio;

        return $this;
    }

    public function getDuracion(): ?int
    {
        return $this->duracion;
    }

    public function setDuracion(int $duracion): self
    {
        $this->duracion = $duracion;

        return $this;
    }

    public function getInterprete(): ?string
    {
        return $this->interprete;
    }

    public function setInterprete(string $interprete): self
    {
        $this->interprete = $interprete;

        return $this;
    }

    /**
     * @return Collection<int, GeneroMusical>
     */
    public function getGeneros(): Collection
    {
        return $this->generos;
    }

    public function addGenero(GeneroMusical $genero): self
    {
        if (!$this->generos->contains($genero)) {
            $this->generos[] = $genero;
        }

        return $this;
    }

    public function removeGenero(GeneroMusical $genero): self
    {
        $this->generos->removeElement($genero);

        return $this;
    }

    /**
     * @return Collection<int, ConcursoCanciones>
     */
    public function getConcursos(): Collection
    {
        return $this->concursos;
    }

    public function addConcurso(ConcursoCanciones $concurso): self
    {
        if (!$this->concursos->contains($concurso)) {
            $this->concursos[] = $concurso;
            $concurso->addCancione($this);
        }

        return $this;
    }

    public function removeConcurso(ConcursoCanciones $concurso): self
    {
        if ($this->concursos->removeElement($concurso)) {
            $concurso->removeCancione($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, VotoCancion>
     */
    public function getVotoCancions(): Collection
    {
        return $this->votoCancions;
    }

    public function addVotoCancion(VotoCancion $votoCancion): self
    {
        if (!$this->votoCancions->contains($votoCancion)) {
            $this->votoCancions[] = $votoCancion;
            $votoCancion->setCancion($this);
        }

        return $this;
    }

    public function removeVotoCancion(VotoCancion $votoCancion): self
    {
        if ($this->votoCancions->removeElement($votoCancion)) {
            // set the owning side to null (unless already changed)
            if ($votoCancion->getCancion() === $this) {
                $votoCancion->setCancion(null);
            }
        }

        return $this;
    }
}
