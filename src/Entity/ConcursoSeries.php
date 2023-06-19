<?php

namespace App\Entity;

use App\Repository\ConcursoSeriesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ConcursoSeriesRepository::class)
 */
class ConcursoSeries
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
     * @ORM\ManyToMany(targetEntity=Serie::class, inversedBy="concursoSeries")
     */
    private $series;

    /**
     * @ORM\ManyToOne(targetEntity=Serie::class, inversedBy="concursos")
     */
    private $serieGanadora;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $fechaInicio;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $fechaFinal;

    /**
     * @ORM\OneToMany(targetEntity=VotoSerie::class, mappedBy="concurso")
     */
    private $votoSeries;

    public function __construct()
    {
        $this->series = new ArrayCollection();
        $this->votoSeries = new ArrayCollection();
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
     * @return Collection<int, Serie>
     */
    public function getSeries(): Collection
    {
        return $this->series;
    }

    public function addSeries(Serie $series): self
    {
        if (!$this->series->contains($series)) {
            $this->series[] = $series;
        }

        return $this;
    }

    public function removeSeries(Serie $series): self
    {
        $this->series->removeElement($series);

        return $this;
    }

    public function getSerieGanadora(): ?Serie
    {
        return $this->serieGanadora;
    }

    public function setSerieGanadora(?Serie $serieGanadora): self
    {
        $this->serieGanadora = $serieGanadora;

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
     * @return Collection<int, VotoSerie>
     */
    public function getVotoSeries(): Collection
    {
        return $this->votoSeries;
    }

    public function addVotoSeries(VotoSerie $votoSeries): self
    {
        if (!$this->votoSeries->contains($votoSeries)) {
            $this->votoSeries[] = $votoSeries;
            $votoSeries->setConcurso($this);
        }

        return $this;
    }

    public function removeVotoSeries(VotoSerie $votoSeries): self
    {
        if ($this->votoSeries->removeElement($votoSeries)) {
            // set the owning side to null (unless already changed)
            if ($votoSeries->getConcurso() === $this) {
                $votoSeries->setConcurso(null);
            }
        }

        return $this;
    }

    public function calcularVotosPorSerie()
    {
        $votos = [];
        foreach ($this->getSeries() as $p) {
            $votos[$p->getId()] = 0;
        }

        foreach ($this->getVotoSeries() as $p) {
            $votos[$p->getSerieVotada()->getId()]++;
        }

        return $votos;
    }

    public function calcularSerieGanadora(): Serie
    {
        $votosSeries = $this->calcularVotosPorSerie();
        $maxVoto = max($votosSeries);
        $idSerieGanadora = null;
        foreach ($votosSeries as $idSerie => $votos) {
            if ($maxVoto == $votos) {
                $idSerieGanadora = $idSerie;
            }
        }
        foreach ($this->getSeries() as $serie) {
            if ($serie->getId() == $idSerieGanadora) {
                return $serie;
            }
        }
        return null;
    }

    public function getVotosBySerieId($id): int
    {
        foreach ($this->calcularVotosPorSerie() as $idSerie => $votos) {
            if ($id == $idSerie) {
                return $votos;
            }
        }
        return 0;
    }
}
