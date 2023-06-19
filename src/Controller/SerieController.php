<?php

namespace App\Controller;

use App\Entity\Serie;
use App\Form\SerieType;
use App\Repository\SerieRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SerieController extends AbstractController
{
    /**
     * @Route("/serie", name="app_serie")
     */
    public function index(ManagerRegistry $doctrine): Response
    {
        $serieRepository = new SerieRepository($doctrine);
        $series = $serieRepository->findAll();
        return $this->render('serie/index.html.twig', array('series' => $series));
    }

    /**
     * @Route("/serie/new", name="app_serie_new")
     */
    public function new(ManagerRegistry $doctrine, Request $request): Response
    {
        $serie = new Serie();
        $form = $this->createForm(SerieType::class, $serie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $doctrine->getManager();
            $entityManager->persist($serie);
            $entityManager->flush();
            return $this->render('/serie/confirm.html.twig', ['serie' => $serie]);
        }

        return $this->render('/serie/new.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("serie/show/{id}", name="app_serie_show")
     */
    public function show(ManagerRegistry $doctrine, $id): Response
    {
        $serieRepository = new SerieRepository($doctrine);
        $serie = $serieRepository->findOneBy(['id' => $id]);

        return $this->render('/serie/show.html.twig', ['serie' => $serie]);
    }

    /**
     * @Route("/serie/edit/{id}", name="app_serie_edit")
     */
    public function edit(ManagerRegistry $doctrine, Request $request, $id): Response
    {
        $serieRepository = new SerieRepository($doctrine);
        $serie = $serieRepository->findOneBy(['id' => $id]);
        $form = $this->createForm(SerieType::class, $serie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $doctrine->getManager();
            $entityManager->persist($serie);
            $entityManager->flush();
            return $this->render('/serie/modified.html.twig', ['serie' => $serie]);
        }

        return $this->render('/serie/edit.html.twig', ['id' => $id, 'serie' => $serie, 'form' => $form->createView()]);
    }

    /**
     * @Route("/serie/check/{id}", name="app_serie_check")
     */
    public function check(ManagerRegistry $doctrine, $id): Response
    {
        $serieRepository = new SerieRepository($doctrine);
        $serie = $serieRepository->findOneBy(['id' => $id]);

        return $this->render('/serie/delete.html.twig', ['serie' => $serie]);
    }

    /**
     * @Route("/serie/delete/{id}", name="app_serie_delete")
     */
    public function delete(ManagerRegistry $doctrine, $id): Response
    {
        $serieRepository = new SerieRepository($doctrine);
        $serie = $serieRepository->findOneBy(['id' => $id]);

        if ($serie && $serie !== null) {
            $entityManager = $doctrine->getManager();
            $entityManager->remove($serie);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_serie');
    }
}
