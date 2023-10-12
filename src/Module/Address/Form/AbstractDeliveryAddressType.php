<?php

namespace App\Module\Address\Form;

use App\Module\Address\Domain\Entity\City;
use App\Module\Address\Domain\Entity\Country;
use App\Module\Address\Form\EventListener\DeliveryAddressTypeListener;
use App\Module\Address\Repository\CityRepository;
use App\Module\Address\Repository\CountryRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

abstract class AbstractDeliveryAddressType extends AbstractType
{
    public function __construct(
        private readonly CountryRepository $countryRepository,
        private readonly CityRepository    $cityRepository,
    )
    {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class)
            ->add('country', EntityType::class, [
                'class' => Country::class,
                'mapped' => false,
            ])
            ->add('city', EntityType::class, [
                'class' => City::class,
                'choices' => [],
            ])
            ->add('tax_number', IntegerType::class)
            ->add('street', TextType::class)
            ->add('postal_code', IntegerType::class)
            ->add('telephone_number', TextType::class)
            ->add('email', TextType::class)
            ->add('submit', SubmitType::class);

        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function (FormEvent $event): void {
                $form = $event->getForm();
                $data = $event->getData();

                $country = $data->getCity()?->getCountry();
                $country ??= $this->countryRepository->getFirst();

                if (!$country instanceof Country) {
                    return;
                }

                if (!$country->isIsMemberOfEu()) {
                    $form->remove('tax_number');
                }

                $form->add('city', EntityType::class, [
                    'class' => City::class,
                    'choices' => $country->getCities(),
                ]);
            }
        );

        $builder->get('country')->addEventSubscriber(new DeliveryAddressTypeListener($this->cityRepository));
    }
}
