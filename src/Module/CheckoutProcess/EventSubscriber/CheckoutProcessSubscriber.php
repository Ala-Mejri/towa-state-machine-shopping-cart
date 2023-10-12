<?php

namespace App\Module\CheckoutProcess\EventSubscriber;

use App\Module\CheckoutProcess\Service\CartManagerService;
use App\Module\Order\Domain\Entity\Order;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Workflow\Event\TransitionEvent;

class CheckoutProcessSubscriber implements EventSubscriberInterface
{
    public function __construct(private readonly CartManagerService $cartManagerService)
    {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            'workflow.checkout_process.transition.to_delivery_address' => 'onTransitionToDeliveryAddress',
            'workflow.checkout_process.transition.to_summary_for_purchase' => 'onTransitionToSummaryForPurchases',
            'workflow.checkout_process.transition.to_ordered' => 'onTransitionToOrdered',
        ];
    }

    public function onTransitionToDeliveryAddress(TransitionEvent $event): void
    {
        $this->updateOrderStatus($event->getSubject(), Order::STATUS_DELIVERY_ADDRESS);
    }

    public function onTransitionToSummaryForPurchases(TransitionEvent $event): void
    {
        $this->updateOrderStatus($event->getSubject(), Order::STATUS_SUMMARY_FOR_PURCHASE);
    }

    public function onTransitionToOrdered(TransitionEvent $event): void
    {
        $this->updateOrderStatus($event->getSubject(), Order::STATUS_ORDERED);
    }

    public function updateOrderStatus(Order $order, string $status): void
    {
        $this->cartManagerService->updateStatus($order, $status);
    }
}
