<?php

namespace App\Module\User\Action;

use App\Shared\Service\CurrentUserService;
use App\Shared\Service\FlashService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Module\User\Repository\UserDeliveryAddressRepository;
use App\Module\User\Responder\DeleteUserDeliveryAddressResponder;

#[Route('/user-delivery-address/delete/{id}', name: 'app.address.delete', methods: ['GET', 'DELETE'])]
class DeleteUserDeliveryAddressAction
{
    public function __construct(
        private readonly DeleteUserDeliveryAddressResponder $responder,
        private readonly UserDeliveryAddressRepository      $userDeliveryAddressRepository,
        private readonly EntityManagerInterface             $entityManager,
        private readonly CurrentUserService                 $currentUserService,
        private readonly FlashService                       $flashService,
    )
    {
    }

    public function __invoke(int $id): Response
    {
        $userDeliveryAddress = $this->userDeliveryAddressRepository->find($id);
        if (!$userDeliveryAddress) {
            throw $this->responder->createNotFoundException('Delivery address not found!');
        }

        if (!$this->currentUserService->isOwner($userDeliveryAddress)) {
            throw $this->responder->createAccessDeniedException();
        }

        $this->entityManager->remove($userDeliveryAddress);
        $this->entityManager->flush();

        $this->flashService->addSuccessFlash('Delivery address was deleted successfully!');

        return $this->responder->redirect();
    }
}