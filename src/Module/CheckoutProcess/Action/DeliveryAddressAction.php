<?php

namespace App\Module\CheckoutProcess\Action;

use App\Shared\Service\FlashService;
use App\Module\CheckoutProcess\Action\Traits\HandleCartFormTrait;
use App\Module\CheckoutProcess\Business\GetCheckoutDeliveryAddress;
use App\Module\CheckoutProcess\Business\SaveCheckoutDeliveryAddress;
use App\Module\CheckoutProcess\Responder\DeliveryAddressResponder;
use App\Module\CheckoutProcess\Service\CartManagerService;
use App\Module\Order\Form\OrderDeliveryAddressType;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Workflow\WorkflowInterface;

#[Route('checkout/address', name: 'app.checkout.address')]
class DeliveryAddressAction
{
    use HandleCartFormTrait;

    public function __construct(
        private readonly DeliveryAddressResponder    $responder,
        private readonly FlashService                $flashService,
        private readonly FormFactoryInterface        $formFactory,
        private readonly WorkflowInterface           $checkoutProcessStateMachine,
        private readonly CartManagerService          $cartManagerService,
        private readonly GetCheckoutDeliveryAddress  $getOrderDeliveryAddress,
        private readonly SaveCheckoutDeliveryAddress $saveCheckoutDeliveryAddress,
    )
    {
    }

    public function __invoke(Request $request): Response
    {
        $order = $this->cartManagerService->getCurrentCart();

        if (!$this->checkoutProcessStateMachine->can($order, 'to_delivery_address')
            || $this->cartManagerService->isEmpty($order)
        ) {
            throw $this->responder->createAccessDeniedException('You cant access the delivery address page!');
        }

        $orderDeliveryAddress = $this->getOrderDeliveryAddress->getDeliveryAddress($order);

        $form = $this->formFactory->create(OrderDeliveryAddressType::class, $orderDeliveryAddress);
        $form->handleRequest($request);

        if (!$request->isxmlhttprequest() && $form->isSubmitted() && $form->isValid()) {
            $this->saveCheckoutDeliveryAddress->saveDeliveryAddresses($order, $form->getData());
            $this->checkoutProcessStateMachine->apply($order, 'to_delivery_address');
            $this->flashService->addSuccessFlash('You delivery address was saved successfully!');

            return $this->responder->redirect();
        }

        $cartForm = $this->handleCartForm($request, $order);

        return $this->responder->respond($order, $form, $cartForm);
    }
}
