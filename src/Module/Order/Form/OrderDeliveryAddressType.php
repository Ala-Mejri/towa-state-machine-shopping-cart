<?php

namespace App\Module\Order\Form;

use App\Module\Address\Form\AbstractDeliveryAddressType;
use App\Module\Order\Domain\Entity\OrderDeliveryAddress;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OrderDeliveryAddressType extends AbstractDeliveryAddressType
{
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => OrderDeliveryAddress::class,
        ]);
    }
}
