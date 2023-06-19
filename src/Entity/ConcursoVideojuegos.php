<?php

namespace App\Entity;

use App\Repository\ConcursoVideojuegosRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ConcursoVideojuegosRepository::class)
 */
class ConcursoVideojuegos
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
     * @ORM\ManyToMany(targetEntity=Videojuego::class, inversedBy="concursoVideojuegos")
     */
    private $videojuegos;

    /**
     * @ORM\ManyToOne(targetEntity=Videojuego::class)
     */
    private $juegoGanador;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $fechaInicio;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $fechaFinal;

    /**
     * @ORM\OneToMany(targetEntity=VotoVideojuego::class, mappedBy="concurso")
     */
    private $votoVideojuegos;

    public function __construct()
    {
        $this->videojuegos = new ArrayCollection();
        $this->votoVideojuegos = new ArrayCollection();
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
     * @return Collection<int, Videojuego>
     */
    public function getVideojuegos(): Collection
    {
        return $this->videojuegos;
    }

    public function addVideojuego(Videojuego $videojuego): self
    {
        if (!$this->videojuegos->contains($videojuego)) {
            $this->videojuegos[] = $videojuego;
        }

        return $this;
    }

    public function removeVideojuego(Videojuego $videojuego): self
    {
        $this->videojuegos->removeElement($videojuego);

        return $this;
    }

    public function getJuegoGanador(): ?Videojuego
    {
        return $this->juegoGanador;
    }

    public function setJuegoGanador(?Videojuego $juegoGanador): self
    {
        $this->juegoGanador = $juegoGanador;

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
     * @return Collection<int, VotoVideojuego>
     */
    public function getVotoVideojuegos(): Collection
    {
        return $this->votoVideojuegos;
    }

    public function addVotoVideojuego(VotoVideojuego $votoVideojuego): self
    {
        if (!$this->votoVideojuegos->contains($votoVideojuego)) {
            $this->votoVideojuegos[] = $votoVideojuego;
            $votoVideojuego->setConcurso($this);
        }

        return $this;
    }

    public function removeVotoVideojuego(VotoVideojuego $votoVideojuego): self
    {
        if ($this->votoVideojuegos->removeElement($votoVideojuego)) {
            // set the owning side to null (unless already changed)
            if ($votoVideojuego->getConcurso() === $this) {
                $votoVideojuego->setConcurso(null);
            }
        }

        return $this;
    }

    public function calcularVotosPorJuego()
    {
        $votos = [];
        foreach ($this->getVideojuegos() as $p) {
            $votos[$p->getId()] = 0;
        }

        foreach ($this->getVotoVideojuegos() as $p) {
            $votos[$p->getVideojuego()->getId()]++;
        }

        return $votos;
    }

    public function calcularJuegoGanador(): Videojuego
    {
        $votosJuegos = $this->calcularVotosPorJuego();
        $maxVoto = max($votosJuegos);
        $idJuegoGanador = null;
        foreach ($votosJuegos as $idJuego => $votos) {
            if ($maxVoto == $votos) {
                $idJuegoGanador = $idJuego;
            }
        }
        foreach ($this->getVideojuegos() as $juego) {
            if ($juego->getId() == $idJuegoGanador) {
                return $juego;
            }
        }
        return null;
    }

    public function getVotosByJuegoId($id): int
    {
        foreach ($this->calcularVotosPorJuego() as $idJuego => $votos) {
            if ($id == $idJuego) {
                return $votos;
            }
        }
        return 0;
    }
}
