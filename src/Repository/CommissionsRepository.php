<?php

namespace App\Repository;

use App\Entity\Commissions;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Commissions|null find($id, $lockMode = null, $lockVersion = null)
 * @method Commissions|null findOneBy(array $criteria, array $orderBy = null)
 * @method Commissions[]    findAll()
 * @method Commissions[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommissionsRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Commissions::class);
    }

    // /**
    //  * @return Commissions[] Returns an array of Commissions objects
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
    public function findOneBySomeField($value): ?Commissions
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
