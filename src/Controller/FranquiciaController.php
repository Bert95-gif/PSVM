<?php

namespace App\Controller;

use App\Entity\Franquicia;
use App\Form\FranquiciaType;
use App\Repository\FranquiciaRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FranquiciaController extends AbstractController
{
    /**
     * @Route("/franquicia", name="app_franquicia")
     */
    public function index(ManagerRegistry $doctrine): Response
    {
        $franquiciaRepository = new FranquiciaRepository($doctrine);
        $franquicias = $franquiciaRepository->findAll();

        return $this->render('franquicia/index.html.twig', array('franquicias' => $franquicias));
    }

    /**
     * @Route("/franquicia/new", name="app_franquicia_new")
     */
    public function new(ManagerRegistry $doctrine, Request $request): Response
    {
        $franquicia = new Franquicia();
        $form = $this->createForm(FranquiciaType::class, $franquicia);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $doctrine->getManager();
            $entityManager->persist($franquicia);
            $entityManager->flush();
            return $this->render('/franquicia/confirm.html.twig', ['franquicia' => $franquicia]);
        }

        return $this->render('franquicia/new.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/franquicia/edit/{id}", name="app_franquicia_edit")
     */
    public function edit(ManagerRegistry $doctrine, Request $request, $id): Response
    {
        $franquiciaRepository = new FranquiciaRepository($doctrine);
        $franquicia = $franquiciaRepository->findOneBy(['id' => $id]);
        $form = $this->createForm(FranquiciaType::class, $franquicia);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $doctrine->getManager();
            $entityManager->persist($franquicia);
            $entityManager->flush();
            return $this->render('/franquicia/modified.html.twig', ['franquicia' => $franquicia]);
        }

        return $this->render('franquicia/edit.html.twig', ['form' => $form->createView(), 'franquicia' => $franquicia]);
    }

    /**
     * @Route("/franquicia/check/{id}", name="app_franquicia_check")
     */
    public function check(ManagerRegistry $doctrine, $id): Response
    {
        $franquiciaRepository = new FranquiciaRepository($doctrine);
        $franquicia = $franquiciaRepository->findOneBy(['id' => $id]);

        return $this->render('/franquicia/delete.html.twig', ['franquicia' => $franquicia]);
    }

    /**
     * @Route("/franquicia/delete/{id}", name="app_franquicia_delete")
     */
    public function delete(ManagerRegistry $doctrine, $id): Response
    {
        $franquiciaRepository = new FranquiciaRepository($doctrine);
        $franquicia = $franquiciaRepository->findOneBy(['id' => $id]);

        if ($franquicia && $franquicia !== null) {
            $entityManager = $doctrine->getManager();
            $entityManager->remove($franquicia);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_franquicia');
    }
}
