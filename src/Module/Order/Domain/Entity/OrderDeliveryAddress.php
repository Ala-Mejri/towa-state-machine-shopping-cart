<?php

namespace App\Module\Order\Domain\Entity;

use App\Module\Address\Domain\Entity\City;
use Doctrine\ORM\Mapping as ORM;
use App\Module\Order\Repository\OrderDeliveryAddressRepository;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: OrderDeliveryAddressRepository::class)]
class OrderDeliveryAddress
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    #[Assert\Length(max: 50)]
    private ?string $name = null;

    #[ORM\Column(length: 100)]
    #[Assert\Email]
    #[Assert\Length(max: 100)]
    private ?string $email = null;

    #[ORM\Column]
    #[Assert\Positive]
    #[Assert\Length(max: 10)]
    private ?string $telephone_number = null;

    #[ORM\Column(length: 150)]
    #[Assert\Length(max: 150)]
    private ?string $street = null;

    #[ORM\Column]
    #[Assert\Positive]
    #[Assert\Length(max: 8)]
    private ?int $postal_code = null;

    #[ORM\Column(length: 12, nullable: true)]
    #[Assert\Length(max: 12)]
    private ?string $tax_number = null;

    #[ORM\ManyToOne()]
    #[ORM\JoinColumn(nullable: false)]
    private ?City $City = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getTelephoneNumber(): ?string
    {
        return $this->telephone_number;
    }

    public function setTelephoneNumber(string $telephone_number): static
    {
        $this->telephone_number = $telephone_number;

        return $this;
    }

    public function getStreet(): ?string
    {
        return $this->street;
    }

    public function setStreet(string $street): static
    {
        $this->street = $street;

        return $this;
    }

    public function getPostalCode(): ?int
    {
        return $this->postal_code;
    }

    public function setPostalCode(int $postal_code): static
    {
        $this->postal_code = $postal_code;

        return $this;
    }

    public function getTaxNumber(): ?int
    {
        return $this->tax_number;
    }

    public function setTaxNumber(?int $tax_number): static
    {
        $this->tax_number = $tax_number;

        return $this;
    }

    public function getCity(): ?City
    {
        return $this->City;
    }

    public function setCity(?City $City): static
    {
        $this->City = $City;

        return $this;
    }

    #[ORM\OneToOne(inversedBy: 'deliveryAddress', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Order $orderRelation = null;

    public function getOrderRelation(): ?Order
    {
        return $this->orderRelation;
    }

    public function setOrderRelation(Order $orderRelation): static
    {
        $this->orderRelation = $orderRelation;

        return $this;
    }

    public function __toString(): string
    {
        return $this->getName()
            . ', ' . $this->getStreet()
            . ' ' . $this->getPostalCode()
            . ' ' . $this->getCity()
            . ', ' . $this->getCity()->getCountry();
    }
}
