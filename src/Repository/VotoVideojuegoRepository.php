<?php

namespace App\Repository;

use App\Entity\VotoVideojuego;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<VotoVideojuego>
 *
 * @method VotoVideojuego|null find($id, $lockMode = null, $lockVersion = null)
 * @method VotoVideojuego|null findOneBy(array $criteria, array $orderBy = null)
 * @method VotoVideojuego[]    findAll()
 * @method VotoVideojuego[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VotoVideojuegoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, VotoVideojuego::class);
    }

    public function add(VotoVideojuego $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(VotoVideojuego $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return VotoVideojuego[] Returns an array of VotoVideojuego objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('v')
//            ->andWhere('v.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('v.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?VotoVideojuego
//    {
//        return $this->createQueryBuilder('v')
//            ->andWhere('v.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
