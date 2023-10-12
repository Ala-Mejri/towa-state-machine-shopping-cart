<?php

namespace App\Module\User\Responder;

use App\Shared\Responder\HtmlResponder;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

class CreateUserDeliveryAddressResponder extends HtmlResponder
{
    public function respond(FormInterface $form): Response
    {
        return $this->render('address/create.html.twig', [
            'form' => $form->createView(),
            'title' => 'Add a new delivery address',
        ]);
    }

    public function redirect(): RedirectResponse
    {
        return $this->redirectionResponder->redirectToRoute('app.dashboard');
    }
}