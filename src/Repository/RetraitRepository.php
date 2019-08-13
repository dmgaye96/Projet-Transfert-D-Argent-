<?php

namespace App\Repository;

use App\Entity\Retrait;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Retrait|null find($id, $lockMode = null, $lockVersion = null)
 * @method Retrait|null findOneBy(array $criteria, array $orderBy = null)
 * @method Retrait[]    findAll()
 * @method Retrait[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RetraitRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Retrait::class);
    }

    // /**
    //  * @return Retrait[] Returns an array of Retrait objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Retrait
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
