<?php

namespace App\Controller;

use App\Entity\Experience;
use App\Form\ExperienceType;
use App\Repository\ExperienceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/{_locale<%app.supported_locales%>}/experience')]
class ExperienceController extends AbstractController
{
    #[Route('/', name: 'app_experience', methods: ['GET'])]
    public function showAll(ExperienceRepository $exRep): Response
    {
        return $this->render('experience/list.html.twig',
        ['experiences'=>$exRep->findAll()]);
    }

    #[Route('/{id}', name: 'app_experience_details', requirements:['id'=>'\d+'], methods: ['GET'])]
    public function details($id, ExperienceRepository $repo): Response
    {
        $experience=$repo->find($id);
        if(!$experience){
            throw $this->createNotFoundException();
        }
        return $this->render('experience/details.html.twig', ['experience'=>$experience]);
    }

    #[Route('/add', name: 'app_experience_new', methods: ['GET','POST'])]
    public function add(Request $request, EntityManagerInterface $em): Response
    {
        $experience= new Experience();
        $form= $this->createForm(ExperienceType::class, $experience);
        $form->handleRequest($request);
        if($form->isSubmitted( ) && $form->isValid()){
            $em->persist($experience);
            $em->flush();
            $this->addFlash('success', 'The experience '. $experience->getTitle(). ' has benn added');
            return $this->redirectToRoute('app_experience',[], Response::HTTP_SEE_OTHER);
        }
        $viewForm= $form->createView();
        return $this->render('experience/add.html.twig', compact('viewForm'));
    }

    #[Route('/{id}/edit', name: 'app_experience_edit', requirements:['id'=>'\d+'], methods: ['GET', 'POST'])]
    public function edit(Request $request, Experience $experience, ExperienceRepository $exRep): Response
    {
        $viewForm= $this->createForm(ExperienceType::class, $experience);
        $viewForm->handleRequest($request);
        if($viewForm->isSubmitted( ) && $viewForm->isValid()){
            $exRep->add($experience);
            return $this->redirectToRoute('app_experience',[], Response::HTTP_SEE_OTHER);
        }
        return $this->renderForm('experience/edit.html.twig', compact('experience', 'viewForm'));
    }


    #[Route('/{id}/delete', name: 'app_experience_delete', requirements:['id'=>'\d+'], methods: ['POST'])]
    public function delete(Experience $experience, ExperienceRepository $exRep): Response
    {
        //PENSER à RAJOUTER SEASURF
            $exRep->remove($experience);

        return $this->redirectToRoute('app_experience', [], Response::HTTP_SEE_OTHER);
    }
}
