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
use Symfony\Component\HttpFoundation\JsonResponse;
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

         //debut json

        //  $lesBooking = $houssing->getBookings();
        // $tab = [];
            
        // foreach($lesBooking as $lb){
        //     $tab[] = ["title"=> 'Reserver',"start"=>$lb->getBeginDate(),'end'=>$lb->getEndDate() ];

        // }
        // $rep = new JsonResponse($tab);
        // //dd($rep);
        // return $rep;

        
        //dd($begin,$end,$houssingId);
        
        return $this->render('booking/index.html.twig', [
            'controller_name' => 'BookingController',
        ]);
    }
    #[Route('/{id}/apiBooking',name:'apiBooking')]
    public function apiBooking(Request $request,Houssing $houssing){

        $lesBooking = $houssing->getBookings();
        $tab = [];
            
        foreach($lesBooking as $lb){
            $tab[] = ["title"=> 'Reserver',"start"=>$lb->getBeginDate(),'end'=>$lb->getEndDate() ];
        }
        //dd($rep);
        return $this->json($tab) ;

        //dd($lesBooking);

        // [

        //     {
        //       title: 'Long Event',
        //       start: '2022-04-01',
        //       end: '2022-04-10'
        //     },
        //     {
        //       title: 'Long Event',
        //       start: '2022-04-15',
        //       end: '2022-04-18'
        //     }
        //   ]
    }


}
