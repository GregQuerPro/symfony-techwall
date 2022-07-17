<?php

namespace App\Controller;

use App\Entity\Property;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(ManagerRegistry $registry): Response
    {
        $repository = $registry->getRepository(Property::class);
        $properties = $repository->findLatest();
        return $this->render('home/index.html.twig', [
            'properties' => $properties,
        ]);
    }
}
