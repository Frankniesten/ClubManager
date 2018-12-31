<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass="App\Repository\ReviewRepository")
 */
class Review
{
	use TimestampableEntity;
	
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $reviewAspect;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $reviewBody;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Person", inversedBy="review")
     */
    private $person;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Organization", inversedBy="review")
     */
    private $organization;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Products", inversedBy="review")
     */
    private $review;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getReviewAspect(): ?string
    {
        return $this->reviewAspect;
    }

    public function setReviewAspect(string $reviewAspect): self
    {
        $this->reviewAspect = $reviewAspect;

        return $this;
    }

    public function getReviewBody(): ?string
    {
        return $this->reviewBody;
    }

    public function setReviewBody(?string $reviewBody): self
    {
        $this->reviewBody = $reviewBody;

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

    public function getReview(): ?Products
    {
        return $this->review;
    }

    public function setReview(?Products $review): self
    {
        $this->review = $review;

        return $this;
    }
}
