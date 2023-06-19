<?php

namespace App\Entity;

use App\Repository\VotoSerieRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=VotoSerieRepository::class)
 */
class VotoSerie
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=ConcursoSeries::class, inversedBy="votoSeries")
     */
    private $concurso;

    /**
     * @ORM\ManyToOne(targetEntity=Serie::class, inversedBy="votoSeries")
     */
    private $serieVotada;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getConcurso(): ?ConcursoSeries
    {
        return $this->concurso;
    }

    public function setConcurso(?ConcursoSeries $concurso): self
    {
        $this->concurso = $concurso;

        return $this;
    }

    public function getSerieVotada(): ?Serie
    {
        return $this->serieVotada;
    }

    public function setSerieVotada(?Serie $serieVotada): self
    {
        $this->serieVotada = $serieVotada;

        return $this;
    }
}
