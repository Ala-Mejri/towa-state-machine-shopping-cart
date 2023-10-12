<?php

namespace App\Module\Address\Form\EventListener;

use App\Module\Address\Domain\Entity\City;
use App\Module\Address\Domain\Entity\Country;
use App\Module\Address\Repository\CityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class DeliveryAddressTypeListener implements EventSubscriberInterface
{
    public function __construct(private readonly CityRepository $cityRepository)
    {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            FormEvents::POST_SUBMIT => 'postSubmit',
        ];
    }

    public function postSubmit(FormEvent $event): void
    {
        $form = $event->getForm();
        $country = $form->getData();

        $cities = $country instanceof Country
            ? $country->getCities()
            : $this->cityRepository->findByCountry(1);

        $form->getParent()->add('city', EntityType::class, [
            'class' => City::class,
            'choices' => $cities,
        ]);

        if ($country instanceof Country && $country?->isIsMemberOfEu()) {
            $form->getParent()->add('tax_number', NumberType::class);
        } else {
            $form->getParent()->remove('tax_number');
        }
    }
}