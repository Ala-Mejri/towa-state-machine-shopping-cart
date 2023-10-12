<?php

namespace App\Module\Product\Action;

use App\Shared\Service\CurrentUserService;
use App\Shared\Service\FlashService;
use App\Module\CheckoutProcess\Form\AddToCartType;
use App\Module\CheckoutProcess\Service\CartManagerService;
use App\Module\Product\Domain\Entity\Product;
use App\Module\Product\Repository\ProductRepository;
use App\Module\Product\Responder\ShowProductResponder;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

#[Route('/products/{id}', name: 'app.product.detail')]
class ShowProductAction
{
    public function __construct(
        private readonly ShowProductResponder $responder,
        private readonly ProductRepository    $productRepository,
        private readonly CartManagerService   $cartManagerService,
        private readonly FormFactoryInterface $formFactory,
        private readonly CurrentUserService   $currentUserService,
        private readonly FlashService         $flashService,
    )
    {
    }

    public function __invoke(int $id, Request $request): Response
    {
        $product = $this->productRepository->findOneWithImages($id);

        if (!$product) {
            throw $this->responder->createNotFoundException('Product not found!');
        }

        $form = $this->formFactory->create(AddToCartType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->currentUserService->getUser();

            if (!$user) {
                $this->flashService->addNoticeFlash('You need to be logged in first!');

                return $this->responder->redirect($product);
            }

            $this->addProductToCart($form, $product, $this->cartManagerService, $user);
            $this->flashService->addSuccessFlash('Product was added to cart successfully!');

            return $this->responder->redirect($product);
        }

        return $this->responder->respond($product, $form);
    }

    private function addProductToCart(FormInterface $form, Product $product, CartManagerService $cartManagerService, UserInterface $user): void
    {
        $item = $form->getData();
        $item->setProduct($product);

        $order = $this->cartManagerService->getCurrentCart();
        $order->setUser($user);
        $order->addItem($item);

        $this->cartManagerService->save($order);
    }
}