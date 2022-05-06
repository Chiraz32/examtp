<?php

namespace App\Controller;

use App\Entity\Etudiant;
use App\Form\EtudiantFormType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AddEtudiantController extends AbstractController
{
    #[Route('/addetudiant', name: 'app_add_etudiant')]
    public function index(ManagerRegistry $doctrine, Request $request): Response
    {
        $entityManager = $doctrine->getManager();
        $etudiant = new Etudiant();
        $form = $this->createForm(EtudiantFormType::class, $etudiant);

        $form->handleRequest($request);

        $repository=$doctrine->getRepository(Etudiant::class);
        $person=$repository->findAll() ;
        if ($form->isSubmitted()) {

            $entityManager->persist($etudiant);
            $entityManager->flush();


            return $this->render('add_etudiant/info.html.twig', ['user' => $etudiant,'liste' => $person]);
        } else {

            return $this->render('add_etudiant/index.html.twig', [
                'form' => $form->createView(),
            ]);
        }
    }


}
