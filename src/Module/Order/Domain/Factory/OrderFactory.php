<?php

namespace App\Module\Order\Domain\Factory;

use DateTime;
use App\Module\Order\Domain\Entity\Order;

class OrderFactory implements OrderFactoryInterface
{
    public function create(): Order
    {
        $order = new Order();
        $order
            ->setStatus(Order::STATUS_SHOPPING_CART)
            ->setCreatedAt(new DateTime())
            ->setUpdatedAt(new DateTime());

        return $order;
    }
}