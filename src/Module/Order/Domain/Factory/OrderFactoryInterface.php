<?php

namespace App\Module\Order\Domain\Factory;

use App\Module\Order\Domain\Entity\Order;

interface OrderFactoryInterface
{
    public function create(): Order;
}