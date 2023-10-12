<?php

namespace App\Module\User\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Module\User\Domain\Factory\UserFactoryInterface;

class UserFixtures extends Fixture
{
    public function __construct(private readonly UserFactoryInterface $userFactory)
    {
    }

    public function load(ObjectManager $manager): void
    {
        $user = $this->userFactory->createAdmin('Towa admin', 'admin@towa.de', '123456');
        $manager->persist($user);

        $user = $this->userFactory->create('Towa user', 'user@towa.de', '123456');
        $manager->persist($user);

        $manager->flush();
    }
}
