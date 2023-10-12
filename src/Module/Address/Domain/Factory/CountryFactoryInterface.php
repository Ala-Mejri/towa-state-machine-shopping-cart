<?php

namespace App\Module\Address\Domain\Factory;

use App\Module\Address\Domain\Entity\Country;

interface CountryFactoryInterface
{
    public function createEuMember(string $name): Country;

    public function create(string $name, ?bool $isMemberOfEu = false): Country;
}
