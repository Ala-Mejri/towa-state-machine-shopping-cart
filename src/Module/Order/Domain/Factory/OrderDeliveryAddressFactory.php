<?php

namespace App\Module\Order\Domain\Factory;

use App\Module\Order\Domain\Entity\OrderDeliveryAddress;
use App\Module\User\Domain\Entity\UserDeliveryAddress;

class OrderDeliveryAddressFactory implements OrderDeliveryAddressFactoryInterface
{
    public function createFromUserDeliveryAddress(UserDeliveryAddress $userDeliveryAddress): OrderDeliveryAddress
    {
        $orderDeliveryAddress = new OrderDeliveryAddress();
        $orderDeliveryAddress
            ->setName($userDeliveryAddress->getName())
            ->setEmail($userDeliveryAddress->getEmail())
            ->setStreet($userDeliveryAddress->getStreet())
            ->setPostalCode($userDeliveryAddress->getPostalCode())
            ->setTelephoneNumber($userDeliveryAddress->getTelephoneNumber())
            ->setTaxNumber($userDeliveryAddress->getTaxNumber())
            ->setCity($userDeliveryAddress->getCity());

        return $orderDeliveryAddress;
    }
}