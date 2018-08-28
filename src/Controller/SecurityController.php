<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="security_login")
     */
    public function login(AuthenticationUtils $utils): Response
    {
        return $this->render('security/login.html.twig', [
            // last username entered by the user (if any)
            'last_username' => $utils->getLastUsername(),
            // last authentication error (if any)
            'error' => $utils->getLastAuthenticationError(),
        ]);
    }

    /**
     * @Route("/logout", name="security_logout")
     * @throws \Exception
     *
     */
    public function logout(): void
    {
        throw new \Exception('This should never be reached!');
    }
}
