<?php

namespace App\Entity;

use App\Repository\ConcursoPeliculasRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ConcursoPeliculasRepository::class)
 */
class ConcursoPeliculas
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
     * @ORM\ManyToMany(targetEntity=Pelicula::class, inversedBy="concursos")
     */
    private $peliculas;

    /**
     * @ORM\ManyToOne(targetEntity=Pelicula::class, cascade={"persist", "remove"})
     */
    private $peliculaGanadora;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $fechaInicio;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $fechaFinal;

    /**
     * @ORM\OneToMany(targetEntity=VotoPelicula::class, mappedBy="concurso")
     */
    private $votoPeliculas;

    public function __construct()
    {
        $this->peliculas = new ArrayCollection();
        $this->votoPeliculas = new ArrayCollection();
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
     * @return Collection<int, Pelicula>
     */
    public function getPeliculas(): Collection
    {
        return $this->peliculas;
    }

    public function addPelicula(Pelicula $pelicula): self
    {
        if (!$this->peliculas->contains($pelicula)) {
            $this->peliculas[] = $pelicula;
        }

        return $this;
    }

    public function removePelicula(Pelicula $pelicula): self
    {
        $this->peliculas->removeElement($pelicula);

        return $this;
    }

    public function getPeliculaGanadora(): ?Pelicula
    {
        return $this->peliculaGanadora;
    }

    public function setPeliculaGanadora(?Pelicula $peliculaGanadora): self
    {
        $this->peliculaGanadora = $peliculaGanadora;

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
     * @return Collection<int, VotoPelicula>
     */
    public function getVotoPeliculas(): Collection
    {
        return $this->votoPeliculas;
    }

    public function addVotoPelicula(VotoPelicula $votoPelicula): self
    {
        if (!$this->votoPeliculas->contains($votoPelicula)) {
            $this->votoPeliculas[] = $votoPelicula;
            $votoPelicula->setConcurso($this);
        }

        return $this;
    }

    public function removeVotoPelicula(VotoPelicula $votoPelicula): self
    {
        if ($this->votoPeliculas->removeElement($votoPelicula)) {
            // set the owning side to null (unless already changed)
            if ($votoPelicula->getConcurso() === $this) {
                $votoPelicula->setConcurso(null);
            }
        }

        return $this;
    }

    public function calcularVotosPorPelicula()
    {
        $votos = [];
        foreach ($this->getPeliculas() as $p) {
            $votos[$p->getId()] = 0;
        }

        foreach ($this->getVotoPeliculas() as $p) {
            $votos[$p->getPeliculaVotada()->getId()]++;
        }

        return $votos;
    }

    public function calcularPeliculaGanadora(): Pelicula
    {
        $votosPeliculas = $this->calcularVotosPorPelicula();
        $maxVoto = max($votosPeliculas);
        $idPeliculaGanadora = null;
        foreach ($votosPeliculas as $idPelicula => $votos) {
            if ($maxVoto == $votos) {
                $idPeliculaGanadora = $idPelicula;
            }
        }
        foreach ($this->getPeliculas() as $pelicula) {
            if ($pelicula->getId() == $idPeliculaGanadora) {
                return $pelicula;
            }
        }
        return null;
    }

    public function getVotosByPeliculaId($id): int
    {
        foreach ($this->calcularVotosPorPelicula() as $idPelicula => $votos) {
            if ($id == $idPelicula) {
                return $votos;
            }
        }
        return 0;
    }
}
