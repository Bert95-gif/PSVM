<?php

namespace App\Entity;

use App\Repository\ConcursoCancionesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ConcursoCancionesRepository::class)
 */
class ConcursoCanciones
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
     * @ORM\ManyToMany(targetEntity=Cancion::class, inversedBy="concursos")
     */
    private $canciones;

    /**
     * @ORM\ManyToOne(targetEntity=Cancion::class)
     */
    private $cancionGanadora;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $fechaInicio;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $fechaFinal;

    /**
     * @ORM\OneToMany(targetEntity=VotoCancion::class, mappedBy="concurso")
     */
    private $votoCancions;

    public function __construct()
    {
        $this->canciones = new ArrayCollection();
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
        }

        return $this;
    }

    public function removeCancione(Cancion $cancione): self
    {
        $this->canciones->removeElement($cancione);

        return $this;
    }

    public function getCancionGanadora(): ?Cancion
    {
        return $this->cancionGanadora;
    }

    public function setCancionGanadora(?Cancion $cancionGanadora): self
    {
        $this->cancionGanadora = $cancionGanadora;

        return $this;
    }

    public function getFechaInicio(): ?\DateTimeInterface
    {
        return $this->fechaInicio;
    }

    public function setFechaInicio(?\DateTimeInterface $fechaInicio): self
    {
        $this->fechaInicio = $fechaInicio;

        return $this;
    }

    public function getFechaFinal(): ?\DateTimeInterface
    {
        return $this->fechaFinal;
    }

    public function setFechaFinal(?\DateTimeInterface $fechaFinal): self
    {
        $this->fechaFinal = $fechaFinal;

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
            $votoCancion->setConcurso($this);
        }

        return $this;
    }

    public function removeVotoCancion(VotoCancion $votoCancion): self
    {
        if ($this->votoCancions->removeElement($votoCancion)) {
            // set the owning side to null (unless already changed)
            if ($votoCancion->getConcurso() === $this) {
                $votoCancion->setConcurso(null);
            }
        }

        return $this;
    }

    public function calcularVotosPorCancion()
    {
        $votos = [];
        foreach ($this->getCanciones() as $p) {
            $votos[$p->getId()] = 0;
        }

        foreach ($this->getVotoCancions() as $p) {
            $votos[$p->getCancion()->getId()]++;
        }

        return $votos;
    }

    public function calcularCancionGanadora(): Cancion
    {
        $votosMusica = $this->calcularVotosPorCancion();
        $maxVoto = max($votosMusica);
        $idCancionGanadora = null;
        foreach ($votosMusica as $idCancion => $votos) {
            if ($maxVoto == $votos) {
                $idCancionGanadora = $idCancion;
            }
        }
        foreach ($this->getCanciones() as $cancion) {
            if ($cancion->getId() == $idCancionGanadora) {
                return $cancion;
            }
        }
        return null;
    }

    public function getVotosByCancionId($id): int
    {
        foreach ($this->calcularVotosPorCancion() as $idCancion => $votos) {
            if ($id == $idCancion) {
                return $votos;
            }
        }
        return 0;
    }
}
