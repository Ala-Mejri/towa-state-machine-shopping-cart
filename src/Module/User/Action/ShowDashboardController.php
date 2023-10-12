<?php

namespace App\Module\User\Action;

use App\Shared\Service\CurrentUserService;
use App\Module\Order\Repository\OrderRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Module\User\Responder\ShowDashboardResponder;

#[Route('/dashboard', name: 'app.dashboard')]
class ShowDashboardController
{
    public function __construct(
        private readonly OrderRepository        $orderRepository,
        private readonly ShowDashboardResponder $responder,
        private readonly CurrentUserService     $currentUserService,
    )
    {
    }

    public function __invoke(): Response
    {
        $orders = $this->orderRepository->findOrderedByUserId($this->currentUserService->getUser()->getId());

        return $this->responder->respond($orders);
    }
}