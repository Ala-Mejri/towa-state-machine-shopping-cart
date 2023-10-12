<?php

namespace App\Module\Order\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Module\Order\Domain\Entity\OrderDeliveryAddress;

/**
 * @extends ServiceEntityRepository<OrderDeliveryAddress>
 *
 * @method OrderDeliveryAddress|null find($id, $lockMode = null, $lockVersion = null)
 * @method OrderDeliveryAddress|null findOneBy(array $criteria, array $orderBy = null)
 * @method OrderDeliveryAddress[]    findAll()
 * @method OrderDeliveryAddress[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OrderDeliveryAddressRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OrderDeliveryAddress::class);
    }

//    /**
//     * @return OrderDeliveryAddress[] Returns an array of OrderDeliveryAddress objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('o')
//            ->andWhere('o.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('o.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?OrderDeliveryAddress
//    {
//        return $this->createQueryBuilder('o')
//            ->andWhere('o.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
