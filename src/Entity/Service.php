<?php

/*
 * This file is part of ClubManager API.
 *
 * (c) Frank Niesten <f.niesten@me.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * A service provided by an organization, e.g. delivery service, print services, etc.
 *
 * @see http://schema.org/Service Documentation on Schema.org
 *
 * @ORM\Entity
 * @ApiResource(iri="http://schema.org/Service")
 */
class Service
{
    /**
     * @var int|null
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string|null The type of service being offered, e.g. veterans' benefits, emergency relief, etc.
     *
     * @ORM\Column(type="text", nullable=true)
     * @ApiProperty(iri="http://schema.org/serviceType")
     */
    private $serviceType;

    /**
     * @var string|null a description of the item
     *
     * @ORM\Column(type="text", nullable=true)
     * @ApiProperty(iri="http://schema.org/description")
     */
    private $description;

    /**
     * @var Collection<Organization>|null
     *
     * @ORM\ManyToMany(targetEntity="App\Entity\Organization")
     */
    private $providors;

    /**
     * @var Collection<Review>|null a review of the item
     *
     * @ORM\ManyToMany(targetEntity="App\Entity\Review")
     * @ApiProperty(iri="http://schema.org/review")
     */
    private $reviews;

    /**
     * @var Collection<Service>|null a pointer to another, somehow related product (or multiple products)
     *
     * @ORM\ManyToMany(targetEntity="App\Entity\Service")
     * @ORM\JoinTable(name="service_isRelatedTo")
     * @ApiProperty(iri="http://schema.org/isRelatedTo")
     */
    private $isRelatedTos;

    /**
     * @var Collection<Categorie>|null
     *
     * @ORM\ManyToMany(targetEntity="App\Entity\Categorie")
     */
    private $categories;

    public function __construct()
    {
        $this->providors = new ArrayCollection();
        $this->reviews = new ArrayCollection();
        $this->isRelatedTos = new ArrayCollection();
        $this->categories = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setServiceType(?string $serviceType): void
    {
        $this->serviceType = $serviceType;
    }

    public function getServiceType(): ?string
    {
        return $this->serviceType;
    }

    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function addProvidor(Organization $providor): void
    {
        $this->providors[] = $providor;
    }

    public function removeProvidor(Organization $providor): void
    {
        $this->providors->removeElement($providor);
    }

    public function getProvidors(): Collection
    {
        return $this->providors;
    }

    public function addReview(Review $review): void
    {
        $this->reviews[] = $review;
    }

    public function removeReview(Review $review): void
    {
        $this->reviews->removeElement($review);
    }

    public function getReviews(): Collection
    {
        return $this->reviews;
    }

    public function addIsRelatedTo(Service $isRelatedTo): void
    {
        $this->isRelatedTos[] = $isRelatedTo;
    }

    public function removeIsRelatedTo(Service $isRelatedTo): void
    {
        $this->isRelatedTos->removeElement($isRelatedTo);
    }

    public function getIsRelatedTos(): Collection
    {
        return $this->isRelatedTos;
    }

    public function addCategory(Categorie $category): void
    {
        $this->categories[] = $category;
    }

    public function removeCategory(Categorie $category): void
    {
        $this->categories->removeElement($category);
    }

    public function getCategories(): Collection
    {
        return $this->categories;
    }
}
