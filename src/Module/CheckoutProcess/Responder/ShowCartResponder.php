<?php

namespace App\Module\CheckoutProcess\Responder;

use App\Shared\Responder\HtmlResponder;
use App\Module\Order\Domain\Entity\Order;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

class ShowCartResponder extends HtmlResponder
{
    public function respond(Order $order, FormInterface $form): Response
    {
        return $this->render('checkout/cart.html.twig', [
            'order' => $order,
            'form' => $form->createView(),
        ]);
    }

    public function redirect(): RedirectResponse
    {
        return $this->redirectionResponder->redirectToRoute('app.checkout.cart');
    }
}
