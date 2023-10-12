<?php

namespace App\Module\Authentication\Responder;

use App\Shared\Responder\HtmlResponder;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AuthenticationException;

class LoginResponder extends HtmlResponder
{
    public function respond(string $lastUsername, ?AuthenticationException $error): Response
    {
        return $this->render('authentication/login.html.twig',[
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }
}