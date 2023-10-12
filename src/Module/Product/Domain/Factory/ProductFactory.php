<?php

namespace App\Module\Product\Domain\Factory;

use App\Module\Product\Domain\Entity\Product;
use App\Module\Product\Domain\Entity\ProductImage;

class ProductFactory implements ProductFactoryInterface
{
    public function create(string $name, string $description, float $price, ProductImage $productImage): Product
    {
        $product = new Product();
        $product
            ->setName($name)
            ->setDescription($description)
            ->setPrice($price)
            ->setImage($productImage);

        return $product;
    }
}