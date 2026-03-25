<?php

namespace App\Controller;

use App\Entity\Bike;
use App\Form\BikeType;
use App\Repository\BikeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

#[Route('/bike')]
final class BikeController extends AbstractController
{
    #[Route(name: 'app_bike_index', methods: ['GET'])]
    public function index(BikeRepository $bikeRepository): Response
    {
        return $this->render('bike/index.html.twig', [
            'bikes' => $bikeRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_bike_new', methods: ['GET', 'POST'])]
    public function new(
        Request $request,
        //nettoyage du texte pour le rendre sur
        SluggerInterface $slugger,

        //injecte automatiquement une valeur dans la function
        #[Autowire('%kernel.project_dir%/public/uploads/photos')] string $photosDirectory,
        EntityManagerInterface $entityManager
    ): Response {
        $bike = new Bike(); //quand je fais ça dans le controller cela execute automatiquement le  __construct()
        $form = $this->createForm(BikeType::class, $bike);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $bike->setUser($this->getUser());

            //Fichier téléchargé $photoFile
            $photoFile = $form->get('photo_url')->getData();

            // Cette condition est nécessaire car le champ 'photo_url' n'est pas obligatoire
            // donc la photo doit être traitée uniquement si un fichier est uploadé
            if ($photoFile) {

                $originalFilename = pathinfo($photoFile->getClientOriginalName(), PATHINFO_FILENAME);

                // Ceci est nécessaire pour inclure le nom du fichier de manière sécurisée dans l'URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $photoFile->guessExtension();

                // Déplacer le fichier vers le dossier où les photos sont stockées
                try {
                    $photoFile->move($photosDirectory, $newFilename);
                } catch (FileException $e) {
                    // Gérer l'exception si quelque chose se passe mal pendant l'upload
                    $this->addFlash('error','Une erreur est survenue lors de l\'upload de la photo.');
                }

                // Met à jour la propriété 'photo_url' pour stocker le nom du fichier
                // à la place de son contenu
                $bike->setPhotoUrl($newFilename);
            }

            // Persister la variable $bike et autres opérations
            $entityManager->persist($bike);
            $entityManager->flush();

            return $this->redirectToRoute('app_bike_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('bike/new.html.twig', [
            'bike' => $bike,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_bike_show', methods: ['GET'])]
    public function show(Bike $bike): Response
    {
        return $this->render('bike/show.html.twig', [
            'bike' => $bike,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_bike_edit', methods: ['GET', 'POST'])]
    public function edit(
        Request $request, 
        Bike $bike, 
        EntityManagerInterface $entityManager,
        SluggerInterface $slugger,
        #[Autowire('%kernel.project_dir%/public/uploads/photos')] string $photosDirectory,
        ): Response
    {
        $form = $this->createForm(BikeType::class, $bike);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
           

            //Fichier téléchargé $photoFile
            $photoFile = $form->get('photo_url')->getData();

            // Cette condition est nécessaire car le champ 'photo_url' n'est pas obligatoire
            // donc la photo doit être traitée uniquement si un fichier est uploadé
            if ($photoFile) {

                $originalFilename = pathinfo($photoFile->getClientOriginalName(), PATHINFO_FILENAME);
            
                // Ceci est nécessaire pour inclure le nom du fichier de manière sécurisée dans l'URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $photoFile->guessExtension();


                // Déplacer le fichier vers le dossier où les photos sont stockées
                try {
                    $photoFile->move($photosDirectory, $newFilename);
                } catch (FileException $e) {
                    // Gérer l'exception si quelque chose se passe mal pendant l'upload
                    $this->addFlash('error','Une erreur est survenue lors de l\'upload de la photo.');
                }

                // Met à jour la propriété 'photo_url' pour stocker le nom du fichier
                // à la place de son contenu
                $bike->setPhotoUrl($newFilename);
            }

            $entityManager->flush();

            return $this->redirectToRoute('app_bike_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('bike/edit.html.twig', [
            'bike' => $bike,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_bike_delete', methods: ['POST'])]
    public function delete(Request $request, Bike $bike, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $bike->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($bike);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_bike_index', [], Response::HTTP_SEE_OTHER);
    }
}
