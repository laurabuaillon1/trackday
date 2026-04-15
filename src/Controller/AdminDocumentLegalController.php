<?php

namespace App\Controller;

use App\Entity\DocumentLegal;
use App\Form\DocumentLegalType;
use App\Repository\DocumentLegalRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_ADMIN')]
#[Route('/admin/document/legal')]
final class AdminDocumentLegalController extends AbstractController
{
    #[Route(name: 'app_admin_document_legal_index', methods: ['GET'])]
    public function index(DocumentLegalRepository $documentLegalRepository): Response
    {
        return $this->render('admin_document_legal/index.html.twig', [
            'document_legals' => $documentLegalRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_admin_document_legal_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $documentLegal = new DocumentLegal();
        $form = $this->createForm(DocumentLegalType::class, $documentLegal);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($documentLegal);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_document_legal_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin_document_legal/new.html.twig', [
            'document_legal' => $documentLegal,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_document_legal_show', methods: ['GET'])]
    public function show(DocumentLegal $documentLegal): Response
    {
        return $this->render('admin_document_legal/show.html.twig', [
            'document_legal' => $documentLegal,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_document_legal_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, DocumentLegal $documentLegal, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(DocumentLegalType::class, $documentLegal);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_document_legal_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin_document_legal/edit.html.twig', [
            'document_legal' => $documentLegal,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_document_legal_delete', methods: ['POST'])]
    public function delete(Request $request, DocumentLegal $documentLegal, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$documentLegal->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($documentLegal);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_admin_document_legal_index', [], Response::HTTP_SEE_OTHER);
    }
}
