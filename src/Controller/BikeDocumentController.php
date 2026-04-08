<?php

namespace App\Controller;

use App\Entity\BikeDocument;
use App\Form\BikeDocumentType;
use App\Repository\BikeDocumentRepository;
use App\Repository\BikeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\String\Slugger\SluggerInterface;

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

    #[Route('/new/{bikeId}', name: 'app_bike_document_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, int $bikeId, BikeRepository $bikeRepository, SluggerInterface $slugger, #[Autowire('%kernel.project_dir%/public/uploads/documents')] string $receiptDirectory,): Response
    {

        //PREPARATION DES DONNEES
        $bikeDocument = new BikeDocument();
        $bike = $bikeRepository->find($bikeId);
        // récupère uniquement les motos de l'utilisateur connecté
        $bikes = $bikeRepository->findBy(['user' => $this->getUser()]);

        // CREATION DU FORMULAIRE
        $form = $this->createForm(BikeDocumentType::class, $bikeDocument, [
            'bikes' => $bikes,
        ]);

        $form->handleRequest($request);

        //LORSQUE LE FORMULAIRE EST ENVOYE ET VALIDE
        if ($form->isSubmitted() && $form->isValid()) {

            // GESTION DU FICHIER UPLOADER
            $receiptFile = $form->get('file_url')->getData();

            if ($receiptFile) {
                $originalname = pathinfo($receiptFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safefilename = $slugger->slug($originalname);
                $newfilename = $safefilename . "." . uniqid() . "." . $receiptFile->getClientOriginalExtension();

                try {
                    $receiptFile->move($receiptDirectory, $newfilename);
                } catch (FileException $e) {
                    $this->addFlash('error', 'Une erreur est survenue lors de l\'upload du fichiers.');
                }

                $bikeDocument->setFileUrl($newfilename);
            }

            //SAUVEGARDE EN BDD
            $bikeDocument->setBike($bike);
            $entityManager->persist($bikeDocument);
            $entityManager->flush();

            return $this->redirectToRoute('app_bike_show', ['id' => $bikeId], Response::HTTP_SEE_OTHER);
        }


        //AFFICHE LE FORMULAIRE
        return $this->render('bike_document/new.html.twig', [
            'bike_document' => $bikeDocument,
            'form' => $form,
            'bike' => $bike,
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
    public function edit(Request $request, BikeDocument $bikeDocument, EntityManagerInterface $entityManager, SluggerInterface $slugger, #[Autowire('%kernel.project_dir%/public/uploads/documents')] string $receiptDirectory): Response
    {
        $form = $this->createForm(BikeDocumentType::class, $bikeDocument);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $receiptFile = $form->get('file_url')->getData();

            if ($receiptFile) {
                $originalname = pathinfo($receiptFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safefilename = $slugger->slug($originalname);
                $newfilename = $safefilename . "." . uniqid() . "." . $receiptFile->getClientOriginalExtension();

                try {
                    $receiptFile->move($receiptDirectory, $newfilename);
                } catch (FileException $e) {
                    $this->addFlash('error', 'Une erreur est survenue lors de l\'upload du fichiers.');
                }

                $bikeDocument->setFileUrl($newfilename);
            }


            $entityManager->flush();

            return $this->redirectToRoute('app_bike_show', ['id' => $bikeDocument->getBike()->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->render('bike_document/edit.html.twig', [
            'bike_document' => $bikeDocument,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_bike_document_delete', methods: ['POST'])]
    public function delete(Request $request, BikeDocument $bikeDocument, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $bikeDocument->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($bikeDocument);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_bike_show', ['id' => $bikeDocument->getBike()->getId()], Response::HTTP_SEE_OTHER);
    }
}
