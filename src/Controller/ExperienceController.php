<?php

namespace App\Controller;

use App\Entity\Experience;
use App\Repository\ExperienceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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

//    #[Route('/{id}', name: 'app_experience_show', methods: ['GET'])]
//    public function show(Experience $experience): Response
//    {
//    }

//    #[Route('/add', name: 'app_experience_add')]
//    public function add(Request $request, ExperienceRepository $exRep): Response
//    {
//        $experience= new Experience();
//    }

//    #[Route('/{id}/edit', name: 'app_experience_edit', methods: ['GET', 'POST'])]
//    public function edit(Request $request, Experience $experience, ExperienceRepository $exRep): Response
//    {
//    }


    #[Route('/{id}', name: 'app_experience_delete', methods: ['POST'])]
    public function delete(Experience $experience, ExperienceRepository $exRep): Response
    {
        //PENSER à RAJOUTER SEASURF
            $exRep->remove($experience);

        return $this->redirectToRoute('app_experience', [], Response::HTTP_SEE_OTHER);
    }
}
