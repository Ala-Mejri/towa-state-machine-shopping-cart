<?php

namespace App\Module\Order\Domain\Factory;

use App\Module\Order\Domain\Entity\OrderDeliveryAddress;
use App\Module\User\Domain\Entity\UserDeliveryAddress;

interface OrderDeliveryAddressFactoryInterface
{
    public function createFromUserDeliveryAddress(UserDeliveryAddress $userDeliveryAddress): OrderDeliveryAddress;
}