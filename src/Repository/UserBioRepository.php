<?php

namespace App\Repository;

use App\Entity\UserBio;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<UserBio>
 *
 * @method UserBio|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserBio|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserBio[]    findAll()
 * @method UserBio[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserBioRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserBio::class);
    }

    public function save(UserBio $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(UserBio $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return UserBio[] Returns an array of UserBio objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('u.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?UserBio
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
