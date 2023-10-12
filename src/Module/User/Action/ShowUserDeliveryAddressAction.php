<?php

namespace App\Module\User\Action;

use App\Shared\Service\CurrentUserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Module\User\Repository\UserDeliveryAddressRepository;
use App\Module\User\Responder\ShowUserDeliveryAddressResponder;

#[Route('/user-delivery-address/{id}', name: 'app.address.detail')]
class ShowUserDeliveryAddressAction extends AbstractController
{
    public function __construct(
        private readonly ShowUserDeliveryAddressResponder $responder,
        private readonly UserDeliveryAddressRepository    $userDeliveryAddressRepository,
        private readonly CurrentUserService               $currentUserService,
    )
    {
    }

    public function __invoke(int $id): RedirectResponse|Response
    {
        $userDeliveryAddress = $this->userDeliveryAddressRepository->find($id);
        if (!$userDeliveryAddress) {
            throw $this->responder->createNotFoundException('Delivery address not found!');
        }

        if (!$this->currentUserService->isOwner($userDeliveryAddress)) {
            throw $this->responder->createAccessDeniedException();
        }

        return $this->responder->respond($userDeliveryAddress);
    }
}