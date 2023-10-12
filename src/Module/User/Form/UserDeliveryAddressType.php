<?php

namespace App\Module\User\Form;

use App\Module\Address\Form\AbstractDeliveryAddressType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Module\User\Domain\Entity\UserDeliveryAddress;

class UserDeliveryAddressType extends AbstractDeliveryAddressType
{
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => UserDeliveryAddress::class,
        ]);
    }
}
