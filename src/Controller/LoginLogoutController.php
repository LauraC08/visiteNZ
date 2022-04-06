<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

#[Route('/{_locale<%app.supported_locales%>}')]
class LoginLogoutController extends AbstractController
{
    #[Route('/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        $errors= $authenticationUtils->getLastAuthenticationError();
        return $this->render('login_logout/login.html.twig', compact('errors'));
    }
    #[Route('/logout', name: 'app_logout')]
    public function logout(): Response
    {
//        return $this->render('login_logout/login.html.twig', [
//            'controller_name' => 'LoginLogoutController',
//        ]);
    }
}
