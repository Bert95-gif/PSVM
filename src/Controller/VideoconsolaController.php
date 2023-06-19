<?php

namespace App\Controller;

use App\Entity\Videoconsola;
use App\Form\VideoconsolaType;
use App\Repository\VideoconsolaRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class VideoconsolaController extends AbstractController
{
    /**
     * @Route("/consola", name="app_videoconsola")
     */
    public function index(ManagerRegistry $doctrine): Response
    {
        $videoconsolaRepository = new VideoconsolaRepository($doctrine);
        $consolas = $videoconsolaRepository->findAll();
        return $this->render('videoconsola/index.html.twig', array('consolas' => $consolas));
    }

    /**
     * @Route("/consola/new", name="app_videoconsola_new")
     */
    public function new(ManagerRegistry $doctrine, Request $request): Response
    {
        $consola = new Videoconsola();
        $form = $this->createForm(VideoconsolaType::class, $consola);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $doctrine->getManager();
            $entityManager->persist($consola);
            $entityManager->flush();
            return $this->render('/videoconsola/confirm.html.twig', ['consola' => $consola]);
        }

        return $this->render('/videoconsola/new.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/consola/show/{id}", name="app_videoconsola_show")
     */
    public function show(ManagerRegistry $doctrine, $id): Response
    {
        $videoconsolaRepository = new VideoconsolaRepository($doctrine);
        $consola = $videoconsolaRepository->findOneBy(['id' => $id]);

        return $this->render('videoconsola/show.html.twig', ['consola' => $consola]);
    }

    /**
     * @Route("/consola/edit/{id}", name="app_videoconsola_edit")
     */
    public function edit(ManagerRegistry $doctrine, Request $request, $id): Response
    {
        $videoconsolaRepository = new VideoconsolaRepository($doctrine);
        $consola = $videoconsolaRepository->findOneBy(['id' => $id]);
        $form = $this->createForm(VideoconsolaType::class, $consola);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $doctrine->getManager();
            $entityManager->persist($consola);
            $entityManager->flush();
            return $this->render('/videoconsola/modified.html.twig', ['consola' => $consola]);
        }

        return $this->render('videoconsola/edit.html.twig', ['consola' => $consola, 'id' => $id, 'form' => $form->createView()]);
    }

    /**
     * @Route("/consola/check/{id}", name="app_videoconsola_check")
     */
    public function check(ManagerRegistry $doctrine, $id): Response
    {
        $videoconsolaRepository = new VideoconsolaRepository($doctrine);
        $consola = $videoconsolaRepository->findOneBy(['id' => $id]);

        return $this->render('/videoconsola/delete.html.twig', ['consola' => $consola]);
    }

    /**
     * @Route("/consola/delete/{id}", name="app_videoconsola_delete")
     */
    public function delete(ManagerRegistry $doctrine, $id): Response
    {
        $videoconsolaRepository = new VideoconsolaRepository($doctrine);
        $consola = $videoconsolaRepository->findOneBy(['id' => $id]);

        if ($consola && $consola !== null) {
            $entityManager = $doctrine->getManager();
            $entityManager->remove($consola);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_videoconsola');
    }
}
