<?php

namespace App\Module\Home\Action;

use App\Module\Home\Responder\HomeResponder;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/', name: 'app.home')]
class HomeAction extends AbstractController
{
 public function __construct(private readonly HomeResponder $responder)
 {
 }

    public function __invoke(): Response
    {
        return $this->responder->respond();
    }
}
