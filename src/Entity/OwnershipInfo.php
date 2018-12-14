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
 * A structured value providing information about when a certain organization or person owned a certain product.
 *
 * @see http://schema.org/OwnershipInfo Documentation on Schema.org
 *
 * @ORM\Entity
 * @ApiResource(iri="http://schema.org/OwnershipInfo")
 */
class OwnershipInfo
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
     * @var Organization|null the organization or person from which the product was acquired
     *
     * @ORM\OneToOne(targetEntity="App\Entity\Organization")
     * @ApiProperty(iri="http://schema.org/acquiredFrom")
     */
    private $acquiredFrom;

    /**
     * @var \DateTimeInterface|null the date and time of obtaining the product
     *
     * @ORM\Column(type="datetime", nullable=true)
     * @ApiProperty(iri="http://schema.org/ownedFrom")
     * @Assert\DateTime
     */
    private $ownedFrom;

    /**
     * @var \DateTimeInterface|null the date and time of giving up ownership on the product
     *
     * @ORM\Column(type="datetime", nullable=true)
     * @ApiProperty(iri="http://schema.org/ownedThrough")
     * @Assert\DateTime
     */
    private $ownedThrough;

    /**
     * @var Collection<Product>|null
     *
     * @ORM\ManyToMany(targetEntity="App\Entity\Product")
     */
    private $typeofGoods;

    /**
     * @var Collection<Categorie>|null
     *
     * @ORM\ManyToMany(targetEntity="App\Entity\Categorie")
     */
    private $categories;

    public function __construct()
    {
        $this->typeofGoods = new ArrayCollection();
        $this->categories = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setAcquiredFrom(?Organization $acquiredFrom): void
    {
        $this->acquiredFrom = $acquiredFrom;
    }

    public function getAcquiredFrom(): ?Organization
    {
        return $this->acquiredFrom;
    }

    public function setOwnedFrom(?\DateTimeInterface $ownedFrom): void
    {
        $this->ownedFrom = $ownedFrom;
    }

    public function getOwnedFrom(): ?\DateTimeInterface
    {
        return $this->ownedFrom;
    }

    public function setOwnedThrough(?\DateTimeInterface $ownedThrough): void
    {
        $this->ownedThrough = $ownedThrough;
    }

    public function getOwnedThrough(): ?\DateTimeInterface
    {
        return $this->ownedThrough;
    }

    public function addTypeofGood(Product $typeofGood): void
    {
        $this->typeofGoods[] = $typeofGood;
    }

    public function removeTypeofGood(Product $typeofGood): void
    {
        $this->typeofGoods->removeElement($typeofGood);
    }

    public function getTypeofGoods(): Collection
    {
        return $this->typeofGoods;
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
