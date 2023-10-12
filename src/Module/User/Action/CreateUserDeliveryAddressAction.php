<?php

namespace App\Module\User\Action;

use App\Shared\Service\CurrentUserService;
use App\Shared\Service\FlashService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Module\User\Domain\Entity\UserDeliveryAddress;
use App\Module\User\Form\UserDeliveryAddressType;
use App\Module\User\Responder\CreateUserDeliveryAddressResponder;

#[Route('/user-delivery-address/create', name: 'app.address.create')]
class CreateUserDeliveryAddressAction
{
    public function __construct(
        private readonly CreateUserDeliveryAddressResponder $responder,
        private readonly EntityManagerInterface             $entityManager,
        private readonly FormFactoryInterface               $formFactory,
        private readonly FlashService                       $flashService,
        private readonly CurrentUserService                 $currentUserService,
    )
    {
    }

    public function __invoke(Request $request): Response
    {
        $userDeliveryAddress = new UserDeliveryAddress();
        $form = $this->formFactory->create(UserDeliveryAddressType::class, $userDeliveryAddress);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->saveUserDeliveryAddress($form->getData());
            $this->flashService->addSuccessFlash('Delivery address was created successfully!');

            return $this->responder->redirect();
        }

        return $this->responder->respond($form);
    }

    private function saveUserDeliveryAddress(UserDeliveryAddress $userDeliveryAddress): void
    {
        $userDeliveryAddress->setUser($this->currentUserService->getUser());
        $this->entityManager->persist($userDeliveryAddress);
        $this->entityManager->flush();
    }
}