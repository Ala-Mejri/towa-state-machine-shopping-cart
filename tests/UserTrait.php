<?php

namespace App\Tests;

use App\Module\User\Repository\UserRepository;
use Symfony\Component\Security\Core\User\UserInterface;


trait UserTrait
{
    private function getUser(): UserInterface
    {
        $userRepository = static::getContainer()->get(UserRepository::class);

        return $userRepository->findOneBy([]);
    }
}