<?php

namespace App\Shared\Responder;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Throwable;

interface ResponderInterface
{
    public function createNotFoundException(string $message = 'Not Found', Throwable $previous = null): NotFoundHttpException;

    public function createAccessDeniedException(string $message = 'Access Denied.', Throwable $previous = null): AccessDeniedException;
}