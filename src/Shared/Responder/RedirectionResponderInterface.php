<?php

namespace App\Shared\Responder;

use Symfony\Component\HttpFoundation\RedirectResponse;

interface RedirectionResponderInterface
{
    public function redirectToRoute(string $route, array $parameters = [], int $status = 302): RedirectResponse;

    public function redirect(string $url, int $status = 302): RedirectResponse;
}