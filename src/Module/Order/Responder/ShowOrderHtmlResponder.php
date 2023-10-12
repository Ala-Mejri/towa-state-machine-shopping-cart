<?php

namespace App\Module\Order\Responder;

use App\Shared\Responder\HtmlResponder;
use App\Module\Order\Domain\Entity\Order;
use Symfony\Component\HttpFoundation\Response;

class ShowOrderHtmlResponder extends HtmlResponder
{
    public function respond(Order $order): Response
    {
        return $this->render('checkout/ordered.html.twig', [
            'order' => $order,
        ]);
    }
}