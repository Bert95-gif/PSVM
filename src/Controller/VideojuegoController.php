<?php

namespace App\Controller;

use App\Entity\Videojuego;
use App\Form\VideojuegoType;
use App\Repository\VideojuegoRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class VideojuegoController extends AbstractController
{
    /**
     * @Route("/videojuego", name="app_videojuego")
     */
    public function index(ManagerRegistry $doctrine): Response
    {
        $videojuegoRepository = new VideojuegoRepository($doctrine);
        $juegos = $videojuegoRepository->findAll();
        return $this->render('videojuego/index.html.twig', array('juegos' => $juegos));
    }

    /**
     * @Route("/videojuego/new", name="app_videojuego_new")
     */
    public function new(ManagerRegistry $doctrine, Request $request): Response
    {
        $juego = new Videojuego();
        $form = $this->createForm(VideojuegoType::class, $juego);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $doctrine->getManager();
            $entityManager->persist($juego);
            if ($juego->getCalificacion() < 7 && $juego->getCalificacion() > 3) {
                $juego->setCalificacion(3);
            }
            if ($juego->getCalificacion() < 12 && $juego->getCalificacion() > 7) {
                $juego->setCalificacion(7);
            }
            if ($juego->getCalificacion() < 16 && $juego->getCalificacion() > 12) {
                $juego->setCalificacion(12);
            }
            if ($juego->getCalificacion() < 18 && $juego->getCalificacion() > 16) {
                $juego->setCalificacion(18);
            }
            $entityManager->flush();
            return $this->render('/videojuego/confirm.html.twig', ['juego' => $juego]);
        }

        return $this->render('videojuego/new.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/videojuego/show/{id}", name="app_videojuego_show")
     */
    public function show(ManagerRegistry $doctrine, $id): Response
    {
        $videojuegoRepository = new VideojuegoRepository($doctrine);
        $videojuego = $videojuegoRepository->findOneBy(['id' => $id]);

        return $this->render('/videojuego/show.html.twig', ['juego' => $videojuego]);
    }

    /**
     * @Route("/videojuego/check/{id}", name="app_videojuego_check")
     */
    public function check(ManagerRegistry $doctrine, $id): Response
    {
        $videojuegoRepository = new VideojuegoRepository($doctrine);
        $videojuego = $videojuegoRepository->findOneBy(['id' => $id]);

        return $this->render('/videojuego/delete.html.twig', ['juego' => $videojuego]);
    }

    /**
     * @Route("/videojuego/edit/{id}", name="app_videojuego_edit")
     */
    public function edit(ManagerRegistry $doctrine, Request $request, $id): Response
    {
        $videojuegoRepository = new VideojuegoRepository($doctrine);
        $videojuego = $videojuegoRepository->findOneBy(['id' => $id]);
        $form = $this->createForm(VideojuegoType::class, $videojuego);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $doctrine->getManager();
            $entityManager->persist($videojuego);
            $entityManager->flush();
            return $this->render('/videojuego/modified.html.twig', ['juego' => $videojuego]);
        }

        return $this->render('/videojuego/edit.html.twig', ['id' => $id, 'juego' => $videojuego, 'form' => $form->createView()]);
    }

    /**
     * @Route("/videojuego/delete/{id}", name="app_videojuego_delete")
     */
    public function delete(ManagerRegistry $doctrine, $id): Response
    {
        $videojuegoRepository = new VideojuegoRepository($doctrine);
        $videojuego = $videojuegoRepository->findOneBy(['id' => $id]);

        if ($videojuego && $videojuego !== null) {
            $entityManager = $doctrine->getManager();
            $entityManager->remove($videojuego);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_videojuego');
    }
}
