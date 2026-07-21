<?php

namespace App\Controller;

use App\Entity\Emprunt;
use App\Form\EmpruntType;
use App\Repository\EmpruntRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/emprunt')]
final class EmpruntController extends AbstractController
{
    #[Route(name: 'app_emprunt_index', methods: ['GET'])]
    public function index(EmpruntRepository $empruntRepository): Response
    {
        return $this->render('emprunt/index.html.twig', [
            'emprunts' => $empruntRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_emprunt_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $emprunt = new Emprunt();
        $form = $this->createForm(EmpruntType::class, $emprunt);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $livre = $emprunt->getLivre();

            // 1. Vérification : le livre est-il déjà emprunté ?
            if ($livre && !$livre->isEstDisponible()) {
                $this->addFlash('danger', 'Ce livre est actuellement indisponible.');
                return $this->render('emprunt/new.html.twig', [
                    'emprunt' => $emprunt,
                    'form' => $form,
                ]);
            }

            // 2. Automatique : marquer le livre comme indisponible
            if ($livre) {
                $livre->setEstDisponible(false);
            }

            $entityManager->persist($emprunt);
            $entityManager->flush();

            $this->addFlash('success', 'Emprunt enregistré avec succès.');
            return $this->redirectToRoute('app_emprunt_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('emprunt/new.html.twig', [
            'emprunt' => $emprunt,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_emprunt_show', methods: ['GET'])]
    public function show(Emprunt $emprunt): Response
    {
        return $this->render('emprunt/show.html.twig', [
            'emprunt' => $emprunt,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_emprunt_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Emprunt $emprunt, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(EmpruntType::class, $emprunt);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // 3. Automatique : si la date de retour effective est renseignée, le livre redevient disponible
            if ($emprunt->getDateRetourEffective() !== null && $emprunt->getLivre()) {
                $emprunt->getLivre()->setEstDisponible(true);
            }

            $entityManager->flush();

            $this->addFlash('success', 'Emprunt mis à jour.');
            return $this->redirectToRoute('app_emprunt_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('emprunt/edit.html.twig', [
            'emprunt' => $emprunt,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_emprunt_delete', methods: ['POST'])]
    public function delete(Request $request, Emprunt $emprunt, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$emprunt->getId(), $request->getPayload()->getString('_token'))) {
            // 4. Si l'emprunt est supprimé, on remet le livre en disponible
            if ($emprunt->getLivre()) {
                $emprunt->getLivre()->setEstDisponible(true);
            }

            $entityManager->remove($emprunt);
            $entityManager->flush();
            $this->addFlash('danger', 'Emprunt supprimé.');
        }

        return $this->redirectToRoute('app_emprunt_index', [], Response::HTTP_SEE_OTHER);
    }
}