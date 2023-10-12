<?php

namespace App\Module\Authentication\Action;

use LogicException;
use Symfony\Component\Routing\Annotation\Route;

#[Route(path: '/logout', name: 'app_logout')]
class LogoutAction
{
    public function __invoke(): void
    {
        throw new LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}