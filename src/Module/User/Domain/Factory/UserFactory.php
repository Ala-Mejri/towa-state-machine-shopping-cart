<?php

namespace App\Module\User\Domain\Factory;

use DateTime;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use App\Module\User\Domain\Entity\User;

class UserFactory implements UserFactoryInterface
{
    public function __construct(private UserPasswordHasherInterface $userPasswordHasher)
    {
    }

    public function createAdmin(string $name, string $email, string $password): User
    {
        $user = $this->create($name, $email, $password);
        $user->setRoles([User::ROLE_ADMIN]);

        return $user;
    }

    public function create(string $name, string $email, string $password): User
    {
        $user = new User();
        $user
            ->setName($name)
            ->setEmail($email)
            ->setPassword($password)
            ->setPassword(
                $this->userPasswordHasher->hashPassword(
                    $user,
                    $password
                )
            )
            ->setCreatedAt(new DateTime())
            ->setUpdatedAt(new DateTime());

        return $user;
    }
}