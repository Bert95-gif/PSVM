<?php

namespace App\Entity;

use App\Repository\VotoVideojuegoRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=VotoVideojuegoRepository::class)
 */
class VotoVideojuego
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=ConcursoVideojuegos::class, inversedBy="votoVideojuegos")
     */
    private $concurso;

    /**
     * @ORM\ManyToOne(targetEntity=Videojuego::class, inversedBy="votoVideojuegos")
     */
    private $videojuego;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getConcurso(): ?ConcursoVideojuegos
    {
        return $this->concurso;
    }

    public function setConcurso(?ConcursoVideojuegos $concurso): self
    {
        $this->concurso = $concurso;

        return $this;
    }

    public function getVideojuego(): ?Videojuego
    {
        return $this->videojuego;
    }

    public function setVideojuego(?Videojuego $videojuego): self
    {
        $this->videojuego = $videojuego;

        return $this;
    }
}
