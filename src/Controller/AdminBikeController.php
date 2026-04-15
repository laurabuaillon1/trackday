<?php

namespace App\Controller;

use App\Entity\Bike;
use App\Form\Bike1Type;
use App\Repository\BikeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

#[IsGranted('ROLE_ADMIN')]
#[Route('/admin/bike')]
final class AdminBikeController extends AbstractController
{
    #[Route(name: 'app_admin_bike_index', methods: ['GET'])]
    public function index(BikeRepository $bikeRepository): Response
    {
        return $this->render('admin_bike/index.html.twig', [
            'bikes' => $bikeRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_admin_bike_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, SluggerInterface $slugger, #[Autowire('%kernel.project_dir%/public/uploads/photos')] string $receiptDirectory): Response
    {
        $bike = new Bike();
        $form = $this->createForm(Bike1Type::class, $bike);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // Récupérer le fichier depuis le formulaire
            $photoFile = $form->get('photo_url')->getData();

            //Générer un nom unique pour le fichier
            if ($photoFile) {
                $originalFilename = pathinfo($photoFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $photoFile->guessExtension();

                // Déplacer le fichier vers le dossier où les photos sont stockées
                try {
                    $photoFile->move($receiptDirectory, $newFilename);
                } catch (FileException $e) {
                    $this->addFlash('error','Une erreur est survenue lors de l\'upload de la photo.');
                }

                $bike->setPhotoUrl($newFilename);
            }

            $entityManager->persist($bike);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_bike_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin_bike/new.html.twig', [
            'bike' => $bike,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_bike_show', methods: ['GET'])]
    public function show(Bike $bike): Response
    {
        return $this->render('admin_bike/show.html.twig', [
            'bike' => $bike,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_bike_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Bike $bike, EntityManagerInterface $entityManager,SluggerInterface $slugger, #[Autowire('%kernel.project_dir%/public/uploads/photos')] string $receiptDirectory): Response
    {
        $form = $this->createForm(Bike1Type::class, $bike);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Récupérer le fichier depuis le formulaire
            $photoFile = $form->get('photo_url')->getData();

            //Générer un nom unique pour le fichier
            if ($photoFile) {
                $originalFilename = pathinfo($photoFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $photoFile->guessExtension();

                // Déplacer le fichier vers le dossier où les photos sont stockées
                try {
                    $photoFile->move($receiptDirectory, $newFilename);
                } catch (FileException $e) {
                    // Gérer l'exception si quelque chose se passe mal pendant l'upload
                    $this->addFlash('error','Une erreur est survenue lors de l\'upload de la photo.');
                }

                $bike->setPhotoUrl($newFilename);
            }

            $entityManager->flush();

            return $this->redirectToRoute('app_admin_bike_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin_bike/edit.html.twig', [
            'bike' => $bike,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_bike_delete', methods: ['POST'])]
    public function delete(Request $request, Bike $bike, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $bike->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($bike);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_admin_bike_index', [], Response::HTTP_SEE_OTHER);
    }
}
