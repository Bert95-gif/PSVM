<?php

namespace App\Entity;

use App\Repository\FranquiciaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=FranquiciaRepository::class)
 */
class Franquicia
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
     * @ORM\ManyToMany(targetEntity=Pelicula::class, inversedBy="franquicias")
     */
    private $peliculas;

    /**
     * @ORM\ManyToMany(targetEntity=Serie::class, inversedBy="franquicias")
     */
    private $series;

    /**
     * @ORM\ManyToMany(targetEntity=Videojuego::class, inversedBy="franquicias")
     */
    private $videojuegos;

    public function __construct()
    {
        $this->peliculas = new ArrayCollection();
        $this->series = new ArrayCollection();
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
}
