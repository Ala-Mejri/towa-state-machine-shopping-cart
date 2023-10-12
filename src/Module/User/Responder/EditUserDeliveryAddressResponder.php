<?php

namespace App\Module\User\Responder;

use App\Shared\Responder\HtmlResponder;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use App\Module\User\Domain\Entity\UserDeliveryAddress;

class EditUserDeliveryAddressResponder extends HtmlResponder
{
    public function respond(UserDeliveryAddress $userDeliveryAddress, FormInterface $form): Response
    {
        return $this->render('address/edit.html.twig', [
            'product' => $userDeliveryAddress,
            'form' => $form->createView(),
            'title' => 'Edit delivery address',
        ]);
    }

    public function redirect(UserDeliveryAddress $userDeliveryAddress): RedirectResponse
    {

        return $this->redirectionResponder->redirectToRoute('app.dashboard', [
            'id' => $userDeliveryAddress->getId(),
        ]);
    }
}