<?php

namespace App\Repository;

use App\Entity\ConcursoPeliculas;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ConcursoPeliculas>
 *
 * @method ConcursoPeliculas|null find($id, $lockMode = null, $lockVersion = null)
 * @method ConcursoPeliculas|null findOneBy(array $criteria, array $orderBy = null)
 * @method ConcursoPeliculas[]    findAll()
 * @method ConcursoPeliculas[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ConcursoPeliculasRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ConcursoPeliculas::class);
    }

    public function add(ConcursoPeliculas $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(ConcursoPeliculas $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return ConcursoPeliculas[] Returns an array of ConcursoPeliculas objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?ConcursoPeliculas
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
