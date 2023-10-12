<?php

namespace App\Module\CheckoutProcess\Action;

use App\Module\CheckoutProcess\Action\Traits\HandleCartFormTrait;
use App\Module\CheckoutProcess\Responder\ShowSummaryResponder;
use App\Module\CheckoutProcess\Service\CartManagerService;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Workflow\WorkflowInterface;

#[Route('/checkout/summary', name: 'app.checkout.summary')]
class ShowSummaryAction
{
    use HandleCartFormTrait;

    public function __construct(
        private readonly ShowSummaryResponder $responder,
        private readonly FormFactoryInterface $formFactory,
        private readonly WorkflowInterface    $checkoutProcessStateMachine,
        private readonly CartManagerService   $cartManagerService,
    )
    {
    }

    public function __invoke(Request $request): Response
    {
        $order = $this->cartManagerService->getCurrentCart();
        if (!$this->checkoutProcessStateMachine->can($order, 'to_summary_for_purchase')) {
            throw $this->responder->createAccessDeniedException('You cant access the summary page!');
        }

        $this->checkoutProcessStateMachine->apply($order, 'to_summary_for_purchase');
        $cartForm = $this->handleCartForm($request, $order);

        return $this->responder->respond($order, $cartForm);
    }
}