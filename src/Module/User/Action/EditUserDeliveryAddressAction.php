<?php

namespace App\Module\User\Action;

use App\Shared\Service\CurrentUserService;
use App\Shared\Service\FlashService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Module\User\Domain\Entity\UserDeliveryAddress;
use App\Module\User\Form\UserDeliveryAddressType;
use App\Module\User\Repository\UserDeliveryAddressRepository;
use App\Module\User\Responder\EditUserDeliveryAddressResponder;

#[Route('/user-delivery-address/edit/{id}', name: 'app.address.edit')]
class EditUserDeliveryAddressAction
{
    public function __construct(
        private readonly EditUserDeliveryAddressResponder $responder,
        private readonly FormFactoryInterface             $formFactory,
        private readonly UserDeliveryAddressRepository    $userDeliveryAddressRepository,
        private readonly EntityManagerInterface           $entityManager,
        private readonly CurrentUserService               $currentUserService,
        private readonly FlashService                     $flashService,
    )
    {
    }

    public function __invoke(int $id, Request $request,): Response
    {
        $userDeliveryAddress = $this->userDeliveryAddressRepository->find($id);
        if (!$userDeliveryAddress) {
            throw $this->responder->createNotFoundException('Delivery address not found!');
        }

        if (!$this->currentUserService->isOwner($userDeliveryAddress)) {
            throw $this->responder->createAccessDeniedException();
        }

        $form = $this->formFactory->create(UserDeliveryAddressType::class, $userDeliveryAddress);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userDeliveryAddress = $this->updateDeliveryAddress($userDeliveryAddress, $form);
            $this->flashService->addSuccessFlash('Delivery address was updated successfully!');

            return $this->responder->redirect($userDeliveryAddress);
        }

        return $this->responder->respond($userDeliveryAddress, $form);
    }

    private function updateDeliveryAddress(
        UserDeliveryAddress $userDeliveryAddress,
        FormInterface       $form,
    ): UserDeliveryAddress
    {
        $userDeliveryAddress->setName($form->get('name')->getData());
        $userDeliveryAddress->setCity($form->get('city')->getData());
        $userDeliveryAddress->setTaxNumber($form->get('tax_number')->getData());
        $userDeliveryAddress->setStreet($form->get('street')->getData());
        $userDeliveryAddress->setPostalCode($form->get('postal_code')->getData());
        $userDeliveryAddress->setTelephoneNumber($form->get('telephone_number')->getData());
        $userDeliveryAddress->setEmail($form->get('email')->getData());

        $this->entityManager->flush();

        return $userDeliveryAddress;
    }
}