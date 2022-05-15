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







    #[
        Route('liste/{page<\d+>?1}/{nbre<\d+>?10}', name: 'all_etudiant')
    ]
    public function liste (ManagerRegistry $doctrine, $page, $nbre): Response {
        $repository = $doctrine->getRepository(Etudiant::class);
        $nbPersonne = $repository->count([]);

        $nbrePage = ceil($nbPersonne / $nbre) ;

        $etudiants = $repository->findBy([], [],$nbre, ($page - 1 ) * $nbre);

        return $this->render('add_etudiant/liste.html.twig', [
            'etudiants' => $etudiants,
            'isPaginated' => true,
            'nbrePage' => $nbrePage,
            'page' => $page,
            'nbre' => $nbre
        ]);
    }

    #[Route('/edit/{id?0}', name: 'edit_etudiant')]
    public function addPersonne(Etudiant $etudiant = null, ManagerRegistry $doctrine, Request $request): Response
    {
        $new = false;

        if (!$etudiant) {
            $new = true;
            $etudiant = new Etudiant();
        }


        $form = $this->createForm(EtudiantFormType::class, $etudiant);

        $form->handleRequest($request);

        if($form->isSubmitted()) {
            $manager = $doctrine->getManager();
            $manager->persist($etudiant);

            $manager->flush();

            if($new) {
                $message = " a été ajouté avec succès";
            } else {
                $message = " a été mis à jour avec succès";
            }
            $this->addFlash('success',$etudiant->getNom(). $message );

            return $this->redirectToRoute('all_etudiant');
        } else {

            return $this->render('add_etudiant/index.html.twig', [
                'form' => $form->createView()
            ]);
        }

    }

    #[Route('/delete/{id}', name: 'delete_etudiant')]
    public function deletePersonne(Etudiant $etudiant = null, ManagerRegistry $doctrine): Response {

        if ($etudiant) {

            $manager = $doctrine->getManager();

            $manager->remove($etudiant);

            $manager->flush();
            $this->addFlash('success', "La etudiant a été supprimé avec succès");
        } else {

            $this->addFlash('error', "etudiant non existant");
        }
        return $this->redirectToRoute('all_etudiant');
    }

}
