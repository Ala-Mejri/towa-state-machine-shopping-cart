<?php

namespace App\Module\Product\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Module\Product\Domain\Factory\ProductFactoryInterface;
use App\Module\Product\Domain\Factory\ProductImageFactoryInterface;

class ProductFixtures extends Fixture
{
    public function __construct(
        private readonly ProductFactoryInterface      $productFactory,
        private readonly ProductImageFactoryInterface $productImageFactory,
    )
    {
    }

    public function load(ObjectManager $manager): void
    {
        for ($i = 1; $i <= 12; $i++) {
            $product = $this->productFactory->create(
                'Product ' . $i,
                'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua',
                mt_rand(15, 35),
                $this->productImageFactory->create('https://tailwindui.com/img/ecommerce-images/product-page-01-related-product-0' . rand(1, 4) . '.jpg'),
            );

            $manager->persist($product);
        }

        $manager->flush();
    }
}
