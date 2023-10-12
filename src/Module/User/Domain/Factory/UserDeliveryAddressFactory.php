<?php

namespace App\Module\User\Domain\Factory;

use App\Module\Order\Domain\Entity\OrderDeliveryAddress;
use App\Module\User\Domain\Entity\UserDeliveryAddress;

class UserDeliveryAddressFactory implements UserDeliveryAddressFactoryInterface
{
    public function createFromOrderDeliveryAddress(OrderDeliveryAddress $orderDeliveryAddress): UserDeliveryAddress
    {
        $userDeliveryAddress = new UserDeliveryAddress();
        $userDeliveryAddress
            ->setName($orderDeliveryAddress->getName())
            ->setEmail($orderDeliveryAddress->getEmail())
            ->setStreet($orderDeliveryAddress->getStreet())
            ->setPostalCode($orderDeliveryAddress->getPostalCode())
            ->setTelephoneNumber($orderDeliveryAddress->getTelephoneNumber())
            ->setTaxNumber($orderDeliveryAddress->getTaxNumber())
            ->setCity($orderDeliveryAddress->getCity())
            ->setUser($orderDeliveryAddress->getOrderRelation()->getUser());

        return $userDeliveryAddress;
    }
}