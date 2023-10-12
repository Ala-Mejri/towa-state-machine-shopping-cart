<?php

namespace App\Module\Address\Domain\Factory;

use App\Module\Address\Domain\Entity\City;

interface CityFactoryInterface
{
    public function create(string $name): City;
}