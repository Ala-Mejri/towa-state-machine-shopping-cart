<?php

namespace App\Module\Product\Responder;

use App\Shared\Responder\HtmlResponder;
use Symfony\Component\HttpFoundation\RedirectResponse;

class DeleteProductResponder extends HtmlResponder
{
    public function redirect(): RedirectResponse
    {
        return $this->redirectionResponder->redirectToRoute('app.product.list');
    }
}