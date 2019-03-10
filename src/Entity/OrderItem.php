<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Gedmo\Blameable\Traits\BlameableEntity;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass="App\Repository\OrderItemRepository")
 * @Gedmo\Loggable
 */
class OrderItem
{
	use TimestampableEntity;
	use BlameableEntity;
	
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Offer", inversedBy="orderItems")
     * @Gedmo\Versioned
     */
    private $orderedItem;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Gedmo\Versioned
     */
    private $orderQuantity;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Orders", inversedBy="orderItem")
     * @Gedmo\Versioned
     */
    private $orders;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOrderedItem(): ?Offer
    {
        return $this->orderedItem;
    }

    public function setOrderedItem(?Offer $orderedItem): self
    {
        $this->orderedItem = $orderedItem;

        return $this;
    }

    public function getOrderQuantity(): ?int
    {
        return $this->orderQuantity;
    }

    public function setOrderQuantity(?int $orderQuantity): self
    {
        $this->orderQuantity = $orderQuantity;

        return $this;
    }

    public function getOrders(): ?Orders
    {
        return $this->orders;
    }

    public function setOrders(?Orders $orders): self
    {
        $this->orders = $orders;

        return $this;
    }
}
