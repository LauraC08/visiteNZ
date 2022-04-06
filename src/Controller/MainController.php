<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ClientType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
//        $translated = $translator->trans('Symfony is great',
//    [],
//    'messages',
//    'fr_FR');
        return $this->render('main/index.html.twig',
        );
    }
    #[Route('/{_locale<%app.supported_locales%>}/contact', name: 'app_contact')]
    public function contact(Request $req, EntityManagerInterface $em): Response
    {
        $user= new User();
        $form= $this->createForm(ClientType::class, $user);
        $form->handleRequest($req);
        if($form->isSubmitted() && $form->isValid()){
            $user->setRoles(['ROLE_USER']);
            $em->persist($user);
            $em->flush();
            $this->addFlash('success', 'Your contact form has been saved. We will contact you very soon.');
            return $this->redirectToRoute('app_contact',[], Response::HTTP_SEE_OTHER);
        }
        $viewForm=$form->createView();
        return $this->render('main/contact.html.twig', compact('viewForm'));
    }
    #[Route('/{_locale<%app.supported_locales%>}/admin/user', name: 'app_admin_user', methods: ['GET'])]
    public function showClients(UserRepository $userRepository): Response
    {
        $clients = $userRepository->findBy(['roles'=>'["ROLE_USER"]']);
        return $this->render('main/user.html.twig', compact('clients'));
    }
}
