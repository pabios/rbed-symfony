<?php

namespace App\Controller;

use App\Entity\Adresse;
use App\Entity\Houssing;
use App\Form\HoussingType;
use App\Repository\HoussingRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/houssing')]
class HoussingController extends AbstractController
{
    #[Route('/', name: 'app_houssing_index', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $houssings = $entityManager
            ->getRepository(Houssing::class)
            ->findAll();

        return $this->render('houssing/index.html.twig', [
            'houssings' => $houssings,
        ]);
    }

    #[Route('/new', name: 'app_houssing_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $houssing = new Houssing();

        $form = $this->createForm(HoussingType::class, $houssing);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $houssing->setUser($this->getUser());
            $adresse = new Adresse();
            $adresse->setCity($form->get('city')->getData());
            $houssing->setAdresse($adresse);
            $adresse->setCountry('France');
            $adresse->setRue(12);
            
            $entityManager->persist($adresse);
            $entityManager->persist($houssing);
            $entityManager->flush();

            return $this->redirectToRoute('app_houssing_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('houssing/new.html.twig', [
            'houssing' => $houssing,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_houssing_show', methods: ['GET'])]
    public function show(Houssing $houssing): Response
    {
        return $this->render('houssing/show.html.twig', [
            'houssing' => $houssing,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_houssing_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Houssing $houssing, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(HoussingType::class, $houssing);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_houssing_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('houssing/edit.html.twig', [
            'houssing' => $houssing,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_houssing_delete', methods: ['POST'])]
    public function delete(Request $request, Houssing $houssing, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$houssing->getId(), $request->request->get('_token'))) {
            $entityManager->remove($houssing);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_houssing_index', [], Response::HTTP_SEE_OTHER);
    }
}
