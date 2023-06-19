<?php

namespace App\Entity;

use App\Repository\VotoPeliculaRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=VotoPeliculaRepository::class)
 */
class VotoPelicula
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=ConcursoPeliculas::class, inversedBy="votoPeliculas")
     */
    private $concurso;

    /**
     * @ORM\ManyToOne(targetEntity=Pelicula::class, inversedBy="votoPeliculas")
     */
    private $peliculaVotada;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getConcurso(): ?ConcursoPeliculas
    {
        return $this->concurso;
    }

    public function setConcurso(?ConcursoPeliculas $concurso): self
    {
        $this->concurso = $concurso;

        return $this;
    }

    public function getPeliculaVotada(): ?Pelicula
    {
        return $this->peliculaVotada;
    }

    public function setPeliculaVotada(?Pelicula $peliculaVotada): self
    {
        $this->peliculaVotada = $peliculaVotada;

        return $this;
    }
}
