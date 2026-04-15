<?php

namespace App\Controller;

use App\Entity\BikeMaintenance;
use App\Form\BikeMaintenance1Type;
use App\Repository\BikeMaintenanceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\Security\Http\Attribute\IsGranted;

use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\HttpFoundation\File\Exception\FileException;


#[IsGranted('ROLE_ADMIN')]
#[Route('/admin/maintenance')]
final class AdminBikeMaintenanceController extends AbstractController
{
    #[Route(name: 'app_admin_bike_maintenance_index', methods: ['GET'])]
    public function index(BikeMaintenanceRepository $bikeMaintenanceRepository): Response
    {
        return $this->render('admin_bike_maintenance/index.html.twig', [
            'bike_maintenances' => $bikeMaintenanceRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_admin_bike_maintenance_new', methods: ['GET', 'POST'])]
    public function new(
        Request $request,
        EntityManagerInterface $entityManager,
        SluggerInterface $slugger,
        #[Autowire('%kernel.project_dir%/public/uploads/documents')] string $photosDirectory
    ): Response {
        $bikeMaintenance = new BikeMaintenance();
        $form = $this->createForm(BikeMaintenance1Type::class, $bikeMaintenance);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $receiptFile = $form->get('receipt_url')->getData();

            if ($receiptFile) {
                $originalFile = pathinfo($receiptFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFile = $slugger->slug($originalFile);
                $newFile = $safeFile . '-' . uniqid() . '-' . $receiptFile->getClientOriginalExtension();

                try {
                    $receiptFile->move($photosDirectory, $newFile);
                } catch (FileException $e) {
                    $this->addFlash('error', 'Une erreur est survenue lors de l\'upload du fichiers.');
                }

                $bikeMaintenance->setReceiptUrl($newFile);
            }

            $entityManager->persist($bikeMaintenance);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_bike_maintenance_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin_bike_maintenance/new.html.twig', [
            'bike_maintenance' => $bikeMaintenance,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_bike_maintenance_show', methods: ['GET'])]
    public function show(BikeMaintenance $bikeMaintenance): Response
    {
        return $this->render('admin_bike_maintenance/show.html.twig', [
            'bike_maintenance' => $bikeMaintenance,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_bike_maintenance_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, BikeMaintenance $bikeMaintenance, EntityManagerInterface $entityManager, SluggerInterface $slugger, #[Autowire('%kernel.project_dir%/public/uploads/documents')] string $photosDirectory,): Response
    {
        $form = $this->createForm(BikeMaintenance1Type::class, $bikeMaintenance);
        $form->handleRequest($request);

        // Récupérer le fichier depuis le formulaire
        $receiptFile = $form->get('receipt_url')->getData();

        if ($form->isSubmitted() && $form->isValid()) {

            //Générer un nom unique pour le fichier
            if ($receiptFile) {
                $originalFile = pathinfo($receiptFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFile);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $receiptFile->getClientOriginalExtension();

                // Déplacer le fichier vers le dossier où les photos sont stockées
                try {
                    $receiptFile->move($photosDirectory, $newFilename);
                } catch (FileException $e) {
                    $this->addFlash('error', 'Une erreur est survenue lors de l\'upload de la photo.');
                }
                $bikeMaintenance->setReceiptUrl($newFilename);
            }
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_bike_maintenance_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin_bike_maintenance/edit.html.twig', [
            'bike_maintenance' => $bikeMaintenance,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_bike_maintenance_delete', methods: ['POST'])]
    public function delete(Request $request, BikeMaintenance $bikeMaintenance, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $bikeMaintenance->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($bikeMaintenance);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_admin_bike_maintenance_index', [], Response::HTTP_SEE_OTHER);
    }
}
