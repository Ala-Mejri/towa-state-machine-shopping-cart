<?php

namespace App\Module\User\Domain\Factory;

use App\Module\User\Domain\Entity\User;

interface UserFactoryInterface
{
    public function createAdmin(string $name, string $email, string $password): User;

    public function create(string $name, string $email, string $password): User;
}