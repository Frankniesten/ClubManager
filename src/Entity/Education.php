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

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * The most generic type of item.
 *
 * @see http://schema.org/Thing Documentation on Schema.org
 *
 * @ORM\Entity
 * @ApiResource(iri="http://schema.org/Thing")
 */
class Education
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
     * @var string
     *
     * @ORM\Column(type="text")
     * @Assert\NotNull
     */
    private $certificate;

    /**
     * @var \DateTimeInterface
     *
     * @ORM\Column(type="date")
     * @Assert\Date
     * @Assert\NotNull
     */
    private $dateAchieved;

    /**
     * @var Collection<Organization>|null
     *
     * @ORM\ManyToMany(targetEntity="App\Entity\Organization")
     */
    private $Organizations;

    public function __construct()
    {
        $this->Organizations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setCertificate(string $certificate): void
    {
        $this->certificate = $certificate;
    }

    public function getCertificate(): string
    {
        return $this->certificate;
    }

    public function setDateAchieved(\DateTimeInterface $dateAchieved): void
    {
        $this->dateAchieved = $dateAchieved;
    }

    public function getDateAchieved(): \DateTimeInterface
    {
        return $this->dateAchieved;
    }

    public function addOrganization(Organization $Organization): void
    {
        $this->Organizations[] = $Organization;
    }

    public function removeOrganization(Organization $Organization): void
    {
        $this->Organizations->removeElement($Organization);
    }

    public function getOrganizations(): Collection
    {
        return $this->Organizations;
    }
}
