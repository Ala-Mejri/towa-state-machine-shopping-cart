<?php

namespace App\Module\CheckoutProcess\Action;

use App\Shared\Service\FlashService;
use App\Module\CheckoutProcess\Form\CartType;
use App\Module\CheckoutProcess\Responder\ShowCartResponder;
use App\Module\CheckoutProcess\Service\CartManagerService;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/cart', name: 'app.checkout.cart')]
class ShowCartAction
{
    public function __construct(
        private readonly ShowCartResponder    $responder,
        private readonly FlashService         $flashService,
        private readonly FormFactoryInterface $formFactory,
        private readonly CartManagerService   $cartManagerService,
    )
    {
    }

    public function __invoke(Request $request): Response
    {
        $order = $this->cartManagerService->getCurrentCart();
        $form = $this->formFactory->create(CartType::class, $order);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->cartManagerService->save($order);

            return $this->responder->redirect();
        }

        if ($this->cartManagerService->isEmpty($order)) {
            $this->flashService->addNoticeFlash('Your shopping cart is empty. Please add some products!');
        }

        return $this->responder->respond($order, $form);
    }
}
