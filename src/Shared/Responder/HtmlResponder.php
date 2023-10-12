<?php

namespace App\Shared\Responder;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Throwable;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

abstract class HtmlResponder implements ResponderInterface
{
    public function __construct(
        private readonly Environment                     $twig,
        protected readonly RedirectionResponderInterface $redirectionResponder
    )
    {
    }

    public function createNotFoundException(string $message = 'Not Found', Throwable $previous = null): NotFoundHttpException
    {
        return new NotFoundHttpException($message, $previous);
    }

    public function createAccessDeniedException(string $message = 'Access Denied.', Throwable $previous = null): AccessDeniedException
    {
        return new AccessDeniedException($message, $previous);
    }

    /**
     * @throws SyntaxError
     * @throws RuntimeError
     * @throws LoaderError
     */
    protected function render(string $view, array $parameters = []): Response
    {
        $content = $this->twig->render($view, $parameters);

        return new Response($content);
    }
}