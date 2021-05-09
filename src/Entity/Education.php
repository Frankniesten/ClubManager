<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Gedmo\Blameable\Traits\BlameableEntity;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass="App\Repository\EducationRepository")
 * @Gedmo\Loggable
 * @Gedmo\SoftDeleteable(fieldName="deletedAt")
 */
class Education
{
	use TimestampableEntity;
	use BlameableEntity;

    /**
     * @var \DateTime $deletedAt
     *
     * @ORM\Column(name="deleted_at", type="datetime", nullable=true)
     */
    private $deletedAt;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Gedmo\Versioned
     */
    private $certificate;

    /**
     * @ORM\Column(type="date", nullable=true)
     * @Gedmo\Versioned
     */
    private $dateAchieved;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Organization", inversedBy="education")
     * @Gedmo\Versioned
     */
    private $organization;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Person", inversedBy="education")
     * @Gedmo\Versioned
     */
    private $person;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCertificate(): ?string
    {
        return $this->certificate;
    }

    public function setCertificate(string $certificate): self
    {
        $this->certificate = $certificate;

        return $this;
    }

    public function getDateAchieved(): ?\DateTimeInterface
    {
        return $this->dateAchieved;
    }
    public function setDateAchieved(?\DateTimeInterface $dateAchieved): self
    {
        $this->dateAchieved = $dateAchieved;
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
