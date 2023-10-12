<?php

namespace App\Module\CheckoutProcess\Business;

use App\Shared\Service\CurrentUserService;
use App\Module\Order\Domain\Entity\Order;
use App\Module\Order\Domain\Entity\OrderDeliveryAddress;
use App\Module\Order\Domain\Factory\OrderDeliveryAddressFactoryInterface;
use App\Module\User\Domain\Entity\UserDeliveryAddress;

class GetCheckoutDeliveryAddress
{
    public function __construct(
        private readonly CurrentUserService                   $currentUserService,
        private readonly OrderDeliveryAddressFactoryInterface $orderDeliveryAddressFactory,
    )
    {
    }

    public function getDeliveryAddress(Order $order): OrderDeliveryAddress
    {
        $deliveryAddress = $order->getDeliveryAddress()
            ?? $this->currentUserService->getUser()?->getPrimaryDeliveryAddress()
            ?? new OrderDeliveryAddress();

        return $deliveryAddress instanceof UserDeliveryAddress
            ? $this->orderDeliveryAddressFactory->createFromUserDeliveryAddress($deliveryAddress)
            : $deliveryAddress;
    }
}