<?php

namespace App\Module\User\Responder;

use App\Shared\Responder\HtmlResponder;
use Symfony\Component\HttpFoundation\RedirectResponse;

class DeleteUserDeliveryAddressResponder extends HtmlResponder
{
    public function redirect(): RedirectResponse
    {
        return $this->redirectionResponder->redirectToRoute('app.dashboard');
    }
}