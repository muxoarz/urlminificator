<?php

namespace App\Repository;

use App\Entity\UrlClick;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method UrlClick|null find($id, $lockMode = null, $lockVersion = null)
 * @method UrlClick|null findOneBy(array $criteria, array $orderBy = null)
 * @method UrlClick[]    findAll()
 * @method UrlClick[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UrlClickRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, UrlClick::class);
    }

//    /**
//     * @return UrlClick[] Returns an array of UrlClick objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?UrlClick
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
