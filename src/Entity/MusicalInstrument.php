<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Gedmo\Blameable\Traits\BlameableEntity;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass="App\Repository\MusicalInstrumentRepository")
 * @Gedmo\Loggable
 * @Gedmo\SoftDeleteable(fieldName="deletedAt")
 */
class MusicalInstrument
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
    private $musicalInstrument;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMusicalInstrument(): ?string
    {
        return $this->musicalInstrument;
    }

    public function setMusicalInstrument(string $musicalInstrument): self
    {
        $this->musicalInstrument = $musicalInstrument;

        return $this;
    }
}
