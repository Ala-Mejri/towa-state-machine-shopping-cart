<?php

namespace App\Module\User\Responder;

use App\Shared\Responder\HtmlResponder;
use Symfony\Component\HttpFoundation\Response;
use App\Module\User\Domain\Entity\UserDeliveryAddress;

class ShowUserDeliveryAddressResponder extends HtmlResponder
{
    public function respond(UserDeliveryAddress $userDeliveryAddress): Response
    {
        return $this->render('address/detail.html.twig', [
            'userDeliveryAddress' => $userDeliveryAddress,
        ]);
    }
}