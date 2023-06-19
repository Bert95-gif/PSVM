<?php

namespace App\Entity;

use App\Repository\VideojuegoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=VideojuegoRepository::class)
 */
class Videojuego
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
    private $titulo;

    /**
     * @ORM\ManyToMany(targetEntity=Genero::class, inversedBy="videojuegos")
     */
    private $generos;

    /**
     * @ORM\Column(type="integer")
     */
    private $calificacion;

    /**
     * @ORM\ManyToMany(targetEntity=Videoconsola::class, inversedBy="videojuegos")
     */
    private $consolas;

    /**
     * @ORM\Column(type="integer")
     */
    private $anio;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $imagen;

    /**
     * @ORM\ManyToMany(targetEntity=ConcursoVideojuegos::class, mappedBy="videojuegos")
     */
    private $concursoVideojuegos;

    /**
     * @ORM\ManyToMany(targetEntity=Franquicia::class, mappedBy="videojuegos")
     */
    private $franquicias;

    /**
     * @ORM\OneToMany(targetEntity=VotoVideojuego::class, mappedBy="videojuego")
     */
    private $votoVideojuegos;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $enlace;

    public function __construct()
    {
        $this->generos = new ArrayCollection();
        $this->consolas = new ArrayCollection();
        $this->concursoVideojuegos = new ArrayCollection();
        $this->franquicias = new ArrayCollection();
        $this->votoVideojuegos = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitulo(): ?string
    {
        return $this->titulo;
    }

    public function setTitulo(string $titulo): self
    {
        $this->titulo = $titulo;

        return $this;
    }

    /**
     * @return Collection<int, Genero>
     */
    public function getGeneros(): Collection
    {
        return $this->generos;
    }

    public function addGenero(Genero $genero): self
    {
        if (!$this->generos->contains($genero)) {
            $this->generos[] = $genero;
        }

        return $this;
    }

    public function removeGenero(Genero $genero): self
    {
        $this->generos->removeElement($genero);

        return $this;
    }

    public function getCalificacion(): ?int
    {
        return $this->calificacion;
    }

    public function setCalificacion(int $calificacion): self
    {
        $this->calificacion = $calificacion;

        return $this;
    }

    /**
     * @return Collection<int, Videoconsola>
     */
    public function getConsolas(): Collection
    {
        return $this->consolas;
    }

    public function addConsola(Videoconsola $consola): self
    {
        if (!$this->consolas->contains($consola)) {
            $this->consolas[] = $consola;
        }

        return $this;
    }

    public function removeConsola(Videoconsola $consola): self
    {
        $this->consolas->removeElement($consola);

        return $this;
    }

    public function getAnio(): ?int
    {
        return $this->anio;
    }

    public function setAnio(int $anio): self
    {
        $this->anio = $anio;

        return $this;
    }

    public function getImagen(): ?string
    {
        return $this->imagen;
    }

    public function setImagen(string $imagen): self
    {
        $this->imagen = $imagen;

        return $this;
    }

    /**
     * @return Collection<int, ConcursoVideojuegos>
     */
    public function getConcursoVideojuegos(): Collection
    {
        return $this->concursoVideojuegos;
    }

    public function addConcursoVideojuego(ConcursoVideojuegos $concursoVideojuego): self
    {
        if (!$this->concursoVideojuegos->contains($concursoVideojuego)) {
            $this->concursoVideojuegos[] = $concursoVideojuego;
            $concursoVideojuego->addVideojuego($this);
        }

        return $this;
    }

    public function removeConcursoVideojuego(ConcursoVideojuegos $concursoVideojuego): self
    {
        if ($this->concursoVideojuegos->removeElement($concursoVideojuego)) {
            $concursoVideojuego->removeVideojuego($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Franquicia>
     */
    public function getFranquicias(): Collection
    {
        return $this->franquicias;
    }

    public function addFranquicia(Franquicia $franquicia): self
    {
        if (!$this->franquicias->contains($franquicia)) {
            $this->franquicias[] = $franquicia;
            $franquicia->addVideojuego($this);
        }

        return $this;
    }

    public function removeFranquicia(Franquicia $franquicia): self
    {
        if ($this->franquicias->removeElement($franquicia)) {
            $franquicia->removeVideojuego($this);
        }

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
            $votoVideojuego->setVideojuego($this);
        }

        return $this;
    }

    public function removeVotoVideojuego(VotoVideojuego $votoVideojuego): self
    {
        if ($this->votoVideojuegos->removeElement($votoVideojuego)) {
            // set the owning side to null (unless already changed)
            if ($votoVideojuego->getVideojuego() === $this) {
                $votoVideojuego->setVideojuego(null);
            }
        }

        return $this;
    }

    public function getEnlace(): ?string
    {
        return $this->enlace;
    }

    public function setEnlace(?string $enlace): self
    {
        $this->enlace = $enlace;

        return $this;
    }
}
