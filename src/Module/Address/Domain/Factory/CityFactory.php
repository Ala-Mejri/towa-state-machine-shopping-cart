<?php

namespace App\Module\Address\Domain\Factory;

use App\Module\Address\Domain\Entity\City;

class CityFactory implements CityFactoryInterface
{
    public function create(string $name): City
    {
        $city = new City();
        $city->setName($name);

        return $city;
    }
}