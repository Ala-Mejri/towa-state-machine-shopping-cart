<?php

namespace App\Shared\Service;

use App\Shared\Interface\BelongsToUserInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class CurrentUserService
{
    public function __construct(private readonly TokenStorageInterface $usageTrackingTokenStorage)
    {
    }

    public function getUser(): ?UserInterface
    {
        return $this->usageTrackingTokenStorage->getToken()?->getUser();
    }

    public function isOwner(BelongsToUserInterface $entity): bool
    {
        return $this->getUser()?->getId() === $entity->getUser()->getId();
    }
}