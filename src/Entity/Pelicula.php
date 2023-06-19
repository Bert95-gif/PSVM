<?php

namespace App\Entity;

use App\Repository\PeliculaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PeliculaRepository::class)
 */
class Pelicula
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
     * @ORM\Column(type="integer")
     */
    private $duracion;

    /**
     * @ORM\Column(type="integer")
     */
    private $anio;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $imagen;

    /**
     * @ORM\ManyToMany(targetEntity=ConcursoPeliculas::class, mappedBy="peliculas")
     */
    private $concursos;

    /**
     * @ORM\ManyToOne(targetEntity=ConcursoPeliculas::class, inversedBy="ganador")
     */
    private $concurso;

    /**
     * @ORM\ManyToMany(targetEntity=Genero::class, inversedBy="peliculas")
     */
    private $generos;

    /**
     * @ORM\ManyToMany(targetEntity=Franquicia::class, mappedBy="peliculas")
     */
    private $franquicias;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $enlace;

    /**
     * @ORM\OneToMany(targetEntity=VotoPelicula::class, mappedBy="peliculaVotada")
     */
    private $votoPeliculas;

    public function __construct()
    {
        $this->concursos = new ArrayCollection();
        $this->generos = new ArrayCollection();
        $this->franquicias = new ArrayCollection();
        $this->votoPeliculas = new ArrayCollection();
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

    public function getDuracion(): ?int
    {
        return $this->duracion;
    }

    public function setDuracion(int $duracion): self
    {
        $this->duracion = $duracion;

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

    public function setImagen(?string $imagen): self
    {
        $this->imagen = $imagen;

        return $this;
    }

    /**
     * @return Collection<int, ConcursoPeliculas>
     */
    public function getConcursos(): Collection
    {
        return $this->concursos;
    }

    public function addConcurso(ConcursoPeliculas $concurso): self
    {
        if (!$this->concursos->contains($concurso)) {
            $this->concursos[] = $concurso;
            $concurso->addPelicula($this);
        }

        return $this;
    }

    public function removeConcurso(ConcursoPeliculas $concurso): self
    {
        if ($this->concursos->removeElement($concurso)) {
            $concurso->removePelicula($this);
        }

        return $this;
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
            $franquicia->addPelicula($this);
        }

        return $this;
    }

    public function removeFranquicia(Franquicia $franquicia): self
    {
        if ($this->franquicias->removeElement($franquicia)) {
            $franquicia->removePelicula($this);
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
            $votoPelicula->setPeliculaVotada($this);
        }

        return $this;
    }

    public function removeVotoPelicula(VotoPelicula $votoPelicula): self
    {
        if ($this->votoPeliculas->removeElement($votoPelicula)) {
            // set the owning side to null (unless already changed)
            if ($votoPelicula->getPeliculaVotada() === $this) {
                $votoPelicula->setPeliculaVotada(null);
            }
        }

        return $this;
    }
}
