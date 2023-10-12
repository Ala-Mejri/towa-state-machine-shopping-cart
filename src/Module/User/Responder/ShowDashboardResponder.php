<?php

namespace App\Module\User\Responder;

use App\Shared\Responder\HtmlResponder;
use Symfony\Component\HttpFoundation\Response;

class ShowDashboardResponder extends HtmlResponder
{
    public function respond(array $orders): Response
    {
        return $this->render('user/dashboard.html.twig', [
            'orders' => $orders,
        ]);
    }
}