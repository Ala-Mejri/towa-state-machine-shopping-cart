<?php

namespace App\Module\Authentication\Responder;

use App\Shared\Responder\HtmlResponder;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

class RegistrationResponder extends HtmlResponder
{
    public function respond(FormInterface $form): Response
    {
        return $this->render('authentication/register.html.twig', ['form' => $form->createView()]);
    }

    public function redirect(): RedirectResponse
    {
        return $this->redirectionResponder->redirectToRoute('app.home');
    }
}