<?php

namespace App\Module\Product\Responder;

use App\Shared\Responder\HtmlResponder;
use Symfony\Component\HttpFoundation\Response;

class ListProductsResponder extends HtmlResponder
{
    public function respond(array $products): Response
    {
        return $this->render('product/index.html.twig', ['products' => $products]);
    }
}