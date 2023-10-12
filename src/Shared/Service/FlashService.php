<?php

namespace App\Shared\Service;

use Symfony\Component\HttpFoundation\RequestStack;

class FlashService
{
    const TYPE_SUCCESS = 'success';

    const TYPE_NOTICE = 'notice';

    const TYPE_WARNING = 'warning';

    const TYPE_DANGER = 'danger';

    public function __construct(private readonly RequestStack $requestStack)
    {
    }

    public function addNoticeFlash(mixed $message): void
    {
        $this->addFlash(self::TYPE_NOTICE, $message);
    }

    public function addSuccessFlash(mixed $message): void
    {
        $this->addFlash(self::TYPE_SUCCESS, $message);
    }

    public function addWarningFlash(mixed $message): void
    {
        $this->addFlash(self::TYPE_WARNING, $message);
    }

    public function addDangerFlash(mixed $message): void
    {
        $this->addFlash(self::TYPE_DANGER, $message);
    }

    private function addFlash(string $type, mixed $message): void
    {
        $session = $this->requestStack->getSession();

        $session->getFlashBag()->add($type, $message);
    }
}