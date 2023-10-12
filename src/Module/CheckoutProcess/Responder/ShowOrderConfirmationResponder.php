<?php

namespace App\Module\CheckoutProcess\Responder;

use App\Shared\Responder\HtmlResponder;
use App\Module\Order\Domain\Entity\Order;
use Symfony\Component\HttpFoundation\RedirectResponse;

class ShowOrderConfirmationResponder extends HtmlResponder
{
    public function redirect(Order $order): RedirectResponse
    {
        return $this->redirectionResponder->redirectToRoute('app.order.show', ['id' => $order->getId()]);
    }
}
