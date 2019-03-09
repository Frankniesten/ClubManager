<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Gedmo\Blameable\Traits\BlameableEntity;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass="App\Repository\EducationRepository")
 */
class Education
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
     * @ORM\Column(type="string", length=255)
     */
    private $certificate;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $dataAchieved;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Organization", inversedBy="education")
     */
    private $organization;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Person", inversedBy="education")
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

    public function getDataAchieved(): ?\DateTimeInterface
    {
        return $this->dataAchieved;
    }

    public function setDataAchieved(?\DateTimeInterface $dataAchieved): self
    {
        $this->dataAchieved = $dataAchieved;

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
