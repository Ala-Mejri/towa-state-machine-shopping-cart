<?php

namespace App\Module\CheckoutProcess\Business;

use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use App\Module\Order\Repository\OrderRepository;

class RemoveExpiredCarts
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly OrderRepository        $orderRepository
    )
    {
    }

    public function deleteInactiveOrders(int $days): int
    {
        $limitDate = new DateTime("- $days days");
        $expiredCartsCount = 0;

        while ($carts = $this->orderRepository->findOrdersNotModifiedSince($limitDate)) {
            foreach ($carts as $cart) {
                $this->entityManager->remove($cart);
            }

            $this->entityManager->flush();
            $this->entityManager->clear();

            $expiredCartsCount += count($carts);
        }

        return $expiredCartsCount;
    }
}