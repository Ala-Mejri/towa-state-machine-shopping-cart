<?php

namespace App\Module\CheckoutProcess\Business;

use Doctrine\ORM\EntityManagerInterface;
use App\Module\Order\Domain\Entity\Order;
use App\Module\Order\Domain\Entity\OrderDeliveryAddress;
use App\Module\User\Domain\Factory\UserDeliveryAddressFactoryInterface;

class SaveCheckoutDeliveryAddress
{
    public function __construct(
        private readonly UserDeliveryAddressFactoryInterface $userDeliveryAddressFactory,
        private readonly EntityManagerInterface              $entityManager,
    )
    {
    }

    public function saveDeliveryAddresses(Order $order, OrderDeliveryAddress $orderDeliveryAddress): OrderDeliveryAddress
    {
        $orderDeliveryAddress = $this->persistOrderDeliveryAddress($order, $orderDeliveryAddress);
        $this->persistUserDeliveryAddress($orderDeliveryAddress);

        $this->entityManager->flush();

        return $orderDeliveryAddress;
    }

    private function persistOrderDeliveryAddress(Order $order, OrderDeliveryAddress $orderDeliveryAddress): OrderDeliveryAddress
    {
        $orderDeliveryAddress->setOrderRelation($order);
        $this->entityManager->persist($orderDeliveryAddress);

        return $orderDeliveryAddress;
    }

    private function persistUserDeliveryAddress(OrderDeliveryAddress $orderDeliveryAddress): void
    {
        $userDeliveryAddress = $this->userDeliveryAddressFactory->createFromOrderDeliveryAddress($orderDeliveryAddress);
        $this->entityManager->persist($userDeliveryAddress);
    }
}