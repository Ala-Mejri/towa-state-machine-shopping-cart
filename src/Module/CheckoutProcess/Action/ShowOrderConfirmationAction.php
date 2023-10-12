<?php

namespace App\Module\CheckoutProcess\Action;

use App\Shared\Service\FlashService;
use App\Module\CheckoutProcess\Responder\ShowOrderConfirmationResponder;
use App\Module\CheckoutProcess\Service\CartManagerService;
use App\Module\Order\Domain\Entity\Order;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Workflow\WorkflowInterface;

#[Route('/checkout/confirmation', name: 'app.checkout.confirmation')]
class ShowOrderConfirmationAction
{
    public function __construct(
        private readonly ShowOrderConfirmationResponder $responder,
        private readonly FlashService                   $flashService,
        private readonly WorkflowInterface              $checkoutProcessStateMachine,
        private readonly CartManagerService             $cartManagerService,
    )
    {
    }

    public function __invoke(): Response
    {
        $order = $this->cartManagerService->getCurrentCart();
        if (!$this->checkoutProcessStateMachine->can($order, 'to_ordered')) {
            throw $this->responder->createAccessDeniedException('You cant access the order confirmation page!');
        }

        if (!$this->isCheckoutProcessStateMachineInOrderedPlace($order)) {
            $this->checkoutProcessStateMachine->apply($order, 'to_ordered');
            $this->cartManagerService->removeCurrentCart();
            $this->flashService->addSuccessFlash('Your order was placed successfully!');
        }

        return $this->responder->redirect($order);
    }

    private function isCheckoutProcessStateMachineInOrderedPlace(Order $order): bool
    {
        $places = $this->checkoutProcessStateMachine->getMarking($order)->getPlaces();

        return in_array(Order::STATUS_ORDERED, array_keys($places));
    }
}