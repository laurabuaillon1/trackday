<?php

namespace App\Controller;

use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Format;


#[IsGranted('ROLE_USER')]
final class AccountController extends AbstractController
{
    #[Route('/account', name: 'app_account', methods: ['GET'])]
    public function index(): Response
    {

        //utilisateur déjà connecté
        $user = $this->getUser();

        return $this->render('account/index.html.twig', [
            'user' => $user,
        ]);
    }


    #[Route('/account/edit', name: 'app_account_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, SluggerInterface $slugger,#[Autowire('%kernel.project_dir%/public/uploads/profiles')] string $photoProfile,EntityManagerInterface $entityManager,UserRepository $userRepository): Response {
        $user = $userRepository->findOneBy(['email' => $this->getUser()->getUserIdentifier()]);

        if ($request->isMethod('POST')) {

            // Texte → récupéré directement depuis les inputs HTML
            $user->setLastName($request->request->get('lastname') ?? '');
            $user->setFirstName($request->request->get('firstname') ?? '');

            // Photo → récupérée depuis les fichiers
            $photoFile = $request->files->get('profile_picture');

            if ($photoFile) {
                $originalFilename = pathinfo($photoFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                // force the extension to webp instead of the original
                $newFilename = $safeFilename . '-' . uniqid() . '.webp';

                try {
                    // move the original file first
                    $photoFile->move($photoProfile, $newFilename);
                    // full path to the saved file
                    $fullpath = $photoProfile . '/' . $newFilename;
                    $manager = new ImageManager(new Driver());
                    $image = $manager->decodePath($fullpath);
                    $image->scaleDown(width: 300);
                    $image->encodeUsingFormat(Format::WEBP, quality: 80)->save($fullpath);
                } catch (FileException $e) {
                    $this->addFlash('error', 'Une erreur est survenue lors de l\'upload de la photo.');
                }
                $user->setProfilePicture($newFilename);
            }

            $entityManager->flush();

            return $this->redirectToRoute('app_account', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('account/edit.html.twig');
    }

    #[Route('/account/delete', name: 'app_account_delete', methods: ['POST'])]
    public function delete(
        Request $request,
        EntityManagerInterface $entityManager,
        TokenStorageInterface $tokenStorage
    ): Response {

        $user = $this->getUser();
        if ($this->isCsrfTokenValid('delete_account', $request->getPayload()->getString('_token'))) {

            //delete security token in memory
            $tokenStorage->setToken(null);
            //delete the session completely (cookies and session data)
            $request->getSession()->invalidate();

            //delete in BDD
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_login', [], Response::HTTP_SEE_OTHER);
    }
}
