<?php

namespace App\Module\CheckoutProcess\Responder;

use App\Shared\Responder\HtmlResponder;
use App\Module\Order\Domain\Entity\Order;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Response;

class ShowSummaryResponder extends HtmlResponder
{
    public function respond(Order $order, FormInterface $form): Response
    {
        return $this->render('checkout/summary.html.twig', [
            'order' => $order,
            'form' => $form->createView(),
        ]);
    }
}
