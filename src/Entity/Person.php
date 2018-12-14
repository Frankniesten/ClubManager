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
 * A person (alive, dead, undead, or fictional).
 *
 * @see http://schema.org/Person Documentation on Schema.org
 *
 * @ORM\Entity
 * @ApiResource(iri="http://schema.org/Person")
 */
class Person
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
     * @var string|null Family name. In the U.S., the last name of an Person. This can be used along with givenName instead of the name property.
     *
     * @ORM\Column(type="text", nullable=true)
     * @ApiProperty(iri="http://schema.org/familyName")
     */
    private $familyName;

    /**
     * @var string Given name. In the U.S., the first name of a Person. This can be used along with familyName instead of the name property.
     *
     * @ORM\Column(type="text")
     * @ApiProperty(iri="http://schema.org/givenName")
     * @Assert\NotNull
     */
    private $givenName;

    /**
     * @var string|null an additional name for a Person, can be used for a middle name
     *
     * @ORM\Column(type="text", nullable=true)
     * @ApiProperty(iri="http://schema.org/additionalName")
     */
    private $additionalName;

    /**
     * @var \DateTimeInterface|null date of birth
     *
     * @ORM\Column(type="date", nullable=true)
     * @ApiProperty(iri="http://schema.org/birthDate")
     * @Assert\Date
     */
    private $birthDate;

    /**
     * @var Collection<PostalAddress>|null physical address of the item
     *
     * @ORM\ManyToMany(targetEntity="App\Entity\PostalAddress")
     * @ApiProperty(iri="http://schema.org/address")
     */
    private $addresses;

    /**
     * @var string|null Gender of the person. While http://schema.org/Male and http://schema.org/Female may be used, text strings are also acceptable for people who do not identify as a binary gender.
     *
     * @ORM\Column(type="text", nullable=true)
     * @ApiProperty(iri="http://schema.org/gender")
     */
    private $gender;

    /**
     * @var string|null email address
     *
     * @ORM\Column(type="text", nullable=true)
     * @ApiProperty(iri="http://schema.org/email")
     * @Assert\Email
     */
    private $email;

    /**
     * @var string|null the telephone number
     *
     * @ORM\Column(type="text", nullable=true)
     * @ApiProperty(iri="http://schema.org/telephone")
     */
    private $telephone;

    /**
     * @var string|null the mobile phone number
     *
     * @ORM\Column(type="text", nullable=true))
     */
    private $mobilePhone;

    /**
     * @var Collection<Person>|null the most generic bi-directional social/work relation
     *
     * @ORM\ManyToMany(targetEntity="App\Entity\Person")
     * @ORM\JoinTable(name="Person_knows")
     * @ApiProperty(iri="http://schema.org/knows")
     */
    private $knows;

    /**
     * @var Collection<Person>|null a parents of the person
     *
     * @ORM\ManyToMany(targetEntity="App\Entity\Person")
     * @ORM\JoinTable(name="Person_parents")
     * @ApiProperty(iri="http://schema.org/parents")
     */
    private $parents;

    /**
     * @var Collection<MusicalInstrument>|null
     *
     * @ORM\ManyToMany(targetEntity="App\Entity\MusicalInstrument")
     */
    private $musicalInstruments;

    /**
     * @var Collection<Education>|null
     *
     * @ORM\ManyToMany(targetEntity="App\Entity\Education")
     */
    private $education;

    /**
     * @var Collection<Categorie>|null
     *
     * @ORM\ManyToMany(targetEntity="App\Entity\Categorie")
     */
    private $categories;

    /**
     * @var Collection<ProgramMembership>|null an Organization (or ProgramMembership) to which this Person or Organization belongs
     *
     * @ORM\ManyToMany(targetEntity="App\Entity\ProgramMembership")
     * @ApiProperty(iri="http://schema.org/memberOf")
     */
    private $memberOfs;

    /**
     * @var Collection<OwnershipInfo>|null products owned by the organization or person
     *
     * @ORM\ManyToMany(targetEntity="App\Entity\OwnershipInfo")
     * @ApiProperty(iri="http://schema.org/owns")
     */
    private $owns;

    /**
     * @var Collection<Review>|null
     *
     * @ORM\ManyToMany(targetEntity="App\Entity\Review")
     */
    private $reviews;

    public function __construct()
    {
        $this->addresses = new ArrayCollection();
        $this->knows = new ArrayCollection();
        $this->parents = new ArrayCollection();
        $this->musicalInstruments = new ArrayCollection();
        $this->education = new ArrayCollection();
        $this->categories = new ArrayCollection();
        $this->memberOfs = new ArrayCollection();
        $this->owns = new ArrayCollection();
        $this->reviews = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setFamilyName(?string $familyName): void
    {
        $this->familyName = $familyName;
    }

    public function getFamilyName(): ?string
    {
        return $this->familyName;
    }

    public function setGivenName(string $givenName): void
    {
        $this->givenName = $givenName;
    }

    public function getGivenName(): string
    {
        return $this->givenName;
    }

    public function setAdditionalName(?string $additionalName): void
    {
        $this->additionalName = $additionalName;
    }

    public function getAdditionalName(): ?string
    {
        return $this->additionalName;
    }

    public function setBirthDate(?\DateTimeInterface $birthDate): void
    {
        $this->birthDate = $birthDate;
    }

    public function getBirthDate(): ?\DateTimeInterface
    {
        return $this->birthDate;
    }

    public function addAddress(PostalAddress $address): void
    {
        $this->addresses[] = $address;
    }

    public function removeAddress(PostalAddress $address): void
    {
        $this->addresses->removeElement($address);
    }

    public function getAddresses(): Collection
    {
        return $this->addresses;
    }

    public function setGender(?string $gender): void
    {
        $this->gender = $gender;
    }

    public function getGender(): ?string
    {
        return $this->gender;
    }

    public function setEmail(?string $email): void
    {
        $this->email = $email;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setTelephone(?string $telephone): void
    {
        $this->telephone = $telephone;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setMobilePhone(?string $mobilePhone): void
    {
        $this->mobilePhone = $mobilePhone;
    }

    public function getMobilePhone(): ?string
    {
        return $this->mobilePhone;
    }

    public function addKnow(Person $know): void
    {
        $this->knows[] = $know;
    }

    public function removeKnow(Person $know): void
    {
        $this->knows->removeElement($know);
    }

    public function getKnows(): Collection
    {
        return $this->knows;
    }

    public function addParent(Person $parent): void
    {
        $this->parents[] = $parent;
    }

    public function removeParent(Person $parent): void
    {
        $this->parents->removeElement($parent);
    }

    public function getParents(): Collection
    {
        return $this->parents;
    }

    public function addMusicalInstrument(MusicalInstrument $musicalInstrument): void
    {
        $this->musicalInstruments[] = $musicalInstrument;
    }

    public function removeMusicalInstrument(MusicalInstrument $musicalInstrument): void
    {
        $this->musicalInstruments->removeElement($musicalInstrument);
    }

    public function getMusicalInstruments(): Collection
    {
        return $this->musicalInstruments;
    }

    public function addEducation(Education $education): void
    {
        $this->education[] = $education;
    }

    public function removeEducation(Education $education): void
    {
        $this->education->removeElement($education);
    }

    public function getEducation(): Collection
    {
        return $this->education;
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

    public function addMemberOf(ProgramMembership $memberOf): void
    {
        $this->memberOfs[] = $memberOf;
    }

    public function removeMemberOf(ProgramMembership $memberOf): void
    {
        $this->memberOfs->removeElement($memberOf);
    }

    public function getMemberOfs(): Collection
    {
        return $this->memberOfs;
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
}
