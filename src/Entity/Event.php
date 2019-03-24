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
 * @ORM\Entity(repositoryClass="App\Repository\EventRepository")
 * @Gedmo\Loggable
 */
class Event
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
     * @Gedmo\Versioned
     */
    private $about;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Gedmo\Versioned
     */
    private $description;

    /**
     * @ORM\Column(type="date", nullable=true)
     * @Gedmo\Versioned
     */
    private $doorTime;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Gedmo\Versioned
     */
    private $eventStatus;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Gedmo\Versioned
     */
    private $maximumAttendeeCapacity;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     * @Gedmo\Versioned
     */
    private $isAccessibleForFree;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Gedmo\Versioned
     */
    private $remainingAttendeeCapacity;

    /**
     * @ORM\Column(type="time")
     * @Gedmo\Versioned
     */
    private $startTime;

    /**
     * @ORM\Column(type="time")
     * @Gedmo\Versioned
     */
    private $endTime;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\PostalAddress", inversedBy="events")
     */
    private $location;

    /**
     * @ORM\Column(type="date")
     * @Gedmo\Versioned
     */
    private $startDate;

    /**
     * @ORM\Column(type="date", nullable=true)
     * @Gedmo\Versioned
     */
    private $endDate;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Category", inversedBy="events")
     */
    private $category;

    public function __construct()
    {
        $this->category = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAbout(): ?string
    {
        return $this->about;
    }

    public function setAbout(string $about): self
    {
        $this->about = $about;

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

    public function getDoorTime(): ?\DateTimeInterface
    {
        return $this->doorTime;
    }

    public function setDoorTime(?\DateTimeInterface $doorTime): self
    {
        $this->doorTime = $doorTime;

        return $this;
    }

    public function getEventStatus(): ?string
    {
        return $this->eventStatus;
    }

    public function setEventStatus(?string $eventStatus): self
    {
        $this->eventStatus = $eventStatus;

        return $this;
    }

    public function getMaximumAttendeeCapacity(): ?int
    {
        return $this->maximumAttendeeCapacity;
    }

    public function setMaximumAttendeeCapacity(?int $maximumAttendeeCapacity): self
    {
        $this->maximumAttendeeCapacity = $maximumAttendeeCapacity;

        return $this;
    }

    public function getIsAccessibleForFree(): ?bool
    {
        return $this->isAccessibleForFree;
    }

    public function setIsAccessibleForFree(?bool $isAccessibleForFree): self
    {
        $this->isAccessibleForFree = $isAccessibleForFree;

        return $this;
    }

    public function getRemainingAttendeeCapacity(): ?int
    {
        return $this->remainingAttendeeCapacity;
    }

    public function setRemainingAttendeeCapacity(?int $remainingAttendeeCapacity): self
    {
        $this->remainingAttendeeCapacity = $remainingAttendeeCapacity;

        return $this;
    }

    public function getStartTime(): ?\DateTimeInterface
    {
        return $this->startTime;
    }

    public function setStartTime(\DateTimeInterface $startTime): self
    {
        $this->startTime = $startTime;

        return $this;
    }

    public function getEndTime(): ?\DateTimeInterface
    {
        return $this->endTime;
    }

    public function setEndTime(\DateTimeInterface $endTime): self
    {
        $this->endTime = $endTime;

        return $this;
    }

    public function getLocation(): ?PostalAddress
    {
        return $this->location;
    }

    public function setLocation(?PostalAddress $location): self
    {
        $this->location = $location;

        return $this;
    }

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->startDate;
    }

    public function setStartDate(\DateTimeInterface $startDate): self
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->endDate;
    }

    public function setEndDate(?\DateTimeInterface $endDate): self
    {
        $this->endDate = $endDate;

        return $this;
    }

    /**
     * @return Collection|Category[]
     */
    public function getCategory(): Collection
    {
        return $this->category;
    }

    public function addCategory(Category $category): self
    {
        if (!$this->category->contains($category)) {
            $this->category[] = $category;
        }

        return $this;
    }

    public function removeCategory(Category $category): self
    {
        if ($this->category->contains($category)) {
            $this->category->removeElement($category);
        }

        return $this;
    }
}
