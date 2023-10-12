<?php

namespace App\Module\Product\Responder;

use App\Shared\Responder\HtmlResponder;
use App\Module\Product\Domain\Entity\Product;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

class CreateProductResponder extends HtmlResponder
{
    public function respond(FormInterface $form): Response
    {
        return $this->render('product/create.html.twig', [
            'form' => $form->createView(),
            'title' => 'Add a new product',
        ]);
    }

    public function redirect(Product $product): RedirectResponse
    {
        return $this->redirectionResponder->redirectToRoute('app.product.detail', [
            'id' => $product->getId(),
        ]);
    }
}