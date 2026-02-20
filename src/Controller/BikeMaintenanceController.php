<?php

namespace App\Controller;

use App\Entity\BikeMaintenance;
use App\Form\BikeMaintenanceType;
use App\Repository\BikeMaintenanceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/bike/maintenance')]
final class BikeMaintenanceController extends AbstractController
{
    #[Route(name: 'app_bike_maintenance_index', methods: ['GET'])]
    public function index(BikeMaintenanceRepository $bikeMaintenanceRepository): Response
    {
        return $this->render('bike_maintenance/index.html.twig', [
            'bike_maintenances' => $bikeMaintenanceRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_bike_maintenance_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $bikeMaintenance = new BikeMaintenance();
        $form = $this->createForm(BikeMaintenanceType::class, $bikeMaintenance);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($bikeMaintenance);
            $entityManager->flush();

            return $this->redirectToRoute('app_bike_maintenance_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('bike_maintenance/new.html.twig', [
            'bike_maintenance' => $bikeMaintenance,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_bike_maintenance_show', methods: ['GET'])]
    public function show(BikeMaintenance $bikeMaintenance): Response
    {
        return $this->render('bike_maintenance/show.html.twig', [
            'bike_maintenance' => $bikeMaintenance,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_bike_maintenance_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, BikeMaintenance $bikeMaintenance, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(BikeMaintenanceType::class, $bikeMaintenance);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_bike_maintenance_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('bike_maintenance/edit.html.twig', [
            'bike_maintenance' => $bikeMaintenance,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_bike_maintenance_delete', methods: ['POST'])]
    public function delete(Request $request, BikeMaintenance $bikeMaintenance, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$bikeMaintenance->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($bikeMaintenance);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_bike_maintenance_index', [], Response::HTTP_SEE_OTHER);
    }
}
