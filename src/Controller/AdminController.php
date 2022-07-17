<?php

namespace App\Controller;

use App\Entity\Property;
use App\Form\PropertyType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{

    public function __construct(private ManagerRegistry $registry)
    {
    }

    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        $repository = $this->registry->getRepository(Property::class);
        $properties = $repository->findAll();
        return $this->render('admin/index.html.twig', [
            'properties' => $properties
        ]);
    }

    #[Route("/admin/delete/{id}", name: "admin.delete", methods: ["DELETE"])]
    public function delete(Property $property, Request $request): RedirectResponse
    {
        if ($this->isCsrfTokenValid('delete' . $property->getId(), $request->get('_token'))) {
            $em = $this->registry->getManager();
            $em->remove($property);
            $em->flush();
            $this->addFlash('success', "Le produit a été supprimé avec succès");
        }
        return $this->redirectToRoute('admin');
    }



    #[Route('/admin/new', name: 'admin.new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $property =  new Property;
        $form = $this->createForm(PropertyType::class, $property);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->registry->getManager();
            $em->persist($property);
            $em->flush();
            $this->addFlash('success', "Le produit a été modifié avec succès");
            return $this->redirectToRoute('admin');
        }

        return $this->render('admin/new.html.twig', [
            'property' => $property,
            'form' => $form->createView()
        ]);
    }

    #[Route('/admin/edit/{id}', name: 'admin.edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Property $property): Response
    {
        $form = $this->createForm(PropertyType::class, $property);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->registry->getManager();
            $em->flush();
            $this->addFlash('success', "Le produit a été modifié avec succès");
            return $this->redirectToRoute('admin');
        }

        return $this->render('admin/edit.html.twig', [
            'property' => $property,
            'form' => $form->createView()
        ]);
    }
}
