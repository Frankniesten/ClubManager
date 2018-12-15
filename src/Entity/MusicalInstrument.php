<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass="App\Repository\MusicalInstrumentRepository")
 */
class MusicalInstrument
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
