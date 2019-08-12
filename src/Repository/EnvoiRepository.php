<?php

namespace App\Repository;

use App\Entity\Envoi;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Envoi|null find($id, $lockMode = null, $lockVersion = null)
 * @method Envoi|null findOneBy(array $criteria, array $orderBy = null)
 * @method Envoi[]    findAll()
 * @method Envoi[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EnvoiRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Envoi::class);
    }

    // /**
    //  * @return Envoi[] Returns an array of Envoi objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Envoi
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
