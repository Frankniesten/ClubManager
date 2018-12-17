<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass="App\Repository\OrganizationRepository")
 */
class Organization
{
	
	use TimestampableEntity;
	
	
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    private $legalName;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $email;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $telephone;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $telephone_2;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $leiCode;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $vatID;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $url;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Categorie")
     */
    private $categorie;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $streetAddress;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $postalCode;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $postOfficeBoxNumber;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $addressLocality;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $addressCountry;

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

    public function getCategorie(): ?Categorie
    {
        return $this->categorie;
    }

    public function setCategorie(?Categorie $categorie): self
    {
        $this->categorie = $categorie;

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
}
