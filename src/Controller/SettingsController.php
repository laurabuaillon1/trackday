<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\BrowserKit\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class SettingsController extends AbstractController
{
    #[Route('/settings', name: 'app_settings',methods:['GET'])]
    public function index(): Response
    {
        return $this->render('settings/index.html.twig', [
        ]);
    }

    #[Route('/settings/update',name: 'app_settings_update',methods:['POST'])]
    public function update(Request $request,EntityManagerInterface $entityManager): Response{
        return $setting;
    }


    #[Route('/settings/delete', name:'app_settings_delete',methods:['POST'])]
    public function delete(Request $request,EntityManagerInterface $entityManager): Response{

    }
}
