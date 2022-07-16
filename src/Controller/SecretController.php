<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SecretController extends AbstractController
{
    #[Route('/secret', name: 'secret')]
    public function index(): Response
    {
        return $this->render('secret/index.html.twig', [
            'controller_name' => 'SecretController',
        ]);
    }
}
