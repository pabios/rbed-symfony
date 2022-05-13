<?php

namespace App\Repository;

use App\Entity\Houssing;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Houssing>
 *
 * @method Houssing|null find($id, $lockMode = null, $lockVersion = null)
 * @method Houssing|null findOneBy(array $criteria, array $orderBy = null)
 * @method Houssing[]    findAll()
 * @method Houssing[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HoussingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Houssing::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Houssing $entity, bool $flush = false): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(Houssing $entity, bool $flush = false): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

   /**
    * @return Houssing[] Returns an array of Houssing objects
    */
   public function search($city,$place,$dateA,$dateB): array
   {
        $conn = $this->getEntityManager()->getConnection();
        $sql = '
        SELECT ville_nom, ville_slug, ville_longitude_deg, ville_latitude_deg FROM spec_villes_france_free
        WHERE ville_nom = :nom   
        ';
        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery(['nom' => strtoupper($city)]);
        $city = $resultSet->fetchAssociative();

        $qbDate = $this->createQueryBuilder('h2');
                $qbDate 
                ->innerJoin("h2.bookings", "b")
                ->where(" :dateA BETWEEN b.beginDate AND b.endDate ")
                ->orWhere(" :dateB BETWEEN b.beginDate AND b.endDate")
                ->orWhere(" b.beginDate BETWEEN :dateA AND :dateB");


         $qb =  $this->createQueryBuilder('h')
                    ->join('h.adresse','ha')
                    ->join('h.rooms','hr')
                    ->join('hr.roomDetails','rd')
                    ->join('rd.bed','bed')
                    ->groupBy('h')
                    ->having('sum(rd.quantity * bed.place) >= :qty');

                    if ($dateA && $dateB) {
                        //requête imbriquée
                        $qb->where($qb->expr()->notIn('h.id', $qbDate->getDQL()))
                            ->setParameter("dateA", $dateA)
                            ->setParameter("dateB", $dateB);
                    }
               
                    $qb
                        ->addSelect("ACOS(SIN(PI()*ha.latitude/180.0)*SIN(PI()*:lat2/180.0)+COS(PI()*ha.latitude/180.0)*COS(PI()*:lat2/180.0)*COS(PI()*:lon2/180.0-PI()*ha.longitude/180.0))*6371 AS dist")
                        ->setParameter(":lat2", $city["ville_latitude_deg"])
                        ->setParameter(":lon2", $city["ville_longitude_deg"])
                        ->orderBy("dist")
                        ->setParameter('qty', $place);
                   return $qb->getQuery()->getResult()
               ;
   }


  public function lesVille()
   {

        $conn = $this->getEntityManager()->getConnection();
        $sql = '
        SELECT ville_nom FROM spec_villes_france_free WHERE ville_nom LIKE "%a%"   LIMIT 50
        ';
        $result = $conn->query($sql);
        $city = $result->fetchAll();

       return  $city;
   }


//    public function findOneBySomeField($value): ?Houssing
//    {
//        return $this->createQueryBuilder('h')
//            ->andWhere('h.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
