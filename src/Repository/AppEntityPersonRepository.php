<?php

namespace App\Repository;

use App\Entity\AppEntityPerson;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method AppEntityPerson|null find($id, $lockMode = null, $lockVersion = null)
 * @method AppEntityPerson|null findOneBy(array $criteria, array $orderBy = null)
 * @method AppEntityPerson[]    findAll()
 * @method AppEntityPerson[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AppEntityPersonRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AppEntityPerson::class);
    }

    // /**
    //  * @return AppEntityPerson[] Returns an array of AppEntityPerson objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?AppEntityPerson
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
