<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\AttendanceListRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Gedmo\Blameable\Traits\BlameableEntity;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=AttendanceListRepository::class)
 * @Gedmo\Loggable
 * @Gedmo\SoftDeleteable(fieldName="deletedAt")
 */
class AttendanceList
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
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $listName;

    /**
     * @ORM\ManyToOne(targetEntity=Event::class, inversedBy="attendanceLists")
     */
    private $Event;

    /**
     * @ORM\ManyToOne(targetEntity=ProgramMembership::class, inversedBy="attendanceLists")
     */
    private $programMembership;

    /**
     * @ORM\OneToMany(targetEntity=Presence::class, mappedBy="attendanceList", orphanRemoval=true)
     */
    private $presence;

    public function __construct()
    {
        $this->presence = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getListName(): ?string
    {
        return $this->listName;
    }

    public function setListName(string $listName): self
    {
        $this->listName = $listName;

        return $this;
    }

    public function getEvent(): ?Event
    {
        return $this->Event;
    }

    public function setEvent(?Event $Event): self
    {
        $this->Event = $Event;

        return $this;
    }

    public function getProgramMembership(): ?ProgramMembership
    {
        return $this->programMembership;
    }

    public function setProgramMembership(?ProgramMembership $programMembership): self
    {
        $this->programMembership = $programMembership;

        return $this;
    }

    /**
     * @return Collection|Presence[]
     */
    public function getPresence(): Collection
    {
        return $this->presence;
    }

    public function addPresence(Presence $presence): self
    {
        if (!$this->presence->contains($presence)) {
            $this->presence[] = $presence;
            $presence->setAttendanceList($this);
        }

        return $this;
    }

    public function removePresence(Presence $presence): self
    {
        if ($this->presence->removeElement($presence)) {
            // set the owning side to null (unless already changed)
            if ($presence->getAttendanceList() === $this) {
                $presence->setAttendanceList(null);
            }
        }

        return $this;
    }
}
