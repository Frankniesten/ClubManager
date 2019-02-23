<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass="App\Repository\OfferRepository")
 */
class Offer
{
	use TimestampableEntity;
	
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $availability;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $inventoryLevel;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Service", inversedBy="offers")
     */
    private $itemOffered;

    /**
     * @ORM\Column(type="float", length=255, nullable=true)
     */
    private $price;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $validFrom;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $validThrough;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $availabilityEnds;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $availabilityStarts;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $alternateName;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\OrderItem", mappedBy="orderedItem", orphanRemoval=true)
     */
    private $orderItems;


    public function __construct()
    {
        $this->orders = new ArrayCollection();
        $this->orderItems = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAvailability(): ?string
    {
        return $this->availability;
    }

    public function setAvailability(?string $availability): self
    {
        $this->availability = $availability;

        return $this;
    }

    public function getInventoryLevel(): ?int
    {
        return $this->inventoryLevel;
    }

    public function setInventoryLevel(?int $inventoryLevel): self
    {
        $this->inventoryLevel = $inventoryLevel;

        return $this;
    }

    public function getItemOffered(): ?Service
    {
        return $this->itemOffered;
    }

    public function setItemOffered(?Service $itemOffered): self
    {
        $this->itemOffered = $itemOffered;

        return $this;
    }

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(?string $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getValidFrom(): ?\DateTimeInterface
    {
        return $this->validFrom;
    }

    public function setValidFrom(?\DateTimeInterface $validFrom): self
    {
        $this->validFrom = $validFrom;

        return $this;
    }

    public function getValidThrough(): ?\DateTimeInterface
    {
        return $this->validThrough;
    }

    public function setValidThrough(?\DateTimeInterface $validThrough): self
    {
        $this->validThrough = $validThrough;

        return $this;
    }

    public function getAvailabilityEnds(): ?\DateTimeInterface
    {
        return $this->availabilityEnds;
    }

    public function setAvailabilityEnds(?\DateTimeInterface $availabilityEnds): self
    {
        $this->availabilityEnds = $availabilityEnds;

        return $this;
    }

    public function getAvailabilityStarts(): ?\DateTimeInterface
    {
        return $this->availabilityStarts;
    }

    public function setAvailabilityStarts(?\DateTimeInterface $availabilityStarts): self
    {
        $this->availabilityStarts = $availabilityStarts;

        return $this;
    }

    public function getAlternateName(): ?string
    {
        return $this->alternateName;
    }

    public function setAlternateName(string $alternateName): self
    {
        $this->alternateName = $alternateName;

        return $this;
    }

    /**
     * @return Collection|OrderItem[]
     */
    public function getOrderItems(): Collection
    {
        return $this->orderItems;
    }

    public function addOrderItem(OrderItem $orderItem): self
    {
        if (!$this->orderItems->contains($orderItem)) {
            $this->orderItems[] = $orderItem;
            $orderItem->setOrderedItem($this);
        }

        return $this;
    }

    public function removeOrderItem(OrderItem $orderItem): self
    {
        if ($this->orderItems->contains($orderItem)) {
            $this->orderItems->removeElement($orderItem);
            // set the owning side to null (unless already changed)
            if ($orderItem->getOrderedItem() === $this) {
                $orderItem->setOrderedItem(null);
            }
        }

        return $this;
    }
}
