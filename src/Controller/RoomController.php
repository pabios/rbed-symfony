<?php

namespace App\Controller;

use App\Entity\Room;
use App\Form\RoomType;
use App\Entity\Houssing;
use App\Repository\RoomRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/room')]
class RoomController extends AbstractController
{
    #[Route('/', name: 'app_room_index', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $rooms = $entityManager
            ->getRepository(Room::class)
            ->findAll();

        return $this->render('room/index.html.twig', [
            'rooms' => $rooms,
        ]);
    }
    #[Route('/{id}/new', name: 'app_room_create', methods: ['GET', 'POST'])]
    public function newRoom(Request $request,Houssing $houssing, EntityManagerInterface $entityManager): Response
    {
        $room = new Room();
        $form = $this->createForm(RoomType::class, $room);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            foreach($room->getRoomDetails() as $rd){
                $rd->setRoom($room);
            }
            $room->setHoussing($houssing);
            $entityManager->persist($room);
            $entityManager->flush();

            return $this->redirectToRoute('app_room_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('room/new2.html.twig', [
            'room' => $room,
            'form' => $form,
        ]);
    }
    #[Route('/{id}/edit', name: 'app_room_edit', methods: ['GET', 'POST'])]
    public function editRoom(EntityManagerInterface $em, Room $room, Request $request, RoomRepository $roomRepository): Response
    {
        
        $roomDetailsBefore = new ArrayCollection();
        foreach($room->getRoomDetails() as $roomDetail){
            $roomDetailsBefore->add($roomDetail);
        }
       
        $form = $this->createForm(RoomType::class, $room);
        $form->handleRequest($request);
        $housing = $room->getHoussing();



        if ($form->isSubmitted() && $form->isValid()) {
            //suppression des roomDetails supprimés
            foreach($roomDetailsBefore as $roomDetail){
                if(!$room->getRoomDetails()->contains($roomDetail)){
                    $room->removeRoomDetail($roomDetail);
                    $em->remove($roomDetail);
                }
            }
            //creation des nouvelles
            foreach ($room->getRoomDetails() as $roomdetail) {
                $roomdetail->setRoom($room);
            }

            $em->flush();

            return $this->redirectToRoute('edit_housing', ["id" => $housing->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('room/new2.html.twig', [
            'room' => $room,
            'housing' => $housing,
            'form' => $form,
        ]);
    }



    #[Route('/new', name: 'app_room_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $room = new Room();
        $form = $this->createForm(RoomType::class, $room);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($room);
            $entityManager->flush();

            return $this->redirectToRoute('app_room_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('room/new.html.twig', [
            'room' => $room,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_room_show', methods: ['GET'])]
    public function show(Room $room): Response
    {
        return $this->render('room/show.html.twig', [
            'room' => $room,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_room_editOld', methods: ['GET', 'POST'])]
    public function edit(Request $request, Room $room, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(RoomType::class, $room);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_room_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('room/edit.html.twig', [
            'room' => $room,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_room_delete', methods: ['POST'])]
    public function delete(Request $request, Room $room, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$room->getId(), $request->request->get('_token'))) {
            $entityManager->remove($room);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_room_index', [], Response::HTTP_SEE_OTHER);
    }
}
