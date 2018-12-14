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
 * An organization such as a school, NGO, corporation, club, etc.
 *
 * @see http://schema.org/Organization Documentation on Schema.org
 *
 * @ORM\Entity
 * @ApiResource(iri="http://schema.org/Organization")
 */
class Organization
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
     * @var string The official name of the organization, e.g. the registered company name.
     *
     * @ORM\Column(type="text")
     * @ApiProperty(iri="http://schema.org/legalName")
     * @Assert\NotNull
     */
    private $legalName;

    /**
     * @var string|null a description of the item
     *
     * @ORM\Column(type="text", nullable=true)
     * @ApiProperty(iri="http://schema.org/description")
     */
    private $description;

    /**
     * @var string|null email address
     *
     * @ORM\Column(type="text", nullable=true)
     * @ApiProperty(iri="http://schema.org/email")
     * @Assert\Email
     */
    private $email;

    /**
     * @var Collection<PostalAddress>|null
     *
     * @ORM\ManyToMany(targetEntity="App\Entity\PostalAddress")
     */
    private $adresses;

    /**
     * @var string|null the telephone number
     *
     * @ORM\Column(type="text", nullable=true)
     * @ApiProperty(iri="http://schema.org/telephone")
     */
    private $telephone;

    /**
     * @var string
     *
     * @ORM\Column(type="text")
     * @Assert\NotNull
     */
    private $mobilePhone;

    /**
     * @var Collection<Person>|null someone working for this organization
     *
     * @ORM\ManyToMany(targetEntity="App\Entity\Person")
     * @ApiProperty(iri="http://schema.org/employee")
     */
    private $employees;

    /**
     * @var string|null an organization identifier that uniquely identifies a legal entity as defined in ISO 17442
     *
     * @ORM\Column(type="text", nullable=true)
     * @ApiProperty(iri="http://schema.org/leiCode")
     */
    private $leiCode;

    /**
     * @var string|null the Value-added Tax ID of the organization or person
     *
     * @ORM\Column(type="text", nullable=true)
     * @ApiProperty(iri="http://schema.org/vatID")
     */
    private $vatID;

    /**
     * @var string|null URL of the item
     *
     * @ORM\Column(type="text", nullable=true)
     * @ApiProperty(iri="http://schema.org/url")
     * @Assert\Url
     */
    private $url;

    /**
     * @var Collection<OwnershipInfo>|null products owned by the organization or person
     *
     * @ORM\ManyToMany(targetEntity="App\Entity\OwnershipInfo")
     * @ApiProperty(iri="http://schema.org/owns")
     */
    private $owns;

    /**
     * @var Collection<Review>|null a review of the item
     *
     * @ORM\ManyToMany(targetEntity="App\Entity\Review")
     * @ApiProperty(iri="http://schema.org/review")
     */
    private $reviews;

    /**
     * @var Collection<Categorie>|null
     *
     * @ORM\ManyToMany(targetEntity="App\Entity\Categorie")
     */
    private $categories;

    public function __construct()
    {
        $this->adresses = new ArrayCollection();
        $this->employees = new ArrayCollection();
        $this->owns = new ArrayCollection();
        $this->reviews = new ArrayCollection();
        $this->categories = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setLegalName(string $legalName): void
    {
        $this->legalName = $legalName;
    }

    public function getLegalName(): string
    {
        return $this->legalName;
    }

    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setEmail(?string $email): void
    {
        $this->email = $email;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function addAdress(PostalAddress $adress): void
    {
        $this->adresses[] = $adress;
    }

    public function removeAdress(PostalAddress $adress): void
    {
        $this->adresses->removeElement($adress);
    }

    public function getAdresses(): Collection
    {
        return $this->adresses;
    }

    public function setTelephone(?string $telephone): void
    {
        $this->telephone = $telephone;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setMobilePhone(string $mobilePhone): void
    {
        $this->mobilePhone = $mobilePhone;
    }

    public function getMobilePhone(): string
    {
        return $this->mobilePhone;
    }

    public function addEmployee(Person $employee): void
    {
        $this->employees[] = $employee;
    }

    public function removeEmployee(Person $employee): void
    {
        $this->employees->removeElement($employee);
    }

    public function getEmployees(): Collection
    {
        return $this->employees;
    }

    public function setLeiCode(?string $leiCode): void
    {
        $this->leiCode = $leiCode;
    }

    public function getLeiCode(): ?string
    {
        return $this->leiCode;
    }

    public function setVatID(?string $vatID): void
    {
        $this->vatID = $vatID;
    }

    public function getVatID(): ?string
    {
        return $this->vatID;
    }

    public function setUrl(?string $url): void
    {
        $this->url = $url;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function addOwn(OwnershipInfo $own): void
    {
        $this->owns[] = $own;
    }

    public function removeOwn(OwnershipInfo $own): void
    {
        $this->owns->removeElement($own);
    }

    public function getOwns(): Collection
    {
        return $this->owns;
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
