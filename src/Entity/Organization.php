<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Gedmo\Blameable\Traits\BlameableEntity;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass="App\Repository\OrganizationRepository")
 * @Gedmo\Loggable
 */
class Organization
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
     * @Gedmo\Versioned
     */
    private $legalName;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Gedmo\Versioned
     */
    private $description;

    /**
     * @ORM\Column(type="text", nullable=true)
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
     * @ORM\Column(type="text", nullable=true)
     * @Gedmo\Versioned
     */
    private $leiCode;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Gedmo\Versioned
     */
    private $vatID;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Gedmo\Versioned
     */
    private $url;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Category")
     * @Gedmo\Versioned
     */
    private $category;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Gedmo\Versioned
     */
    private $streetAddress;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Gedmo\Versioned
     */
    private $postalCode;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Gedmo\Versioned
     */
    private $postOfficeBoxNumber;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Gedmo\Versioned
     */
    private $addressLocality;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Gedmo\Versioned
     */
    private $addressCountry;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Review", mappedBy="organization", orphanRemoval=true)
     */
    private $review;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Education", mappedBy="organization")
     */
    private $education;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Person", inversedBy="organizations")
     */
    private $employee;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\OwnershipInfo", mappedBy="organization")
     */
    private $owns;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Orders", mappedBy="organization")
     */
    private $customer;


    public function __construct()
    {
        $this->review = new ArrayCollection();
        $this->education = new ArrayCollection();
        $this->ownershipInfos = new ArrayCollection();
        $this->employee = new ArrayCollection();
        $this->owns = new ArrayCollection();
        $this->customer = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLegalName(): ?string
    {
        return $this->legalName;
    }

    public function setLegalName(string $legalName): self
    {
        $this->legalName = $legalName;

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

    public function getLeiCode(): ?string
    {
        return $this->leiCode;
    }

    public function setLeiCode(?string $leiCode): self
    {
        $this->leiCode = $leiCode;

        return $this;
    }

    public function getVatID(): ?string
    {
        return $this->vatID;
    }

    public function setVatID(?string $vatID): self
    {
        $this->vatID = $vatID;

        return $this;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(?string $url): self
    {
        $this->url = $url;

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

    public function getStreetAddress(): ?string
    {
        return $this->streetAddress;
    }

    public function setStreetAddress(?string $streetAddress): self
    {
        $this->streetAddress = $streetAddress;

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

    public function getPostOfficeBoxNumber(): ?string
    {
        return $this->postOfficeBoxNumber;
    }

    public function setPostOfficeBoxNumber(?string $postOfficeBoxNumber): self
    {
        $this->postOfficeBoxNumber = $postOfficeBoxNumber;

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

    public function getAddressCountry(): ?string
    {
        return $this->addressCountry;
    }

    public function setAddressCountry(?string $addressCountry): self
    {
        $this->addressCountry = $addressCountry;

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
            $review->setOrganization($this);
        }

        return $this;
    }

    public function removeReview(Review $review): self
    {
        if ($this->review->contains($review)) {
            $this->review->removeElement($review);
            // set the owning side to null (unless already changed)
            if ($review->getOrganization() === $this) {
                $review->setOrganization(null);
            }
        }

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
            $education->setOrganization($this);
        }

        return $this;
    }

    public function removeEducation(Education $education): self
    {
        if ($this->education->contains($education)) {
            $this->education->removeElement($education);
            // set the owning side to null (unless already changed)
            if ($education->getOrganization() === $this) {
                $education->setOrganization(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Person[]
     */
    public function getEmployee(): Collection
    {
        return $this->employee;
    }

    public function addEmployee(Person $employee): self
    {
        if (!$this->employee->contains($employee)) {
            $this->employee[] = $employee;
        }

        return $this;
    }

    public function removeEmployee(Person $employee): self
    {
        if ($this->employee->contains($employee)) {
            $this->employee->removeElement($employee);
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
            $own->setOrganization($this);
        }

        return $this;
    }

    public function removeOwn(OwnershipInfo $own): self
    {
        if ($this->owns->contains($own)) {
            $this->owns->removeElement($own);
            // set the owning side to null (unless already changed)
            if ($own->getOrganization() === $this) {
                $own->setOrganization(null);
            }
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
            $customer->setOrganization($this);
        }

        return $this;
    }

    public function removeCustomer(Orders $customer): self
    {
        if ($this->customer->contains($customer)) {
            $this->customer->removeElement($customer);
            // set the owning side to null (unless already changed)
            if ($customer->getOrganization() === $this) {
                $customer->setOrganization(null);
            }
        }

        return $this;
    }

}
