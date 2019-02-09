<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass="App\Repository\ServiceRepository")
 */
class Service
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $serviceType;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $availableChannel;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Categorie", inversedBy="services")
     */
    private $categorie;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Review", mappedBy="service")
     */
    private $Review;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Offer", mappedBy="itemOffered")
     */
    private $offers;

    public function __construct()
    {
        $this->Review = new ArrayCollection();
        $this->offers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getServiceType(): ?string
    {
        return $this->serviceType;
    }

    public function setServiceType(string $serviceType): self
    {
        $this->serviceType = $serviceType;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getAvailableChannel(): ?string
    {
        return $this->availableChannel;
    }

    public function setAvailableChannel(?string $availableChannel): self
    {
        $this->availableChannel = $availableChannel;

        return $this;
    }

    public function getCategorie(): ?Categorie
    {
        return $this->categorie;
    }

    public function setCategorie(?Categorie $categorie): self
    {
        $this->categorie = $categorie;

        return $this;
    }

    /**
     * @return Collection|Review[]
     */
    public function getReview(): Collection
    {
        return $this->Review;
    }

    public function addReview(Review $review): self
    {
        if (!$this->Review->contains($review)) {
            $this->Review[] = $review;
            $review->setService($this);
        }

        return $this;
    }

    public function removeReview(Review $review): self
    {
        if ($this->Review->contains($review)) {
            $this->Review->removeElement($review);
            // set the owning side to null (unless already changed)
            if ($review->getService() === $this) {
                $review->setService(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Offer[]
     */
    public function getOffers(): Collection
    {
        return $this->offers;
    }

    public function addOffer(Offer $offer): self
    {
        if (!$this->offers->contains($offer)) {
            $this->offers[] = $offer;
            $offer->setItemOffered($this);
        }

        return $this;
    }

    public function removeOffer(Offer $offer): self
    {
        if ($this->offers->contains($offer)) {
            $this->offers->removeElement($offer);
            // set the owning side to null (unless already changed)
            if ($offer->getItemOffered() === $this) {
                $offer->setItemOffered(null);
            }
        }

        return $this;
    }
}