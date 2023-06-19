<?php

namespace App\Entity;

use App\Repository\SerieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SerieRepository::class)
 */
class Serie
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
    private $episodios;

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
     * @ORM\ManyToMany(targetEntity=Genero::class, inversedBy="series")
     */
    private $generos;

    /**
     * @ORM\ManyToMany(targetEntity=ConcursoSeries::class, mappedBy="series")
     */
    private $concursoSeries;

    /**
     * @ORM\ManyToMany(targetEntity=Franquicia::class, mappedBy="series")
     */
    private $franquicias;

    /**
     * @ORM\OneToMany(targetEntity=ConcursoSeries::class, mappedBy="serieGanadora")
     */
    private $concursos;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $enlace;

    /**
     * @ORM\OneToMany(targetEntity=VotoSerie::class, mappedBy="serieVotada")
     */
    private $votoSeries;

    public function __construct()
    {
        $this->generos = new ArrayCollection();
        $this->concursoSeries = new ArrayCollection();
        $this->franquicias = new ArrayCollection();
        $this->concursos = new ArrayCollection();
        $this->votoSeries = new ArrayCollection();
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

    public function getEpisodios(): ?int
    {
        return $this->episodios;
    }

    public function setEpisodios(int $episodios): self
    {
        $this->episodios = $episodios;

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
     * @return Collection<int, ConcursoSeries>
     */
    public function getConcursoSeries(): Collection
    {
        return $this->concursoSeries;
    }

    public function addConcursoSeries(ConcursoSeries $concursoSeries): self
    {
        if (!$this->concursoSeries->contains($concursoSeries)) {
            $this->concursoSeries[] = $concursoSeries;
            $concursoSeries->addSeries($this);
        }

        return $this;
    }

    public function removeConcursoSeries(ConcursoSeries $concursoSeries): self
    {
        if ($this->concursoSeries->removeElement($concursoSeries)) {
            $concursoSeries->removeSeries($this);
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
            $franquicia->addSeries($this);
        }

        return $this;
    }

    public function removeFranquicia(Franquicia $franquicia): self
    {
        if ($this->franquicias->removeElement($franquicia)) {
            $franquicia->removeSeries($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, ConcursoSeries>
     */
    public function getConcursos(): Collection
    {
        return $this->concursos;
    }

    public function addConcurso(ConcursoSeries $concurso): self
    {
        if (!$this->concursos->contains($concurso)) {
            $this->concursos[] = $concurso;
            $concurso->setSerieGanadora($this);
        }

        return $this;
    }

    public function removeConcurso(ConcursoSeries $concurso): self
    {
        if ($this->concursos->removeElement($concurso)) {
            // set the owning side to null (unless already changed)
            if ($concurso->getSerieGanadora() === $this) {
                $concurso->setSerieGanadora(null);
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
            $votoSeries->setSerieVotada($this);
        }

        return $this;
    }

    public function removeVotoSeries(VotoSerie $votoSeries): self
    {
        if ($this->votoSeries->removeElement($votoSeries)) {
            // set the owning side to null (unless already changed)
            if ($votoSeries->getSerieVotada() === $this) {
                $votoSeries->setSerieVotada(null);
            }
        }

        return $this;
    }
}
