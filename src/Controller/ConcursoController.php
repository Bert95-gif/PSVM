<?php

namespace App\Controller;

use App\Entity\Cancion;
use App\Entity\ConcursoCanciones;
use App\Entity\ConcursoPeliculas;
use App\Entity\ConcursoSeries;
use App\Entity\ConcursoVideojuegos;
use App\Entity\Pelicula;
use App\Entity\Serie;
use App\Entity\Videojuego;
use App\Entity\VotoCancion;
use App\Entity\VotoPelicula;
use App\Entity\VotoSerie;
use App\Entity\VotoVideojuego;
use App\Form\ConcursoCancionesType;
use App\Form\ConcursoPeliculasType;
use App\Form\ConcursoSeriesType;
use App\Form\ConcursoVideojuegosType;
use App\Repository\ConcursoCancionesRepository;
use App\Repository\ConcursoPeliculasRepository;
use App\Repository\ConcursoSeriesRepository;
use App\Repository\ConcursoVideojuegosRepository;
use App\Repository\PeliculaRepository;
use Doctrine\ORM\EntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use phpDocumentor\Reflection\Types\Integer;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ConcursoController extends AbstractController
{

    /**
     * @Route("/", name="app_inicio")
     */
    public function inicio(): Response
    {
        return $this->render('inicio/index.html.twig');
    }

    /**
     * @Route("/concurso", name="app_concurso")
     */
    public function index(ManagerRegistry $doctrine): Response
    {
        $concurso_peliculaRepository = new ConcursoPeliculasRepository($doctrine);
        $concurso_serieRepository = new ConcursoSeriesRepository($doctrine);
        $concurso_videojuegoRepository = new ConcursoVideojuegosRepository($doctrine);
        $concurso_cancionRepository = new ConcursoCancionesRepository($doctrine);
        $concursos_videojuegos = $concurso_videojuegoRepository->findAll();
        $concursos_series = $concurso_serieRepository->findAll();
        $concursos_peliculas = $concurso_peliculaRepository->findAll();
        $concursos_canciones = $concurso_cancionRepository->findAll();
        return $this->render('concurso/index.html.twig', array('concursos_canciones' => $concursos_canciones, 'concursos_series' => $concursos_series, 'concursos_peliculas' => $concursos_peliculas, 'concursos_videojuegos' => $concursos_videojuegos));
    }

    /**
     * @Route("/concurso/new/pelicula", name="app_concurso_new_peliculas")
     */
    public function newConcursoPeliculas(ManagerRegistry $doctrine, Request $request): Response
    {
        $concurso = new ConcursoPeliculas();
        $form = $this->createForm(ConcursoPeliculasType::class, $concurso);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $doctrine->getManager();
            $entityManager->persist($concurso);
            $entityManager->flush();
            return $this->render('concurso/confirm.html.twig', []);
        }
        return $this->render('concurso/newPelicula.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/concurso/new/serie", name="app_concurso_new_series")
     */
    public function newConcursoSeries(ManagerRegistry $doctrine, Request $request): Response
    {
        $concurso = new ConcursoSeries();
        $form = $this->createForm(ConcursoSeriesType::class, $concurso);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $doctrine->getManager();
            $entityManager->persist($concurso);
            $entityManager->flush();
            return $this->render('concurso/confirm.html.twig', []);
        }
        return $this->render('concurso/newSerie.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/concurso/new/videojuego", name="app_concurso_new_videojuegos")
     */
    public function newConcursoVideojuegos(ManagerRegistry $doctrine, Request $request): Response
    {
        $concurso = new ConcursoVideojuegos();
        $form = $this->createForm(ConcursoVideojuegosType::class, $concurso);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $doctrine->getManager();
            $entityManager->persist($concurso);
            $entityManager->flush();
            return $this->render('/concurso/confirm.html.twig', []);
        }

        return $this->render('/concurso/newVideojuego.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/concurso/new/cancion", name="app_concurso_new_canciones")
     */
    public function newConcursoCanciones(ManagerRegistry $doctrine, Request $request): Response
    {
        $concurso = new ConcursoCanciones();
        $form = $this->createForm(ConcursoCancionesType::class, $concurso);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $doctrine->getManager();
            $entityManager->persist($concurso);
            $entityManager->flush();
            return $this->render('/concurso/confirm.html.twig', []);
        }

        return $this->render('/concurso/newCancion.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/concurso/pelicula/voto/{id}", name="app_voto_peliculas")
     */
    public function votarPelicula(ManagerRegistry $doctrine, Request $request, $id): Response
    {
        $concurso_peliculaRepository = new ConcursoPeliculasRepository($doctrine);
        $concurso = $concurso_peliculaRepository->findOneBy(['id' => $id]);
        $choices = $concurso->getPeliculas();
        $voto = new VotoPelicula();
        $voto->setConcurso($concurso);
        $form = $this->createFormBuilder($voto)
            ->add('peliculaVotada', EntityType::class, ['class' => Pelicula::class, 'choices' => $choices, "multiple" => false, 'expanded' => true, 'choice_label' => 'titulo', 'label' => 'Títulos de películas'])
            ->add('save', SubmitType::class, ['label' => 'Votar'])
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $doctrine->getManager();
            $entityManager->persist($voto);
            $entityManager->flush();
            return $this->render('/concurso/peliculaVotos.html.twig', ['id' => $id, 'votos' => $concurso->calcularVotosPorPelicula(), 'concurso' => $concurso, 'peliculaGanadora' => $concurso->calcularPeliculaGanadora()]);
        }

        return $this->render('/concurso/peliculaGanadora.html.twig', ['id' => $id, 'concurso' => $concurso, 'form' => $form->createView()]);
    }

    /**
     * @Route("/concurso/serie/voto/{id}", name="app_voto_series")
     */
    public function votarSerie(ManagerRegistry $doctrine, Request $request, $id): Response
    {
        $concurso_serieRepository = new ConcursoSeriesRepository($doctrine);
        $concurso = $concurso_serieRepository->findOneBy(['id' => $id]);
        $choices = $concurso->getSeries();
        $voto = new VotoSerie();
        $voto->setConcurso($concurso);
        $form = $this->createFormBuilder($voto)
            ->add('serieVotada', EntityType::class, ['class' => Serie::class, 'choices' => $choices, "multiple" => false, 'expanded' => true, 'choice_label' => 'titulo', 'label' => 'Títulos de series'])
            ->add('save', SubmitType::class, ['label' => 'Votar'])
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $doctrine->getManager();
            $entityManager->persist($voto);
            $entityManager->flush();
            return $this->render('/concurso/peliculaVotos.html.twig', ['id' => $id, 'votos' => $concurso->calcularVotosPorSerie(), 'concurso' => $concurso, 'serieGanadora' => $concurso->calcularSerieGanadora()]);
        }

        return $this->render('/concurso/serieGanadora.html.twig', ['id' => $id, 'concurso' => $concurso, 'form' => $form->createView()]);
    }

    /**
     * @Route("/concurso/videojuego/voto/{id}", name="app_voto_videojuegos")
     */
    public function votarJuego(ManagerRegistry $doctrine, Request $request, $id): Response
    {
        $concurso_videojuegoRepository = new ConcursoVideojuegosRepository($doctrine);
        $concurso = $concurso_videojuegoRepository->findOneBy(['id' => $id]);
        $choices = $concurso->getVideojuegos();
        $voto = new VotoVideojuego();
        $voto->setConcurso($concurso);
        $form = $this->createFormBuilder($voto)
            ->add('videojuego', EntityType::class, ['class' => Videojuego::class, 'choices' => $choices, "multiple" => false, 'expanded' => true, 'choice_label' => 'titulo', 'label' => 'Títulos de juegos'])
            ->add('save', SubmitType::class, ['label' => 'Votar'])
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $doctrine->getManager();
            $entityManager->persist($voto);
            $entityManager->flush();
            return $this->render('/concurso/peliculaVotos.html.twig', ['id' => $id, 'votos' => $concurso->calcularVotosPorJuego(), 'concurso' => $concurso, 'juegoGanador' => $concurso->calcularJuegoGanador()]);
        }

        return $this->render('/concurso/juegoGanador.html.twig', ['id' => $id, 'concurso' => $concurso, 'form' => $form->createView()]);
    }

    /**
     * @Route("/concurso/cancion/voto/{id}", name="app_voto_musica")
     */
    public function votarCancion(ManagerRegistry $doctrine, Request $request, $id): Response
    {
        $concurso_cancionRepository = new ConcursoCancionesRepository($doctrine);
        $concurso = $concurso_cancionRepository->findOneBy(['id' => $id]);
        $choices = $concurso->getCanciones();
        $voto = new VotoCancion();
        $voto->setConcurso($concurso);
        $form = $this->createFormBuilder($voto)
            ->add('cancion', EntityType::class, ['class' => Cancion::class, 'choices' => $choices, "multiple" => false, 'expanded' => true, 'choice_label' => 'nombre', 'label' => 'Nombres de canciones'])
            ->add('save', SubmitType::class, ['label' => 'Votar'])
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $doctrine->getManager();
            $entityManager->persist($voto);
            $entityManager->flush();
            return $this->render('/concurso/peliculaVotos.html.twig', ['id' => $id, 'votos' => $concurso->calcularVotosPorCancion(), 'concurso' => $concurso, 'cancionGanadora' => $concurso->calcularCancionGanadora()]);
        }

        return $this->render('/concurso/cancionGanadora.html.twig', ['id' => $id, 'concurso' => $concurso, 'form' => $form->createView()]);
    }

    /**
     * @Route("/concurso/pelicula/votos/{id}", name="app_concurso_pelicula_votos")
     */
    public function peliculaVotos(ManagerRegistry $doctrine, Request $request, $id)
    {
        $concurso_peliculaRepository = new ConcursoPeliculasRepository($doctrine);
        $concurso = $concurso_peliculaRepository->findOneBy(['id' => $id]);
        $peliculaGanadora = $concurso->calcularPeliculaGanadora();
        $votos = $concurso->calcularVotosPorPelicula();
        return $this->render('/concurso/peliculaVotos.html.twig', ['id' => $id, 'votos' => $votos, 'concurso' => $concurso, 'peliculaGanadora' => $peliculaGanadora]);
    }

    /**
     * @Route("/concurso/serie/votos/{id}", name="app_concurso_serie_votos")
     */
    public function serieVotos(ManagerRegistry $doctrine, Request $request, $id)
    {
        $concurso_serieRepository = new ConcursoSeriesRepository($doctrine);
        $concurso = $concurso_serieRepository->findOneBy(['id' => $id]);
        $serieGanadora = $concurso->calcularSerieGanadora();
        $votos = $concurso->calcularVotosPorSerie();
        return $this->render('/concurso/serieVotos.html.twig', ['id' => $id, 'concurso' => $concurso, 'votos' => $votos, 'serieGanadora' => $serieGanadora]);
    }

    /**
     * @Route("/concurso/videojuego/votos/{id}", name="app_concurso_videojuego_votos")
     */
    public function juegoVotos(ManagerRegistry $doctrine, Request $request, $id)
    {
        $concurso_videojuegoRepository = new ConcursoVideojuegosRepository($doctrine);
        $concurso = $concurso_videojuegoRepository->findOneBy(['id' => $id]);
        $juegoGanador = $concurso->calcularJuegoGanador();
        $votos = $concurso->calcularVotosPorJuego();
        return $this->render('/concurso/videojuegoVotos.html.twig', ['id' => $id, 'concurso' => $concurso, 'votos' => $votos, 'juegoGanador' => $juegoGanador]);
    }

    /**
     * @Route("/concurso/musica/votos/{id}", name="app_concurso_musica_votos")
     */
    public function musicaVotos(ManagerRegistry $doctrine, Request $request, $id)
    {
        $concurso_cancionRepository = new ConcursoCancionesRepository($doctrine);
        $concurso = $concurso_cancionRepository->findOneBy(['id' => $id]);
        $votos = $concurso->calcularVotosPorCancion();
        $cancionGanadora = $concurso->calcularCancionGanadora();
        return $this->render('/concurso/musicaVotos.html.twig', ['id' => $id, 'concurso' => $concurso, 'votos' => $votos, 'cancionGanadora' => $cancionGanadora]);
    }

    /**
     * @Route("/concurso/serie/edit/{id}", name="app_concurso_serie_edit")
     */
    public function seriesEdit(ManagerRegistry $doctrine, Request $request, $id): Response
    {
        $concurso_serieRepository = new ConcursoSeriesRepository($doctrine);
        $concurso = $concurso_serieRepository->findOneBy(['id' => $id]);
        $form = $this->createForm(ConcursoSeriesType::class, $concurso);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $doctrine->getManager();
            $entityManager->persist($concurso);
            $entityManager->flush();
            return $this->render('/concurso/modified.html.twig', []);
        }

        return $this->render('/concurso/serieEdit.html.twig', ['id' => $id, 'concurso' => $concurso, 'form' => $form->createView()]);
    }

    /**
     * @Route("/concurso/serie/check/{id}", name="app_concurso_serie_check")
     */
    public function seriesCheck(ManagerRegistry $doctrine, $id): Response
    {
        $concurso_serieRepository = new ConcursoSeriesRepository($doctrine);
        $concurso = $concurso_serieRepository->findOneBy(['id' => $id]);

        return $this->render('/concurso/serieDelete.html.twig', ['concurso' => $concurso]);
    }

    /**
     * @Route("/concurso/serie/delete/{id}", name="app_concurso_serie_delete")
     */
    public function seriesDelete(ManagerRegistry $doctrine, $id): Response
    {
        $concurso_serieRepository = new ConcursoSeriesRepository($doctrine);
        $concurso = $concurso_serieRepository->findOneBy(['id' => $id]);

        if ($concurso && $concurso !== null) {
            $entityManager = $doctrine->getManager();
            $entityManager->remove($concurso);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_concurso');
    }

    /**
     * @Route("/concurso/cancion/delete/{id}", name="app_concurso_cancion_delete")
     */
    public function cancionesDelete(ManagerRegistry $doctrine, $id): Response
    {
        $concurso_cancionRepository = new ConcursoCancionesRepository($doctrine);
        $concurso = $concurso_cancionRepository->findOneBy(['id' => $id]);

        if ($concurso && $concurso !== null) {
            $entityManager = $doctrine->getManager();
            $entityManager->remove($concurso);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_concurso');
    }

    /**
     * @Route("/concurso/pelicula/delete/{id}", name="app_concurso_pelicula_delete")
     */
    public function peliculasDelete(ManagerRegistry $doctrine, $id): Response
    {
        $concurso_peliculaRepository = new ConcursoPeliculasRepository($doctrine);
        $concurso = $concurso_peliculaRepository->findOneBy(['id' => $id]);

        if ($concurso && $concurso !== null) {
            $entityManager = $doctrine->getManager();
            $entityManager->remove($concurso);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_concurso');
    }

    /**
     * @Route("/concurso/videojuego/delete/{id}", name="app_concurso_videojuego_delete")
     */
    public function videojuegosDelete(ManagerRegistry $doctrine, $id): Response
    {
        $concurso_videojuegoRepository = new ConcursoVideojuegosRepository($doctrine);
        $concurso = $concurso_videojuegoRepository->findOneBy(['id' => $id]);

        if ($concurso && $concurso !== null) {
            $entityManager = $doctrine->getManager();
            $entityManager->remove($concurso);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_concurso');
    }

    /**
     * @Route("/concurso/pelicula/edit/{id}", name="app_concurso_pelicula_edit")
     */
    public function peliculasEdit(ManagerRegistry $doctrine, Request $request, $id): Response
    {
        $concurso_peliculaRepository = new ConcursoPeliculasRepository($doctrine);
        $concurso = $concurso_peliculaRepository->findOneBy(['id' => $id]);
        $form = $this->createForm(ConcursoPeliculasType::class, $concurso);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $doctrine->getManager();
            $entityManager->persist($concurso);
            $entityManager->flush();
            return $this->render('/concurso/modified.html.twig', []);
        }

        return $this->render('/concurso/peliculaEdit.html.twig', ['id' => $id, 'concurso' => $concurso, 'form' => $form->createView()]);
    }

    /**
     * @Route("/concurso/pelicula/check/{id}", name="app_concurso_pelicula_check")
     */
    public function peliculasCheck(ManagerRegistry $doctrine, $id): Response
    {
        $concurso_peliculaRepository = new ConcursoPeliculasRepository($doctrine);
        $concurso = $concurso_peliculaRepository->findOneBy(['id' => $id]);

        return $this->render('/concurso/peliculaDelete.html.twig', ['concurso' => $concurso]);
    }

    /**
     * @Route("/concurso/videojuego/edit/{id}", name="app_concurso_videojuego_edit")
     */
    public function videojuegosEdit(ManagerRegistry $doctrine, Request $request, $id): Response
    {
        $concurso_videojuegoRepository = new ConcursoVideojuegosRepository($doctrine);
        $concurso = $concurso_videojuegoRepository->findOneBy(['id' => $id]);
        $form = $this->createForm(ConcursoVideojuegosType::class, $concurso);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $doctrine->getManager();
            $entityManager->persist($concurso);
            $entityManager->flush();
            return $this->render('/concurso/modified.html.twig', []);
        }

        return $this->render('concurso/videojuegoEdit.html.twig', ['id' => $id, 'concurso' => $concurso, 'form' => $form->createView()]);
    }

    /**
     * @Route("/concurso/videojuego/check/{id}", name="app_concurso_videojuego_check")
     */
    public function videojuegosCheck(ManagerRegistry $doctrine, $id): Response
    {
        $concurso_videojuegoRepository = new ConcursoVideojuegosRepository($doctrine);
        $concurso = $concurso_videojuegoRepository->findOneBy(['id' => $id]);

        return $this->render('/concurso/videojuegoDelete.html.twig', ['concurso' => $concurso]);
    }

    /**
     * @Route("/concurso/cancion/edit/{id}", name="app_concurso_cancion_edit")
     */
    public function cancionesEdit(ManagerRegistry $doctrine, Request $request, $id): Response
    {
        $concurso_cancionRepository = new ConcursoCancionesRepository($doctrine);
        $concurso = $concurso_cancionRepository->findOneBy(['id' => $id]);
        $form = $this->createForm(ConcursoCancionesType::class, $concurso);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $doctrine->getManager();
            $entityManager->persist($concurso);
            $entityManager->flush();
            return $this->render('/concurso/modified.html.twig', []);
        }

        return $this->render('concurso/cancionEdit.html.twig', ['id' => $id, 'concurso' => $concurso, 'form' => $form->createView()]);
    }

    /**
     * @Route("/concurso/cancion/check/{id}", name="app_concurso_cancion_check")
     */
    public function cancionesCheck(ManagerRegistry $doctrine, $id): Response
    {
        $concurso_cancionRepository = new ConcursoCancionesRepository($doctrine);
        $concurso = $concurso_cancionRepository->findOneBy(['id' => $id]);

        return $this->render('/concurso/cancionDelete.html.twig', ['concurso' => $concurso]);
    }
}
