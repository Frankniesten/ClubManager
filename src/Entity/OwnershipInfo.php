<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass="App\Repository\OwnershipInfoRepository")
 */
class OwnershipInfo
{
	use TimestampableEntity;
	
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Organization", inversedBy="ownershipInfos")
     */
    private $aquiredFrom;

    /**
     * @ORM\Column(type="date")
     */
    private $ownedFrom;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $ownedTrough;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Products", inversedBy="ownershipInfos")
     * @ORM\JoinColumn(nullable=false)
     */
    private $typeofGood;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Person", inversedBy="owns")
     */
    private $person;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAquiredFrom(): ?Organization
    {
        return $this->aquiredFrom;
    }

    public function setAquiredFrom(?Organization $aquiredFrom): self
    {
        $this->aquiredFrom = $aquiredFrom;

        return $this;
    }

    public function getOwnedFrom(): ?\DateTimeInterface
    {
        return $this->ownedFrom;
    }

    public function setOwnedFrom(\DateTimeInterface $ownedFrom): self
    {
        $this->ownedFrom = $ownedFrom;

        return $this;
    }

    public function getOwnedTrough(): ?\DateTimeInterface
    {
        return $this->ownedTrough;
    }

    public function setOwnedTrough(?\DateTimeInterface $ownedTrough): self
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
}
