<?php

namespace App\Module\Product\Action;

use App\Shared\Service\FlashService;
use Doctrine\ORM\EntityManagerInterface;
use App\Module\Product\Form\ProductType;
use App\Module\Product\Repository\ProductRepository;
use App\Module\Product\Responder\EditProductResponder;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/products/edit/{id}', name: 'app.product.edit')]
class EditProductAction
{
    public function __construct(
        private readonly EditProductResponder   $responder,
        private readonly FormFactoryInterface   $formFactory,
        private readonly ProductRepository      $productRepository,
        private readonly EntityManagerInterface $entityManager,
        private readonly FlashService           $flashService,
    )
    {
    }

    public function __invoke(int $id, Request $request): Response
    {
        $product = $this->productRepository->find($id);
        $form = $this->formFactory->create(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $product->setName($form->get('name')->getData());
            $product->setPrice($form->get('price')->getData());
            $product->setDescription($form->get('description')->getData());
            $this->entityManager->flush();

            $this->flashService->addSuccessFlash('Product was updated successfully!');

            return $this->responder->redirect($product);
        }

        return $this->responder->respond($product, $form);
    }
}