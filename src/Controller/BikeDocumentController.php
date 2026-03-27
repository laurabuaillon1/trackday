<?php

namespace App\Controller;

use App\Entity\BikeDocument;
use App\Form\BikeDocumentType;
use App\Repository\BikeDocumentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_USER')]
#[Route('/bike/document')]
final class BikeDocumentController extends AbstractController
{
    #[Route(name: 'app_bike_document_index', methods: ['GET'])]
    public function index(BikeDocumentRepository $bikeDocumentRepository): Response
    {
        return $this->render('bike_document/index.html.twig', [
            'bike_documents' => $bikeDocumentRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_bike_document_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $bikeDocument = new BikeDocument();
        $form = $this->createForm(BikeDocumentType::class, $bikeDocument);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($bikeDocument);
            $entityManager->flush();

            return $this->redirectToRoute('app_bike_document_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('bike_document/new.html.twig', [
            'bike_document' => $bikeDocument,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_bike_document_show', methods: ['GET'])]
    public function show(BikeDocument $bikeDocument): Response
    {
        return $this->render('bike_document/show.html.twig', [
            'bike_document' => $bikeDocument,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_bike_document_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, BikeDocument $bikeDocument, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(BikeDocumentType::class, $bikeDocument);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_bike_document_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('bike_document/edit.html.twig', [
            'bike_document' => $bikeDocument,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_bike_document_delete', methods: ['POST'])]
    public function delete(Request $request, BikeDocument $bikeDocument, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$bikeDocument->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($bikeDocument);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_bike_document_index', [], Response::HTTP_SEE_OTHER);
    }
}
