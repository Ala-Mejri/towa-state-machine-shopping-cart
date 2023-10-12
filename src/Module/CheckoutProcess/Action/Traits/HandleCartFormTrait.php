<?php

namespace App\Module\CheckoutProcess\Action\Traits;

use App\Module\CheckoutProcess\Form\CartType;
use App\Module\Order\Domain\Entity\Order;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;

trait HandleCartFormTrait
{
    private function handleCartForm(Request $request, Order $order): FormInterface
    {
        $form = $this->formFactory->create(CartType::class, $order);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->cartManagerService->save($order);
        }

        return $form;
    }
}