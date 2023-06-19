<?php

namespace App\Controller;

use App\Entity\Pelicula;
use App\Form\PeliculaType;
use App\Repository\GeneroRepository;
use App\Repository\PeliculaRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PeliculaController extends AbstractController
{
    /**
     * @Route("/pelicula", name="app_pelicula")
     */
    public function index(ManagerRegistry $doctrine): Response
    {
        $peliculaRepository = new PeliculaRepository($doctrine);
        $peliculas = $peliculaRepository->findAll();
        return $this->render('pelicula/index.html.twig', array('peliculas' => $peliculas));
    }

    /**
     * @Route("/pelicula/new", name="app_pelicula_new")
     */
    public function new(ManagerRegistry $doctrine, Request $request): Response
    {
        $generoRepository = new GeneroRepository($doctrine);
        $generos = $generoRepository->findAll();
        $pelicula = new Pelicula();
        $form = $this->createForm(PeliculaType::class, $pelicula);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $doctrine->getManager();
            $entityManager->persist($pelicula);
            $entityManager->flush();
            return $this->render('/pelicula/confirm.html.twig', ['pelicula' => $pelicula]);
        }

        return $this->render('/pelicula/new.html.twig', ['form' => $form->createView(), 'generosPelicula' => $generos]);
    }

    /**
     * @Route("/pelicula/show/{id}", name="app_pelicula_show")
     */
    public function show(ManagerRegistry $doctrine, $id): Response
    {
        $peliculaRepository = new PeliculaRepository($doctrine);
        $pelicula = $peliculaRepository->findOneBy(['id' => $id]);

        return $this->render('/pelicula/show.html.twig', ['pelicula' => $pelicula]);
    }

    /**
     * @Route("/pelicula/edit/{id}", name="app_pelicula_edit")
     */
    public function edit(ManagerRegistry $doctrine, Request $request, $id): Response
    {
        $peliculaRepository = new PeliculaRepository($doctrine);
        $pelicula = $peliculaRepository->findOneBy(['id' => $id]);
        $form = $this->createForm(PeliculaType::class, $pelicula);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $doctrine->getManager();
            $entityManager->persist($pelicula);
            $entityManager->flush();
            return $this->render('/pelicula/modified.html.twig', ['pelicula' => $pelicula]);
        }

        return $this->render('/pelicula/edit.html.twig', ['id' => $id, 'pelicula' => $pelicula, 'form' => $form->createView()]);
    }

    /**
     * @Route("/pelicula/check/{id}", name="app_pelicula_check")
     */
    public function check(ManagerRegistry $doctrine, $id): Response
    {
        $peliculaRepository = new PeliculaRepository($doctrine);
        $pelicula = $peliculaRepository->findOneBy(['id' => $id]);

        return $this->render('/pelicula/delete.html.twig', ['pelicula' => $pelicula]);
    }

    /**
     * @Route("/pelicula/delete/{id}", name="app_pelicula_delete")
     */
    public function delete(ManagerRegistry $doctrine, $id): Response
    {
        $peliculaRepository = new PeliculaRepository($doctrine);
        $pelicula = $peliculaRepository->findOneBy(['id' => $id]);

        if ($pelicula && $pelicula !== null) {
            $entityManager = $doctrine->getManager();
            $entityManager->remove($pelicula);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_pelicula');
    }
}
