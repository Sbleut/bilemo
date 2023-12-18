<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SmartphoneController extends AbstractController
{
    #[Route('/smartphone', name: 'app_smartphone')]
    public function index(): Response
    {
        return $this->render('smartphone/index.html.twig', [
            'controller_name' => 'SmartphoneController',
        ]);
    }
}
