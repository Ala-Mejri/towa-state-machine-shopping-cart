<?php

namespace App\Module\CheckoutProcess\Service;

use App\Module\CheckoutProcess\Storage\CartSessionStorage;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use App\Module\Order\Domain\Entity\Order;
use App\Module\Order\Domain\Factory\OrderFactoryInterface;

class CartManagerService
{
    public function __construct(
        private readonly CartSessionStorage     $cartSessionStorage,
        private readonly OrderFactoryInterface  $orderFactory,
        private readonly EntityManagerInterface $entityManager
    )
    {
    }

    public function getCurrentCart(): Order
    {
        return $this->cartSessionStorage->getCart()
            ?? $this->orderFactory->create();
    }

    public function removeCurrentCart(): void
    {
        $this->cartSessionStorage->removeCart();
    }

    /**
     * Persists the cart in database and session.
     */
    public function save(Order $order): void
    {
        $order->setUpdatedAt(new DateTime());

        // Persist in database
        $this->entityManager->persist($order);
        $this->entityManager->flush();

        // Persist in session
        $this->cartSessionStorage->setCart($order);
    }

    public function updateStatus(Order $order, string $status): void
    {
        $order->setStatus($status);
        $order->setUpdatedAt(new DateTime());

        $this->save($order);
    }

    public function isEmpty(Order $order): bool
    {
        return $order->getItems()->count() === 0;
    }
}
