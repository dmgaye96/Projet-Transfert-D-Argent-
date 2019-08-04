<?php

namespace App\Repository;

use App\Entity\CaissierController;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method CaissierController|null find($id, $lockMode = null, $lockVersion = null)
 * @method CaissierController|null findOneBy(array $criteria, array $orderBy = null)
 * @method CaissierController[]    findAll()
 * @method CaissierController[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CaissierControllerRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, CaissierController::class);
    }

    // /**
    //  * @return CaissierController[] Returns an array of CaissierController objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?CaissierController
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
