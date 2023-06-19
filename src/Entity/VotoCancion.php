<?php

namespace App\Entity;

use App\Repository\VotoCancionRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=VotoCancionRepository::class)
 */
class VotoCancion
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=ConcursoCanciones::class, inversedBy="votoCancions")
     */
    private $concurso;

    /**
     * @ORM\ManyToOne(targetEntity=Cancion::class, inversedBy="votoCancions")
     */
    private $cancion;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getConcurso(): ?ConcursoCanciones
    {
        return $this->concurso;
    }

    public function setConcurso(?ConcursoCanciones $concurso): self
    {
        $this->concurso = $concurso;

        return $this;
    }

    public function getCancion(): ?Cancion
    {
        return $this->cancion;
    }

    public function setCancion(?Cancion $cancion): self
    {
        $this->cancion = $cancion;

        return $this;
    }
}
