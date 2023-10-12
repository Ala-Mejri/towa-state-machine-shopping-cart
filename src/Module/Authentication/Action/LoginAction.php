<?php

namespace App\Module\Authentication\Action;

use App\Module\Authentication\Responder\LoginResponder;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

#[Route(path: '/login', name: 'app_login')]
class LoginAction
{
    public function __construct(
        private readonly LoginResponder      $responder,
        private readonly AuthenticationUtils $authenticationUtils,
    )
    {
    }

    public function __invoke(): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $this->authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $this->authenticationUtils->getLastUsername();

        return $this->responder->respond($lastUsername, $error);
    }
}