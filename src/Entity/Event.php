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
 * An event happening at a certain time and location, such as a concert, lecture, or festival. Ticketing information may be added via the \[\[offers\]\] property. Repeated events may be structured as separate Event objects.
 *
 * @see http://schema.org/Event Documentation on Schema.org
 *
 * @ORM\Entity
 * @ApiResource(iri="http://schema.org/Event")
 */
class Event
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
     * @var string the subject matter of the content
     *
     * @ORM\Column(type="text")
     * @ApiProperty(iri="http://schema.org/about")
     * @Assert\NotNull
     */
    private $about;

    /**
     * @var string|null a description of the item
     *
     * @ORM\Column(type="text", nullable=true)
     * @ApiProperty(iri="http://schema.org/description")
     */
    private $description;

    /**
     * @var Collection<PostalAddress>|null the location of for example where the event is happening, an organization is located, or where an action takes place
     *
     * @ORM\ManyToMany(targetEntity="App\Entity\PostalAddress")
     * @ApiProperty(iri="http://schema.org/location")
     */
    private $locations;

    /**
     * @var \DateTimeInterface|null The start date and time of the item (in \[ISO 8601 date format\](http://en.wikipedia.org/wiki/ISO\_8601)).
     *
     * @ORM\Column(type="datetime", nullable=true)
     * @ApiProperty(iri="http://schema.org/startDate")
     * @Assert\DateTime
     */
    private $startDate;

    /**
     * @var \DateTimeInterface|null The end date and time of the item (in \[ISO 8601 date format\](http://en.wikipedia.org/wiki/ISO\_8601)).
     *
     * @ORM\Column(type="datetime", nullable=true)
     * @ApiProperty(iri="http://schema.org/endDate")
     * @Assert\DateTime
     */
    private $endDate;

    /**
     * @var \DateTimeInterface|null the time admission will commence
     *
     * @ORM\Column(type="datetime", nullable=true)
     * @ApiProperty(iri="http://schema.org/doorTime")
     * @Assert\DateTime
     */
    private $doorTime;

    /**
     * @var string|null an eventStatus of an event represents its status; particularly useful when an event is cancelled or rescheduled
     *
     * @ORM\Column(type="text", nullable=true)
     * @ApiProperty(iri="http://schema.org/eventStatus")
     */
    private $eventStatus;

    /**
     * @var string|null the total number of individuals that may attend an event or venue
     *
     * @ORM\Column(type="text", nullable=true)
     * @ApiProperty(iri="http://schema.org/maximumAttendeeCapacity")
     */
    private $maximumAttendeeCapacity;

    /**
     * @var Collection<Person>|null a person or organization attending the event
     *
     * @ORM\ManyToMany(targetEntity="App\Entity\Person")
     * @ORM\JoinTable(name="event_attendee")
     * @ApiProperty(iri="http://schema.org/attendee")
     */
    private $attendees;

    /**
     * @var Collection<Organization>|null an organizer of an Event
     *
     * @ORM\ManyToMany(targetEntity="App\Entity\Organization")
     * @ORM\JoinTable(name="event_organizer")
     * @ApiProperty(iri="http://schema.org/organizer")
     */
    private $organizers;

    /**
     * @var Collection<Organization>|null a performer at the event—for example, a presenter, musician, musical group or actor
     *
     * @ORM\ManyToMany(targetEntity="App\Entity\Organization")
     * @ORM\JoinTable(name="event_performer")
     * @ApiProperty(iri="http://schema.org/performer")
     */
    private $performers;

    /**
     * @var Collection<Person>|null a secondary contributor to the CreativeWork or Event
     *
     * @ORM\ManyToMany(targetEntity="App\Entity\Person")
     * @ORM\JoinTable(name="event_contributor")
     * @ApiProperty(iri="http://schema.org/contributor")
     */
    private $contributors;

    /**
     * @var Collection<Event>|null An Event that is part of this event. For example, a conference event includes many presentations, each of which is a subEvent of the conference.
     *
     * @ORM\ManyToMany(targetEntity="App\Entity\Event")
     * @ApiProperty(iri="http://schema.org/subEvent")
     */
    private $subEvents;

    /**
     * @var Collection<Person>|null A person or organization that supports a thing through a pledge, promise, or financial contribution. e.g. a sponsor of a Medical Study or a corporate sponsor of an event.
     *
     * @ORM\ManyToMany(targetEntity="App\Entity\Person")
     * @ORM\JoinTable(name="event_sponsor")
     * @ApiProperty(iri="http://schema.org/sponsor")
     */
    private $sponsors;

    /**
     * @var Collection<Categorie>|null
     *
     * @ORM\ManyToMany(targetEntity="App\Entity\Categorie")
     */
    private $categories;

    /**
     * @var Collection<Review>|null
     *
     * @ORM\ManyToMany(targetEntity="App\Entity\Review")
     */
    private $Reviews;

    public function __construct()
    {
        $this->locations = new ArrayCollection();
        $this->attendees = new ArrayCollection();
        $this->organizers = new ArrayCollection();
        $this->performers = new ArrayCollection();
        $this->contributors = new ArrayCollection();
        $this->subEvents = new ArrayCollection();
        $this->sponsors = new ArrayCollection();
        $this->categories = new ArrayCollection();
        $this->Reviews = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setAbout(string $about): void
    {
        $this->about = $about;
    }

    public function getAbout(): string
    {
        return $this->about;
    }

    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function addLocation(PostalAddress $location): void
    {
        $this->locations[] = $location;
    }

    public function removeLocation(PostalAddress $location): void
    {
        $this->locations->removeElement($location);
    }

    public function getLocations(): Collection
    {
        return $this->locations;
    }

    public function setStartDate(?\DateTimeInterface $startDate): void
    {
        $this->startDate = $startDate;
    }

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->startDate;
    }

    public function setEndDate(?\DateTimeInterface $endDate): void
    {
        $this->endDate = $endDate;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->endDate;
    }

    public function setDoorTime(?\DateTimeInterface $doorTime): void
    {
        $this->doorTime = $doorTime;
    }

    public function getDoorTime(): ?\DateTimeInterface
    {
        return $this->doorTime;
    }

    public function setEventStatus(?string $eventStatus): void
    {
        $this->eventStatus = $eventStatus;
    }

    public function getEventStatus(): ?string
    {
        return $this->eventStatus;
    }

    public function setMaximumAttendeeCapacity(?string $maximumAttendeeCapacity): void
    {
        $this->maximumAttendeeCapacity = $maximumAttendeeCapacity;
    }

    public function getMaximumAttendeeCapacity(): ?string
    {
        return $this->maximumAttendeeCapacity;
    }

    public function addAttendee(Person $attendee): void
    {
        $this->attendees[] = $attendee;
    }

    public function removeAttendee(Person $attendee): void
    {
        $this->attendees->removeElement($attendee);
    }

    public function getAttendees(): Collection
    {
        return $this->attendees;
    }

    public function addOrganizer(Organization $organizer): void
    {
        $this->organizers[] = $organizer;
    }

    public function removeOrganizer(Organization $organizer): void
    {
        $this->organizers->removeElement($organizer);
    }

    public function getOrganizers(): Collection
    {
        return $this->organizers;
    }

    public function addPerformer(Organization $performer): void
    {
        $this->performers[] = $performer;
    }

    public function removePerformer(Organization $performer): void
    {
        $this->performers->removeElement($performer);
    }

    public function getPerformers(): Collection
    {
        return $this->performers;
    }

    public function addContributor(Person $contributor): void
    {
        $this->contributors[] = $contributor;
    }

    public function removeContributor(Person $contributor): void
    {
        $this->contributors->removeElement($contributor);
    }

    public function getContributors(): Collection
    {
        return $this->contributors;
    }

    public function addSubEvent(Event $subEvent): void
    {
        $this->subEvents[] = $subEvent;
    }

    public function removeSubEvent(Event $subEvent): void
    {
        $this->subEvents->removeElement($subEvent);
    }

    public function getSubEvents(): Collection
    {
        return $this->subEvents;
    }

    public function addSponsor(Person $sponsor): void
    {
        $this->sponsors[] = $sponsor;
    }

    public function removeSponsor(Person $sponsor): void
    {
        $this->sponsors->removeElement($sponsor);
    }

    public function getSponsors(): Collection
    {
        return $this->sponsors;
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

    public function addReview(Review $Review): void
    {
        $this->Reviews[] = $Review;
    }

    public function removeReview(Review $Review): void
    {
        $this->Reviews->removeElement($Review);
    }

    public function getReviews(): Collection
    {
        return $this->Reviews;
    }
}
