<?php

namespace App\Module\User\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Module\User\Domain\Entity\UserDeliveryAddress;

/**
 * @extends ServiceEntityRepository<UserDeliveryAddress>
 *
 * @method UserDeliveryAddress|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserDeliveryAddress|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserDeliveryAddress[]    findAll()
 * @method UserDeliveryAddress[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserDeliveryAddressRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserDeliveryAddress::class);
    }

//    /**
//     * @return UserDeliveryAddress[] Returns an array of UserDeliveryAddress objects
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

//    public function findOneBySomeField($value): ?UserDeliveryAddress
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
