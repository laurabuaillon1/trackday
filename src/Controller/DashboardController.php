<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;


#[IsGranted('ROLE_USER')]
final class DashboardController extends AbstractController
{
    #[Route('/dashboard', name: 'app_dashboard')]
    public function index(): Response
    {

        $this->addFlash('success', 'Bienvenue sur Trackday ! Suivez vos journées de roulages, gérez votre moto, analysez vos temps et progressez à chaque sortie.');

        return $this->render('dashboard/index.html.twig', [
            'controller_name' => 'DashboardController',
        ]);
    }

    #[Route('/admin/dashboard', name:'app_admin_dashboard')]
    public function dashboard():Response{

        $this->addFlash('success','Bienvenue sur votre dashboard Admin');
        
        return $this->render('user/dashboard.html.twig');
    }
}
