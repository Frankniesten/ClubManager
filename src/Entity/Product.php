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
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Any offered product or service. For example: a pair of shoes; a concert ticket; the rental of a car; a haircut; or an episode of a TV show streamed online.
 *
 * @see http://schema.org/Product Documentation on Schema.org
 *
 * @ORM\Entity
 * @ApiResource(iri="http://schema.org/Product")
 */
class Product
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
     * @var string the name of the item
     *
     * @ORM\Column(type="text")
     * @ApiProperty(iri="http://schema.org/name")
     * @Assert\NotNull
     */
    private $name;

    /**
     * @var string|null a description of the item
     *
     * @ORM\Column(type="text", nullable=true)
     * @ApiProperty(iri="http://schema.org/description")
     */
    private $description;

    /**
     * @var string|null The product identifier, such as ISBN. For example: ``` meta itemprop="productID" content="isbn:123-456-789" ```.
     *
     * @ORM\Column(type="text", nullable=true)
     * @ApiProperty(iri="http://schema.org/productID")
     */
    private $productID;

    /**
     * @var string|null The model of the product. Use with the URL of a ProductModel or a textual representation of the model identifier. The URL of the ProductModel can be from an external source. It is recommended to additionally provide strong product identifiers via the gtin8/gtin13/gtin14 and mpn properties.
     *
     * @ORM\Column(type="text", nullable=true)
     * @ApiProperty(iri="http://schema.org/model")
     */
    private $model;

    /**
     * @var string|null the manufacturer of the product
     *
     * @ORM\Column(type="text", nullable=true)
     * @ApiProperty(iri="http://schema.org/manufacturer")
     */
    private $manufacturer;

    /**
     * @var \DateTimeInterface|null The date the item e.g. vehicle was purchased by the current owner.
     *
     * @ORM\Column(type="date", nullable=true)
     * @ApiProperty(iri="http://schema.org/purchaseDate")
     * @Assert\Date
     */
    private $purchaseDate;

    /**
     * @var Collection<Review>|null a review of the item
     *
     * @ORM\ManyToMany(targetEntity="App\Entity\Review")
     * @ApiProperty(iri="http://schema.org/review")
     */
    private $reviews;

    /**
     * @var Collection<Product>|null a pointer to another, somehow related product (or multiple products)
     *
     * @ORM\ManyToMany(targetEntity="App\Entity\Product")
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
        $this->reviews = new ArrayCollection();
        $this->isRelatedTos = new ArrayCollection();
        $this->categories = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setProductID(?string $productID): void
    {
        $this->productID = $productID;
    }

    public function getProductID(): ?string
    {
        return $this->productID;
    }

    public function setModel(?string $model): void
    {
        $this->model = $model;
    }

    public function getModel(): ?string
    {
        return $this->model;
    }

    public function setManufacturer(?string $manufacturer): void
    {
        $this->manufacturer = $manufacturer;
    }

    public function getManufacturer(): ?string
    {
        return $this->manufacturer;
    }

    public function setPurchaseDate(?\DateTimeInterface $purchaseDate): void
    {
        $this->purchaseDate = $purchaseDate;
    }

    public function getPurchaseDate(): ?\DateTimeInterface
    {
        return $this->purchaseDate;
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

    public function addIsRelatedTo(Product $isRelatedTo): void
    {
        $this->isRelatedTos[] = $isRelatedTo;
    }

    public function removeIsRelatedTo(Product $isRelatedTo): void
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
