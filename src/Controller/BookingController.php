<?php

namespace App\Controller;

use DateTime;
use App\Entity\Booking;
use App\Entity\Houssing;
use Doctrine\ORM\EntityManager;
use App\Repository\BookingRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BookingController extends AbstractController
{
    #[Route('/booking', name: 'app_booking')]
    public function index(): Response
    {
        return $this->render('booking/index.html.twig', [
            'controller_name' => 'BookingController',
        ]);
    }

    #[Route('/{id}/{begin}/{end}/newBooking', name: 'app_newBooking', methods: ['GET', 'POST'])]
    public function booking(EntityManagerInterface $em, Request $request,BookingRepository $br,Houssing $houssing,$begin,$end): Response
    {
        $booking = new Booking();
        $booking->setHoussing($houssing);
        $booking->setBeginDate(new DateTime($begin));
        $booking->setEndDate(new DateTime($end));
        $booking->setTotalPrice($houssing->getPrice());

        
        $em->persist($booking);
        $em->flush();

        //dd($begin,$end,$houssingId);
        
        return $this->render('booking/index.html.twig', [
            'controller_name' => 'BookingController',
        ]);
    }


}
