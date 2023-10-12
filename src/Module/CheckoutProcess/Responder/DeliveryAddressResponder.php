<?php

namespace App\Module\CheckoutProcess\Responder;

use App\Shared\Responder\HtmlResponder;
use App\Module\Order\Domain\Entity\Order;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

class DeliveryAddressResponder extends HtmlResponder
{
    public function respond(Order $order, FormInterface $form, FormInterface $cartForm): Response
    {
        return $this->render('checkout/address.html.twig', [
            'form' => $form->createView(),
            'order' => $order,
            'cartForm' => $cartForm->createView(),
        ]);
    }

    public function redirect(): RedirectResponse
    {
        return $this->redirectionResponder->redirectToRoute('app.checkout.summary');
    }
}
