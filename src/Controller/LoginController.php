<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LoginController extends AbstractController
{
    /**
     * @Route("/login", name="app_login")
     */
    public function index(AuthenticationUtils $authenticationUtils): Response
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('login/index.html.twig', [
            'controller_name' => 'LoginController',
            'last_username' => $lastUsername,
            'error'         => $error,
        ]);
    }

    /**
     * @Route("/users", name="app_users")
     */
    public function users(ManagerRegistry $doctrine): Response
    {
        $userRepository = new UserRepository($doctrine);
        $users = $userRepository->findAll();
        return $this->render('login/users.html.twig', array('users' => $users));
    }

    /**
     * @Route("/user/new", name="app_user_new")
     */
    public function new(ManagerRegistry $doctrine, Request $request): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $doctrine->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            return $this->render('/login/confirm.html.twig', ['user' => $user]);
        }

        return $this->render('/login/new.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/user/edit/{id}", name="app_user_edit")
     */
    public function edit(ManagerRegistry $doctrine, Request $request, $id): Response
    {
        $userRepository = new UserRepository($doctrine);
        $user = $userRepository->findOneBy(['id' => $id]);
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $doctrine->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            return $this->render('/login/modified.html.twig', ['user' => $user]);
        }

        return $this->render('login/edit.html.twig', ['form' => $form->createView(), 'user' => $user]);
    }

    /**
     * @Route("/user/delete/{id}", name="app_user_delete")
     */
    public function delete(ManagerRegistry $doctrine, $id): Response
    {
        $userRepository = new UserRepository($doctrine);
        $user = $userRepository->findOneBy(['id' => $id]);

        if ($user && $user !== null) {
            $entityManager = $doctrine->getManager();
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_users');
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {
    }
}
