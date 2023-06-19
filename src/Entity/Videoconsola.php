<?php

namespace App\Entity;

use App\Repository\VideoconsolaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=VideoconsolaRepository::class)
 */
class Videoconsola
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
     * @ORM\Column(type="string", length=255)
     */
    private $abreviatura;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $empresa;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $imagen;

    /**
     * @ORM\ManyToMany(targetEntity=Videojuego::class, mappedBy="consolas")
     */
    private $videojuegos;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $anioProduccion;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $anioDescontinuacion;

    public function __construct()
    {
        $this->videojuegos = new ArrayCollection();
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

    public function getAbreviatura(): ?string
    {
        return $this->abreviatura;
    }

    public function setAbreviatura(string $abreviatura): self
    {
        $this->abreviatura = $abreviatura;

        return $this;
    }

    public function getEmpresa(): ?string
    {
        return $this->empresa;
    }

    public function setEmpresa(string $empresa): self
    {
        $this->empresa = $empresa;

        return $this;
    }

    public function getImagen(): ?string
    {
        return $this->imagen;
    }

    public function setImagen(?string $imagen): self
    {
        $this->imagen = $imagen;

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
            $videojuego->addConsola($this);
        }

        return $this;
    }

    public function removeVideojuego(Videojuego $videojuego): self
    {
        if ($this->videojuegos->removeElement($videojuego)) {
            $videojuego->removeConsola($this);
        }

        return $this;
    }

    public function getAnioProduccion(): ?int
    {
        return $this->anioProduccion;
    }

    public function setAnioProduccion(?int $anioProduccion): self
    {
        $this->anioProduccion = $anioProduccion;

        return $this;
    }

    public function getAnioDescontinuacion(): ?int
    {
        return $this->anioDescontinuacion;
    }

    public function setAnioDescontinuacion(?int $anioDescontinuacion): self
    {
        $this->anioDescontinuacion = $anioDescontinuacion;

        return $this;
    }
}
