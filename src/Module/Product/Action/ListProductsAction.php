<?php

namespace App\Module\Product\Action;

use App\Module\Product\Repository\ProductRepository;
use App\Module\Product\Responder\ListProductsResponder;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/products', name: 'app.product.list')]
class ListProductsAction
{
    public function __construct(
        private readonly ListProductsResponder $responder,
        private readonly ProductRepository     $productRepository,
    )
    {
    }

    public function __invoke(): Response
    {
        $products = $this->productRepository->findAllWithImages();

        return $this->responder->respond($products);
    }
}