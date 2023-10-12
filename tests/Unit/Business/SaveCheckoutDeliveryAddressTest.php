<?php

namespace App\Tests\Unit\Business;

use App\Module\CheckoutProcess\Business\SaveCheckoutDeliveryAddress;
use App\Module\Order\Domain\Entity\Order;
use App\Module\Order\Domain\Entity\OrderDeliveryAddress;
use App\Module\User\Domain\Entity\UserDeliveryAddress;
use App\Module\User\Domain\Factory\UserDeliveryAddressFactoryInterface;
use App\Tests\UserTrait;
use Doctrine\ORM\EntityManagerInterface;
use Prophecy\PhpUnit\ProphecyTrait;
use Prophecy\Prophecy\ObjectProphecy;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * @covers SaveCheckoutDeliveryAddress
 */
class SaveCheckoutDeliveryAddressTest extends KernelTestCase
{
    use ProphecyTrait;
    use UserTrait;

    private ObjectProphecy $userDeliveryAddressFactory;
    private ObjectProphecy $entityManager;
    private SaveCheckoutDeliveryAddress $saveCheckoutDeliveryAddress;

    protected function setUp(): void
    {
        $this->userDeliveryAddressFactory = $this->prophesize(UserDeliveryAddressFactoryInterface::class);
        $this->entityManager = $this->prophesize(EntityManagerInterface::class);

        $this->saveCheckoutDeliveryAddress = new SaveCheckoutDeliveryAddress(
            $this->userDeliveryAddressFactory->reveal(),
            $this->entityManager->reveal(),
        );

        parent::setUp();
    }

    public function testShouldReturnCorrectOrderDeliveryAddress(): void
    {
        $user = $this->getUser();
        $order = new Order();
        $order->setStatus(Order::STATUS_SHOPPING_CART);
        $order->setUser($user);

        $orderDeliveryAddress = new OrderDeliveryAddress();
        $orderDeliveryAddress->setEmail('test@email.com');
        $userDeliveryAddress = new UserDeliveryAddress();

        $this->entityManager
            ->persist($orderDeliveryAddress)
            ->shouldBeCalledOnce();

        $this->userDeliveryAddressFactory
            ->createFromOrderDeliveryAddress($orderDeliveryAddress)
            ->shouldBeCalledOnce()
            ->willReturn($userDeliveryAddress);

        $this->entityManager
            ->persist($userDeliveryAddress)
            ->shouldBeCalledOnce();

        $this->entityManager
            ->flush()
            ->shouldBeCalledOnce();

        $actual = $this->saveCheckoutDeliveryAddress
            ->saveDeliveryAddresses($order, $orderDeliveryAddress);

        $this->assertEquals($orderDeliveryAddress, $actual);
    }
}