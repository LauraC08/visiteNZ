<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

class MainController extends AbstractController
{
    #[Route('/')]
    public function indexNoLocale(): Response
    {
        return $this->redirectToRoute('app_main', ['_locale' => 'en']);
    }

    #[Route('/{_locale<%app.supported_locales%>}/', name: 'app_main')]
    public function index(TranslatorInterface $translator): Response
    {
        $translated = $translator->trans('Symfony is great',
    [],
    'messages',
    'fr_FR');
        return $this->render('main/index.html.twig',
        ['translated'=> $translated]);
    }
    #[Route('/{_locale<%app.supported_locales%>}/contact', name: 'app_contact')]
    public function contact(): Response
    {
        return $this->render('main/contact.html.twig');
    }
}
