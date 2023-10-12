<?php

namespace App\Module\User\Domain\Factory;

use App\Module\Order\Domain\Entity\OrderDeliveryAddress;
use App\Module\User\Domain\Entity\UserDeliveryAddress;

interface UserDeliveryAddressFactoryInterface
{
    public function createFromOrderDeliveryAddress(OrderDeliveryAddress $orderDeliveryAddress): UserDeliveryAddress;
}