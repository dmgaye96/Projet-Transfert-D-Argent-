<?php

namespace App\Repository;

use App\Entity\Codeoperation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Codeoperation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Codeoperation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Codeoperation[]    findAll()
 * @method Codeoperation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CodeoperationRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Codeoperation::class);
    }

    // /**
    //  * @return Codeoperation[] Returns an array of Codeoperation objects
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
    public function findOneBySomeField($value): ?Codeoperation
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
