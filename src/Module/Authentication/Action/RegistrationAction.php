<?php

namespace App\Module\Authentication\Action;

use App\Module\Authentication\Responder\RegistrationResponder;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use App\Module\User\Domain\Entity\User;
use App\Module\User\Form\RegistrationFormType;

#[Route('/register', name: 'app_register')]
class RegistrationAction
{
    public function __construct(
        private readonly RegistrationResponder       $responder,
        private readonly FormFactoryInterface        $formFactory,
        private readonly UserPasswordHasherInterface $userPasswordHasher,
        private readonly EntityManagerInterface      $entityManager,
    )
    {
    }

    public function __invoke(Request $request): Response
    {
        $user = new User();
        $form = $this->formFactory->create(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $this->userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $this->entityManager->persist($user);
            $this->entityManager->flush();
            // do anything else you need here, like send an email

            return $this->responder->redirect();
        }

        return $this->responder->respond($form);
    }
}
