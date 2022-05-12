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
   public function search($city,$place): array
   {
        $conn = $this->getEntityManager()->getConnection();
        $sql = '
        SELECT ville_nom, ville_slug, ville_longitude_deg, ville_latitude_deg FROM spec_villes_france_free
        WHERE ville_nom = :nom   
        ';
        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery(['nom' => strtoupper($city)]);
        $city = $resultSet->fetchAssociative();

        return $this->createQueryBuilder('h')
                    ->join('h.adresse','ha')
                    ->join('h.rooms','hr')
                    ->join('hr.roomDetails','rd')
                    ->join('rd.bed','bed')
                    ->groupBy('h')
                    ->having('sum(rd.quantity * bed.place) >= :qty')
                   ->andWhere('ha.city = :val')
                   ->setParameter('val', $city['ville_nom'])
                   ->setParameter('qty', $place)
                   ->getQuery()->getResult()
               ;

        return $city;
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
