<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Serializer\Filter\PropertyFilter;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Gedmo\Blameable\Traits\BlameableEntity;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass="App\Repository\PersonRepository")
 * @ApiFilter(PropertyFilter::class, arguments={"parameterName": "properties", "overrideDefaultProperties": false, "whitelist": null})
 * @UniqueEntity("email")
 * @Gedmo\Loggable
 */
class Person
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
     * @ORM\Column(type="text")
     * @Assert\NotBlank
     * @Gedmo\Versioned
     */
    private $givenName;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Gedmo\Versioned
     */
    private $additionalName;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank
     * @Gedmo\Versioned
     */
    private $familyName;

    /**
     * @ORM\Column(type="date", nullable=true)
     * @Gedmo\Versioned
     */
    private $birthDate;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Gedmo\Versioned
     */
    private $gender;

    /**
     * @ORM\Column(type="string", length=255, nullable=true, unique = true)
     * @Gedmo\Versioned
     */
    private $email;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Gedmo\Versioned
     */
    private $telephone;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Gedmo\Versioned
     */
    private $telephone_2;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Category")
     * @Gedmo\Versioned
     */
    private $category;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Gedmo\Versioned
     */
    private $addressCountry;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $addressLocality;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Gedmo\Versioned
     */
    private $postalCode;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Gedmo\Versioned
     */
    private $streetAddress;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Review", mappedBy="person", orphanRemoval=true)
     */
    private $review;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Membership", mappedBy="person", orphanRemoval=true)
     */
    private $membership;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $membershipYears;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\MusicalInstrument")
     */
    private $musicalInstrument;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Education", mappedBy="person", orphanRemoval=true)
     */
    private $education;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\ProgramMembership", inversedBy="people")
     */
    private $memberOf;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\OwnershipInfo", mappedBy="person")
     */
    private $owns;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $alumni;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Person")
     */
    private $parents;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Organization", mappedBy="employee")
     */
    private $organizations;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Orders", mappedBy="person")
     */
    private $customer;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\User", mappedBy="person", cascade={"persist", "remove"})
     */
    private $user;


    public function __construct()
    {
        $this->review = new ArrayCollection();
        $this->membership = new ArrayCollection();
        $this->education = new ArrayCollection();
        $this->memberOf = new ArrayCollection();
        $this->owns = new ArrayCollection();
        $this->parents = new ArrayCollection();
        $this->organizations = new ArrayCollection();
        $this->orders = new ArrayCollection();
        $this->customer = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getGivenName(): ?string
    {
        return $this->givenName;
    }

    public function setGivenName(?string $givenName): self
    {
        $this->givenName = $givenName;

        return $this;
    }

    public function getAdditionalName(): ?string
    {
        return $this->additionalName;
    }

    public function setAdditionalName(?string $additionalName): self
    {
        $this->additionalName = $additionalName;

        return $this;
    }

    public function getFamilyName(): ?string
    {
        return $this->familyName;
    }

    public function setFamilyName(string $familyName): self
    {
        $this->familyName = $familyName;

        return $this;
    }

    public function getBirthDate(): ?\DateTimeInterface
    {
        return $this->birthDate;
    }

    public function setBirthDate(?\DateTimeInterface $birthDate): self
    {
        $this->birthDate = $birthDate;

        return $this;
    }

    public function getGender(): ?string
    {
        return $this->gender;
    }

    public function setGender(?string $gender): self
    {
        $this->gender = $gender;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(?string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getTelephone2(): ?string
    {
        return $this->telephone_2;
    }

    public function setTelephone2(?string $telephone_2): self
    {
        $this->telephone_2 = $telephone_2;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getAddressCountry(): ?string
    {
        return $this->addressCountry;
    }

    public function setAddressCountry(?string $addressCountry): self
    {
        $this->addressCountry = $addressCountry;

        return $this;
    }

    public function getAddressLocality(): ?string
    {
        return $this->addressLocality;
    }

    public function setAddressLocality(?string $addressLocality): self
    {
        $this->addressLocality = $addressLocality;

        return $this;
    }

    public function getPostalCode(): ?string
    {
        return $this->postalCode;
    }

    public function setPostalCode(?string $postalCode): self
    {
        $this->postalCode = $postalCode;

        return $this;
    }

    public function getStreetAddress(): ?string
    {
        return $this->streetAddress;
    }

    public function setStreetAddress(?string $streetAddress): self
    {
        $this->streetAddress = $streetAddress;

        return $this;
    }

    /**
     * @return Collection|Review[]
     */
    public function getReview(): Collection
    {
        return $this->review;
    }

    public function addReview(Review $review): self
    {
        if (!$this->review->contains($review)) {
            $this->review[] = $review;
            $review->setPerson($this);
        }

        return $this;
    }

    public function removeReview(Review $review): self
    {
        if ($this->review->contains($review)) {
            $this->review->removeElement($review);
            // set the owning side to null (unless already changed)
            if ($review->getPerson() === $this) {
                $review->setPerson(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Membership[]
     */
    public function getMembership(): Collection
    {
        return $this->membership;
    }

    public function addMembership(Membership $membership): self
    {
        if (!$this->membership->contains($membership)) {
            $this->membership[] = $membership;
            $membership->setPerson($this);
        }

        return $this;
    }

    public function removeMembership(Membership $membership): self
    {
        if ($this->membership->contains($membership)) {
            $this->membership->removeElement($membership);
            // set the owning side to null (unless already changed)
            if ($membership->getPerson() === $this) {
                $membership->setPerson(null);
            }
        }

        return $this;
    }

    public function getMembershipYears(): ?int
    {
        return $this->membershipYears;
    }

    public function setMembershipYears(?int $membershipYears): self
    {
        $this->membershipYears = $membershipYears;

        return $this;
    }

    public function getMusicalInstrument(): ?MusicalInstrument
    {
        return $this->musicalInstrument;
    }

    public function setMusicalInstrument(?MusicalInstrument $musicalInstrument): self
    {
        $this->musicalInstrument = $musicalInstrument;

        return $this;
    }

    /**
     * @return Collection|Education[]
     */
    public function getEducation(): Collection
    {
        return $this->education;
    }

    public function addEducation(Education $education): self
    {
        if (!$this->education->contains($education)) {
            $this->education[] = $education;
            $education->setPerson($this);
        }

        return $this;
    }

    public function removeEducation(Education $education): self
    {
        if ($this->education->contains($education)) {
            $this->education->removeElement($education);
            // set the owning side to null (unless already changed)
            if ($education->getPerson() === $this) {
                $education->setPerson(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|ProgramMembership[]
     */
    public function getMemberOf(): Collection
    {
        return $this->memberOf;
    }

    public function addMemberOf(ProgramMembership $memberOf): self
    {
        if (!$this->memberOf->contains($memberOf)) {
            $this->memberOf[] = $memberOf;
        }

        return $this;
    }

    public function removeMemberOf(ProgramMembership $memberOf): self
    {
        if ($this->memberOf->contains($memberOf)) {
            $this->memberOf->removeElement($memberOf);
        }

        return $this;
    }

    /**
     * @return Collection|OwnershipInfo[]
     */
    public function getOwns(): Collection
    {
        return $this->owns;
    }

    public function addOwn(OwnershipInfo $own): self
    {
        if (!$this->owns->contains($own)) {
            $this->owns[] = $own;
            $own->setPerson($this);
        }

        return $this;
    }

    public function removeOwn(OwnershipInfo $own): self
    {
        if ($this->owns->contains($own)) {
            $this->owns->removeElement($own);
            // set the owning side to null (unless already changed)
            if ($own->getPerson() === $this) {
                $own->setPerson(null);
            }
        }

        return $this;
    }

    public function getAlumni(): ?bool
    {
        return $this->alumni;
    }

    public function setAlumni(?bool $alumni): self
    {
        $this->alumni = $alumni;

        return $this;
    }

    /**
     * @return Collection|self[]
     */
    public function getParents(): Collection
    {
        return $this->parents;
    }

    public function addParent(self $parent): self
    {
        if (!$this->parents->contains($parent)) {
            $this->parents[] = $parent;
        }

        return $this;
    }

    public function removeParent(self $parent): self
    {
        if ($this->parents->contains($parent)) {
            $this->parents->removeElement($parent);
        }

        return $this;
    }

    /**
     * @return Collection|Organization[]
     */
    public function getOrganizations(): Collection
    {
        return $this->organizations;
    }

    public function addOrganization(Organization $organization): self
    {
        if (!$this->organizations->contains($organization)) {
            $this->organizations[] = $organization;
            $organization->addEmployee($this);
        }

        return $this;
    }

    public function removeOrganization(Organization $organization): self
    {
        if ($this->organizations->contains($organization)) {
            $this->organizations->removeElement($organization);
            $organization->removeEmployee($this);
        }

        return $this;
    }

    /**
     * @return Collection|Orders[]
     */
    public function getCustomer(): Collection
    {
        return $this->customer;
    }

    public function addCustomer(Orders $customer): self
    {
        if (!$this->customer->contains($customer)) {
            $this->customer[] = $customer;
            $customer->setPerson($this);
        }

        return $this;
    }

    public function removeCustomer(Orders $customer): self
    {
        if ($this->customer->contains($customer)) {
            $this->customer->removeElement($customer);
            // set the owning side to null (unless already changed)
            if ($customer->getPerson() === $this) {
                $customer->setPerson(null);
            }
        }

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        // set (or unset) the owning side of the relation if necessary
        $newPerson = $user === null ? null : $this;
        if ($newPerson !== $user->getPerson()) {
            $user->setPerson($newPerson);
        }

        return $this;
    }
}
