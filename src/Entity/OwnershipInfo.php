<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Gedmo\Blameable\Traits\BlameableEntity;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass="App\Repository\OwnershipInfoRepository")
 * @Gedmo\Loggable
 */
class OwnershipInfo
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
     * @ORM\Column(type="date")
     * @Gedmo\Versioned
     */
    private $ownedFrom;

    /**
     * @ORM\Column(type="date", nullable=true)
     * @Gedmo\Versioned
     */
    private $ownedTrough;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Products", inversedBy="ownershipInfos")
     * @ORM\JoinColumn(nullable=false)
     * @Gedmo\Versioned
     */
    private $typeofGood;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Person", inversedBy="owns", fetch="EAGER")
     * @Gedmo\Versioned
     */
    private $person;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Organization", inversedBy="owns")
     * @Gedmo\Versioned
     */
    private $organization;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOwnedFrom(): ?DateTimeInterface
    {
        return $this->ownedFrom;
    }

    public function setOwnedFrom(DateTimeInterface $ownedFrom): self
    {
        $this->ownedFrom = $ownedFrom;

        return $this;
    }

    public function getOwnedTrough(): ?DateTimeInterface
    {
        return $this->ownedTrough;
    }

    public function setOwnedTrough(?DateTimeInterface $ownedTrough): self
    {
        $this->ownedTrough = $ownedTrough;

        return $this;
    }

    public function getTypeofGood(): ?Products
    {
        return $this->typeofGood;
    }

    public function setTypeofGood(?Products $typeofGood): self
    {
        $this->typeofGood = $typeofGood;

        return $this;
    }

    public function getPerson(): ?Person
    {
        return $this->person;
    }

    public function setPerson(?Person $person): self
    {
        $this->person = $person;

        return $this;
    }

    public function getOrganization(): ?Organization
    {
        return $this->organization;
    }

    public function setOrganization(?Organization $organization): self
    {
        $this->organization = $organization;

        return $this;
    }
}
