<?php

namespace App\Repository;

use App\Entity\Typedepiece;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Typedepiece|null find($id, $lockMode = null, $lockVersion = null)
 * @method Typedepiece|null findOneBy(array $criteria, array $orderBy = null)
 * @method Typedepiece[]    findAll()
 * @method Typedepiece[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TypedepieceRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Typedepiece::class);
    }

    // /**
    //  * @return Typedepiece[] Returns an array of Typedepiece objects
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
    public function findOneBySomeField($value): ?Typedepiece
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
