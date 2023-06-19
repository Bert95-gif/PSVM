<?php

namespace App\Repository;

use App\Entity\ConcursoCanciones;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ConcursoCanciones>
 *
 * @method ConcursoCanciones|null find($id, $lockMode = null, $lockVersion = null)
 * @method ConcursoCanciones|null findOneBy(array $criteria, array $orderBy = null)
 * @method ConcursoCanciones[]    findAll()
 * @method ConcursoCanciones[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ConcursoCancionesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ConcursoCanciones::class);
    }

    public function add(ConcursoCanciones $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(ConcursoCanciones $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return ConcursoCanciones[] Returns an array of ConcursoCanciones objects
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

//    public function findOneBySomeField($value): ?ConcursoCanciones
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
