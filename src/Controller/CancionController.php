<?php

namespace App\Controller;

use App\Entity\Cancion;
use App\Form\CancionType;
use App\Repository\CancionRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CancionController extends AbstractController
{
    /**
     * @Route("/cancion", name="app_cancion")
     */
    public function index(ManagerRegistry $doctrine): Response
    {
        $cancionRepository = new CancionRepository($doctrine);
        $canciones = $cancionRepository->findAll();

        return $this->render(
            'cancion/index.html.twig',
            array('canciones' => $canciones)
        );
    }

    /**
     * @Route("/cancion/new", name="app_cancion_new")
     */
    public function new(ManagerRegistry $doctrine, Request $request): Response
    {
        $cancion = new Cancion();
        $form = $this->createForm(CancionType::class, $cancion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $doctrine->getManager();
            $entityManager->persist($cancion);
            $entityManager->flush();
            return $this->render('/cancion/confirm.html.twig', ['cancion' => $cancion]);
        }

        return $this->render('cancion/new.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/cancion/show/{id}", name="app_cancion_show")
     */
    public function show(ManagerRegistry $doctrine, $id): Response
    {
        $cancionRepository = new CancionRepository($doctrine);
        $cancion = $cancionRepository->findOneBy(['id' => $id]);

        return $this->render('cancion/show.html.twig', ['cancion' => $cancion]);
    }

    /**
     * @Route("/cancion/edit/{id}", name="app_cancion_edit")
     */
    public function edit(ManagerRegistry $doctrine, Request $request, $id): Response
    {
        $cancionRepository = new CancionRepository($doctrine);
        $cancion = $cancionRepository->findOneBy(['id' => $id]);
        $form = $this->createForm(CancionType::class, $cancion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $doctrine->getManager();
            $entityManager->persist($cancion);
            $entityManager->flush();
            return $this->render('/cancion/modified.html.twig', ['cancion' => $cancion]);
        }

        return $this->render('cancion/edit.html.twig', ['form' => $form->createView(), 'cancion' => $cancion]);
    }

    /**
     * @Route("/cancion/check/{id}", name="app_cancion_check")
     */
    public function check(ManagerRegistry $doctrine, $id): Response
    {
        $cancionRepository = new CancionRepository($doctrine);
        $cancion = $cancionRepository->findOneBy(['id' => $id]);

        return $this->render('/cancion/delete.html.twig', ['cancion' => $cancion]);
    }

    /**
     * @Route("/cancion/delete/{id}", name="app_cancion_delete")
     */
    public function delete(ManagerRegistry $doctrine, $id): Response
    {
        $cancionRepository = new CancionRepository($doctrine);
        $cancion = $cancionRepository->findOneBy(['id' => $id]);

        if ($cancion && $cancion !== null) {
            $entityManager = $doctrine->getManager();
            $entityManager->remove($cancion);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_cancion');
    }
}
