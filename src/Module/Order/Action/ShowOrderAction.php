<?php

namespace App\Module\Order\Action;

use App\Shared\Service\CurrentUserService;
use App\Module\Order\Domain\Entity\Order;
use App\Module\Order\Responder\ShowOrderHtmlResponder;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/order/{id}', name: 'app.order.show')]
class ShowOrderAction
{
    public function __construct(
        private readonly ShowOrderHtmlResponder $responder,
        private readonly CurrentUserService     $currentUserService,
    )
    {
    }

    public function __invoke(Order $order): Response
    {
        if (!$this->currentUserService->isOwner($order) || $order->getStatus() !== Order::STATUS_ORDERED) {
            throw $this->responder->createAccessDeniedException();
        }

        return $this->responder->respond($order);
    }
}