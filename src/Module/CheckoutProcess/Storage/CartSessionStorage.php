<?php

namespace App\Module\CheckoutProcess\Storage;

use App\Module\Order\Domain\Entity\Order;
use App\Module\Order\Repository\OrderRepository;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CartSessionStorage
{
    const CART_KEY_NAME = 'cart_id';

    public function __construct(private RequestStack $requestStack, private OrderRepository $cartRepository)
    {
    }

    /**
     * Gets the cart in session.
     */
    public function getCart(): ?Order
    {
        return $this->cartRepository->findOneById($this->getCartId());
    }

    /**
     * Sets the cart in session.
     */
    public function setCart(Order $order): void
    {
        $this->getSession()->set(self::CART_KEY_NAME, $order->getId());
    }

    public function removeCart(): void
    {
        $this->getSession()->remove(self::CART_KEY_NAME);
    }

    private function getCartId(): ?int
    {
        return $this->getSession()->get(self::CART_KEY_NAME);
    }

    private function getSession(): SessionInterface
    {
        return $this->requestStack->getSession();
    }
}
