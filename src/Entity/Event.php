<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\DateFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\OrderFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Core\Serializer\Filter\PropertyFilter;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Gedmo\Blameable\Traits\BlameableEntity;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ApiResource()
 * @ApiFilter(DateFilter::class, properties={"startDate", "endDate", "createdAt", "updatedAt"})
 * @ApiFilter(OrderFilter::class, properties={"id", "startDate"}, arguments={"orderParameterName"="order"})
 * @ApiFilter(SearchFilter::class, properties={"id": "exact", "category": "exact"})
 * @ApiFilter(PropertyFilter::class, arguments={"parameterName": "properties", "overrideDefaultProperties": false, "whitelist": null})
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
     * @ORM\Column(type="time", nullable=true)
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

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Review", mappedBy="event", orphanRemoval=true)
     */
    private $review;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Organization", orphanRemoval=true)
     * @ORM\JoinTable(name="event_organizers")
     */
    private $organizer;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Organization", orphanRemoval=true)
     * @ORM\JoinTable(name="event_performer")
     */
    private $performer;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Organization", orphanRemoval=true)
     * @ORM\JoinTable(name="event_supplier")
     */
    private $suppliers;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Person", orphanRemoval=true, inversedBy="sponsor")
     * @ORM\JoinTable(name="event_sponsor")
     */
    private $sponsor;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Person", orphanRemoval=true, inversedBy="contributor")
     * @ORM\JoinTable(name="event_contributor")
     */
    private $contributor;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\person", orphanRemoval=true, inversedBy="attendee")
     * @ORM\JoinTable(name="event_attendee")
     */
    private $attendee;

    public function __construct()
    {
        $this->category = new ArrayCollection();
        $this->review = new ArrayCollection();
        $this->organizer = new ArrayCollection();
        $this->performer = new ArrayCollection();
        $this->suppliers = new ArrayCollection();
        $this->sponsor = new ArrayCollection();
        $this->contributor = new ArrayCollection();
        $this->attendee = new ArrayCollection();
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

    public function setDoorTime(\DateTimeInterface $doorTime = null): self
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
            $review->setEvent($this);
        }

        return $this;
    }

    public function removeReview(Review $review): self
    {
        if ($this->review->contains($review)) {
            $this->review->removeElement($review);
            // set the owning side to null (unless already changed)
            if ($review->getEvent() === $this) {
                $review->setEvent(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Organization[]
     */
    public function getOrganizer(): Collection
    {
        return $this->organizer;
    }

    public function addOrganizer(Organization $organizer): self
    {
        if (!$this->organizer->contains($organizer)) {
            $this->organizer[] = $organizer;
        }

        return $this;
    }

    public function removeOrganizer(Organization $organizer): self
    {
        if ($this->organizer->contains($organizer)) {
            $this->organizer->removeElement($organizer);
        }

        return $this;
    }

    /**
     * @return Collection|Organization[]
     */
    public function getPerformer(): Collection
    {
        return $this->performer;
    }

    public function addPerformer(Organization $performer): self
    {
        if (!$this->performer->contains($performer)) {
            $this->performer[] = $performer;
        }

        return $this;
    }

    public function removePerformer(Organization $performer): self
    {
        if ($this->performer->contains($performer)) {
            $this->performer->removeElement($performer);
        }

        return $this;
    }

    /**
     * @return Collection|Organization[]
     */
    public function getSuppliers(): Collection
    {
        return $this->suppliers;
    }

    public function addSupplier(Organization $supplier): self
    {
        if (!$this->suppliers->contains($supplier)) {
            $this->suppliers[] = $supplier;
        }

        return $this;
    }

    public function removeSupplier(Organization $supplier): self
    {
        if ($this->suppliers->contains($supplier)) {
            $this->suppliers->removeElement($supplier);
        }

        return $this;
    }

    /**
     * @return Collection|Person[]
     */
    public function getSponsor(): Collection
    {
        return $this->sponsor;
    }

    public function addSponsor(Person $sponsor): self
    {
        if (!$this->sponsor->contains($sponsor)) {
            $this->sponsor[] = $sponsor;
        }

        return $this;
    }

    public function removeSponsor(Person $sponsor): self
    {
        if ($this->sponsor->contains($sponsor)) {
            $this->sponsor->removeElement($sponsor);
        }

        return $this;
    }

    /**
     * @return Collection|Person[]
     */
    public function getContributor(): Collection
    {
        return $this->contributor;
    }

    public function addContributor(Person $contributor): self
    {
        if (!$this->contributor->contains($contributor)) {
            $this->contributor[] = $contributor;
        }

        return $this;
    }

    public function removeContributor(Person $contributor): self
    {
        if ($this->contributor->contains($contributor)) {
            $this->contributor->removeElement($contributor);
        }

        return $this;
    }

    /**
     * @return Collection|person[]
     */
    public function getAttendee(): Collection
    {
        return $this->attendee;
    }

    public function addAttendee(person $attendee): self
    {
        if (!$this->attendee->contains($attendee)) {
            $this->attendee[] = $attendee;
        }

        return $this;
    }

    public function removeAttendee(person $attendee): self
    {
        if ($this->attendee->contains($attendee)) {
            $this->attendee->removeElement($attendee);
        }

        return $this;
    }
}
