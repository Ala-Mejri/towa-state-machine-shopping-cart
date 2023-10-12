<?php

namespace App\Module\Product\Domain\Factory;

use App\Module\Product\Domain\Entity\Product;
use App\Module\Product\Domain\Entity\ProductImage;

interface ProductFactoryInterface
{
    public function create(string $name, string $description, float $price, ProductImage $productImage): Product;
}