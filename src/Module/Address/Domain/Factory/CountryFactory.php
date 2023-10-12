<?php

namespace App\Module\Address\Domain\Factory;

use App\Module\Address\Domain\Entity\Country;

class CountryFactory implements CountryFactoryInterface
{
    public function createEuMember(string $name): Country
    {
        return $this->create($name,true);
    }

    public function create(string $name, ?bool $isMemberOfEu = false): Country
    {
        $country = new Country();
        $country
            ->setName($name)
            ->setIsMemberOfEu($isMemberOfEu);

        return $country;
    }
}