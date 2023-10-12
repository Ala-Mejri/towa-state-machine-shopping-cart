<?php

namespace App\Module\Product\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Module\Product\Domain\Entity\Product;

/**
 * @extends ServiceEntityRepository<Product>
 *
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    /**
     * @return Product[] Returns an array of Product objects
     */
    public function findAllWithImages(): array
    {
        return $this->createQueryBuilder('p')
            ->join('p.image', 'i')
            ->select(['p', 'i'])
            ->orderBy('p.id', 'DESC')
            ->getQuery()
            ->getResult();
    }

    public function findOneWithImages(int $id): ?Product
    {
        return $this->createQueryBuilder('p')
            ->join('p.image', 'i')
            ->select(['p', 'i'])
            ->andWhere('p.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
