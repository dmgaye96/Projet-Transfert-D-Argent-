<?php

namespace App\Repository;

use App\Entity\Typeoperation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Typeoperation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Typeoperation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Typeoperation[]    findAll()
 * @method Typeoperation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TypeoperationRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Typeoperation::class);
    }

    // /**
    //  * @return Typeoperation[] Returns an array of Typeoperation objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Typeoperation
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
