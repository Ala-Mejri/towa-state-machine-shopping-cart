<?php

namespace App\Module\Product\Domain\Factory;

use App\Module\Product\Domain\Entity\ProductImage;

class ProductImageFactory implements ProductImageFactoryInterface
{
    public function create(string $path): ProductImage
    {
        $productImage = new ProductImage();
        $productImage->setPath($path);

        return $productImage;
    }
}