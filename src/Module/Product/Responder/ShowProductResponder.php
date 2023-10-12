<?php

namespace App\Module\Product\Responder;

use App\Shared\Responder\HtmlResponder;
use App\Module\Product\Domain\Entity\Product;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

class ShowProductResponder extends HtmlResponder
{
    public function respond(Product $product, FormInterface $form): Response
    {
        return $this->render('product/detail.html.twig', [
            'product' => $product,
            'form' => $form->createView(),
        ]);
    }

    public function redirect(Product $product): RedirectResponse
    {
        return $this->redirectionResponder->redirectToRoute('app.product.detail', ['id' => $product->getId()]);
    }
}