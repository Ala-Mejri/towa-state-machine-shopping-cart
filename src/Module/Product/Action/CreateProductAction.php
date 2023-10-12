<?php

namespace App\Module\Product\Action;

use App\Shared\Service\FlashService;
use Doctrine\ORM\EntityManagerInterface;
use App\Module\Product\Domain\Entity\Product;
use App\Module\Product\Form\ProductType;
use App\Module\Product\Responder\CreateProductResponder;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/products/create', name: 'app.product.create')]
class CreateProductAction
{
    public function __construct(
        private readonly CreateProductResponder $responder,
        private readonly EntityManagerInterface $entityManager,
        private readonly FormFactoryInterface   $formFactory,
        private readonly FlashService           $flashService,
    )
    {
    }

    public function __invoke(Request $request): Response
    {
        $product = new Product();
        $form = $this->formFactory->create(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $product = $form->getData();
            $this->entityManager->persist($product);
            $this->entityManager->flush();

            $this->flashService->addSuccessFlash('Product was created successfully!');

            return $this->responder->redirect($product);
        }

        return $this->responder->respond($form);
    }
}