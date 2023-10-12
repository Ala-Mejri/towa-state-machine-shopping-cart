<?php

namespace App\Module\Product\Action;

use App\Shared\Service\FlashService;
use Doctrine\ORM\EntityManagerInterface;
use App\Module\Product\Repository\ProductRepository;
use App\Module\Product\Responder\DeleteProductResponder;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/products/delete/{id}', name: 'app.product.delete', methods: ['GET', 'DELETE'])]
class DeleteProductAction
{
    public function __construct(
        private readonly DeleteProductResponder $responder,
        private readonly ProductRepository      $productRepository,
        private readonly EntityManagerInterface $entityManager,
        private readonly FlashService           $flashService,
    )
    {
    }

    public function __invoke(int $id): Response
    {
        $product = $this->productRepository->find($id);
        $this->entityManager->remove($product);
        $this->entityManager->flush();

        $this->flashService->addSuccessFlash('Product was deleted successfully!');

        return $this->responder->redirect();
    }
}