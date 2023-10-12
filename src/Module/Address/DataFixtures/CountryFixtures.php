<?php

namespace App\Module\Address\DataFixtures;

use App\Module\Address\Domain\Factory\CityFactoryInterface;
use App\Module\Address\Domain\Factory\CountryFactoryInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CountryFixtures extends Fixture
{
    public function __construct(
        private readonly CountryFactoryInterface $countryFactory,
        private readonly CityFactoryInterface    $cityFactory,
    )
    {
    }

    public function load(ObjectManager $manager): void
    {
        $germany = $this->countryFactory->createEuMember('Switzerland');
        $germany->addCity($this->cityFactory->create('Zürich'));
        $germany->addCity($this->cityFactory->create('Bern'));
        $germany->addCity($this->cityFactory->create('Basel'));
        $germany->addCity($this->cityFactory->create('Lucerne'));
        $manager->persist($germany);

        $canada = $this->countryFactory->create('Canada');
        $canada->addCity($this->cityFactory->create('Toronto'));
        $canada->addCity($this->cityFactory->create('Vancouver'));
        $canada->addCity($this->cityFactory->create('Montreal'));
        $canada->addCity($this->cityFactory->create('Québec City'));
        $manager->persist($canada);

        $germany = $this->countryFactory->createEuMember('Germany');
        $germany->addCity($this->cityFactory->create('Berlin'));
        $germany->addCity($this->cityFactory->create('Munich'));
        $germany->addCity($this->cityFactory->create('Hamburg'));
        $germany->addCity($this->cityFactory->create('Frankfurt'));
        $manager->persist($germany);

        $austria = $this->countryFactory->createEuMember('Austria');
        $austria->addCity($this->cityFactory->create('Vienna'));
        $austria->addCity($this->cityFactory->create('Graz'));
        $austria->addCity($this->cityFactory->create('Villach'));
        $austria->addCity($this->cityFactory->create('Salzburg'));
        $manager->persist($austria);

        $manager->flush();
    }
}
