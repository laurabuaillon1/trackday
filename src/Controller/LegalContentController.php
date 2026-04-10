<?php

namespace App\Controller;

use App\Repository\DocumentLegalRepository;
use App\Repository\DocumentTypeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_USER')]
final class LegalContentController extends AbstractController
{
    #[Route('/legal/{type}', name: 'app_legal_content')]
    public function index(string $type,DocumentLegalRepository $documentLegalRepository,DocumentTypeRepository $documentTypeRepository): Response
    {

        $documentType = $documentTypeRepository->findOneBy(['code'=>$type]);
        $document =$documentLegalRepository->findOneBy([
            'documentType'=>$documentType,
            'isActive'=>true,
        ]);

        return $this->render('legal_content/index.html.twig', [
            'document' => $document,
        ]);
    }
}
