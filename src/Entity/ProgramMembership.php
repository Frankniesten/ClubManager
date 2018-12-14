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
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\OrderFilter;
use ApiPlatform\Core\Serializer\Filter\PropertyFilter;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Used to describe membership in a loyalty programs (e.g. "StarAliance"), traveler clubs (e.g. "AAA"), purchase clubs ("Safeway Club"), etc.
 *
 * @see http://schema.org/ProgramMembership Documentation on Schema.org
 *
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 * @ApiFilter(SearchFilter::class)
 * @ApiFilter(OrderFilter::class)
 * @ApiFilter(PropertyFilter::class)
 * @ApiResource(iri="http://schema.org/ProgramMembership")
 */
class ProgramMembership
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
     * @var string the program providing the membership
     *
     * @ORM\Column(type="text")
     * @ApiProperty(iri="http://schema.org/programName")
     * @Assert\NotNull
     */
    private $programName;

    /**
     * @var string|null a description of the item
     *
     * @ORM\Column(type="text", nullable=true)
     * @ApiProperty(iri="http://schema.org/description")
     */
    private $description;

	/** @ORM\Column(name="datecreated", type="datetime")
	*/
    protected $dateCreated;

    /** @ORM\Column(name="datemodified", type="datetime")
	*/
    protected $dateModified;
    
    
    public function getId(): ?int
    {
        return $this->id;
    }

    public function setProgramName(string $programName): void
    {
        $this->programName = $programName;
    }

    public function getProgramName(): string
    {
        return $this->programName;
    }

    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }
    
    /**
     * @ORM\PrePersist()
     */
    public function updateCreatedDatetime()
    {
        $this->setDateCreated(new \DateTime());
    }

    /**
     * Set dateModified
     *
     * @param \DateTime $dateCreated
     * @return User
     */
    public function setDateCreated($dateCreated)
    {
        $this->dateCreated = $dateCreated;

        return $this;
    }

    /**
     * Get dateCreated 
     * @return \DateTime 
     */
    public function getDateCreated()
    {
        return $this->dateCreated;
    }

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function updateModifiedDatetime()
    {
        $this->setDateModified(new \DateTime());
    }

    /**
     * Set dateModified
     *
     * @param \DateTime $dateModified
     * @return User
     */
    public function setDateModified($dateModified)
    {
        $this->dateModified = $dateModified;

        return $this;
    }

    /**
     * Get dateModified
     *
     * @return \DateTime 
     */
    public function getDateModified()
    {
        return $this->dateModified;
    }
}
