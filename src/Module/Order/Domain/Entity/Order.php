<?php

namespace App\Module\Order\Domain\Entity;

use App\Shared\Interface\BelongsToUserInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Module\Order\Repository\OrderRepository;
use Symfony\Component\Validator\Constraints as Assert;
use App\Module\User\Domain\Entity\User;

#[ORM\Entity(repositoryClass: OrderRepository::class)]
#[ORM\Table(name: '`order`')]
class Order implements BelongsToUserInterface
{
    const STATUS_SHOPPING_CART = 'shopping_cart';

    const STATUS_DELIVERY_ADDRESS = 'delivery_address';

    const STATUS_SUMMARY_FOR_PURCHASE = 'summary_for_purchase';

    const STATUS_ORDERED = 'ordered';

    const SHIPPING_COST = 5;

    const VAT_PERCENTAGE = 19;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToMany(mappedBy: 'orderRelation', targetEntity: OrderItem::class, cascade: ['persist', 'remove'], orphanRemoval: true)]
    private Collection $items;

    #[ORM\Column(length: 50)]
    #[Assert\Choice([self::STATUS_SHOPPING_CART, self::STATUS_DELIVERY_ADDRESS, self::STATUS_SUMMARY_FOR_PURCHASE, self::STATUS_ORDERED])]
    private ?string $status = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $createdAt = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $updatedAt = null;

    #[ORM\OneToOne(mappedBy: 'orderRelation', cascade: ['persist', 'remove'])]
    private ?OrderDeliveryAddress $deliveryAddress = null;

    #[ORM\ManyToOne(inversedBy: 'orders')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    public function __construct()
    {
        $this->items = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection<int, OrderItem>
     */
    public function getItems(): Collection
    {
        return $this->items;
    }

    public function addItem(OrderItem $item): static
    {
        foreach ($this->getItems() as $existingItem) {
            // If the item already exists, update the quantity
            if ($existingItem->equals($item)) {
                $existingItem->setQuantity(
                    $existingItem->getQuantity() + $item->getQuantity()
                );
                return $this;
            }
        }

        $this->items[] = $item;
        $item->setOrderRelation($this);

        return $this;
    }

    public function removeItem(OrderItem $item): static
    {
        if ($this->items->removeElement($item)) {
            // set the owning side to null (unless already changed)
            if ($item->getOrderRelation() === $this) {
                $item->setOrderRelation(null);
            }
        }

        return $this;
    }

    public function removeItems(): static
    {
        foreach ($this->getItems() as $item) {
            $this->removeItem($item);
        }

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getShippingCost(): float
    {
        return static::SHIPPING_COST * $this->getItems()->count();
    }

    public function getVatCost(): float
    {
        return ($this->getSubtotal() * self::VAT_PERCENTAGE) / 100;
    }

    public function getSubtotal(): float
    {
        $total = 0;

        foreach ($this->getItems() as $item) {
            $total += $item->getTotal();
        }

        return $total;
    }

    public function getTotal(): float
    {
        return $this->getSubtotal() + $this->getVatCost() + $this->getShippingCost();
    }

    public function getDeliveryAddress(): ?OrderDeliveryAddress
    {
        return $this->deliveryAddress;
    }

    public function setDeliveryAddress(OrderDeliveryAddress $deliveryAddress): static
    {
        // set the owning side of the relation if necessary
        if ($deliveryAddress->getOrderRelation() !== $this) {
            $deliveryAddress->setOrderRelation($this);
        }

        $this->deliveryAddress = $deliveryAddress;

        return $this;
    }

    public function __toString(): string
    {
        return 'Order#' . $this->getId() . ' - €' . $this->getTotal() . '';
    }
}
