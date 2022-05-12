<?php

namespace App\Controller;

use App\Repository\HoussingRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    #[Route('/home', name: 'app_home')]
    public function index(): Response
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
    /**
     * rappel: dans doctrine.yaml add this apres dbal 
     */
    #[Route('/ok', name:'app_ok')]
    public function okVille(EntityManagerInterface $em){
        $conn = $em->getConnection();
        $sql = '
        SELECT ville_nom FROM spec_villes_france_free
        WHERE ville_code_postal = :code
        ';
        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery(['code' => "46100"]);

        $cities = $resultSet->fetchAllAssociative();
        dd($cities);
    }
    #[Route('/search', name:'app_search')]
    public function q(Request $request, HoussingRepository $hr){
        $ville = $request->get("where");
        $begin = $request->get("begin");
        $end = $request->get("end");
        $people = $request->get("people");

        
        //dd($hr->search($ville,2));
        $datas = $hr->search($ville,$people);

        return $this->render('home/search.html.twig', [
            'controller_name' => 'HomeController',
            'datas' => $datas
        ]);
    }
    #[Route('/acceuil', name:'app_acceuil')]
    public function pageRecherche(Request $request){
        return $this->render('home/search.html.twig', [
            'controller_name' => 'HomeController',
        ]);
        
    }
    


}
