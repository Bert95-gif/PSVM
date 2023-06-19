<?php

namespace App\Repository;

use App\Entity\ConcursoVideojuegos;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ConcursoVideojuegos>
 *
 * @method ConcursoVideojuegos|null find($id, $lockMode = null, $lockVersion = null)
 * @method ConcursoVideojuegos|null findOneBy(array $criteria, array $orderBy = null)
 * @method ConcursoVideojuegos[]    findAll()
 * @method ConcursoVideojuegos[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ConcursoVideojuegosRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ConcursoVideojuegos::class);
    }

    public function add(ConcursoVideojuegos $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(ConcursoVideojuegos $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return ConcursoVideojuegos[] Returns an array of ConcursoVideojuegos objects
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

//    public function findOneBySomeField($value): ?ConcursoVideojuegos
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
