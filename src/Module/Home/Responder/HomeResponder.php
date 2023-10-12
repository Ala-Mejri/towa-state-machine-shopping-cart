<?php

namespace App\Module\Home\Responder;

use App\Shared\Responder\HtmlResponder;
use Symfony\Component\HttpFoundation\Response;

class HomeResponder extends HtmlResponder
{
    public function respond(): Response
    {
        return $this->render('home/index.html.twig');
    }
}