<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use App\Repository\BankAccountRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Serializer\Filter\PropertyFilter;
use Gedmo\Blameable\Traits\BlameableEntity;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Timestampable\Traits\TimestampableEntity;


/**
 * @ApiResource()
 * @ApiFilter(PropertyFilter::class, arguments={"parameterName": "properties", "overrideDefaultProperties": false, "whitelist": null})
 * @ApiFilter(SearchFilter::class, properties={"id": "exact", "consumerAccount": "exact"})
 * @ORM\Entity(repositoryClass=BankAccountRepository::class)
 * @Gedmo\Loggable
 */
class BankAccount
{
    use TimestampableEntity;
    use BlameableEntity;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Gedmo\Versioned
     */
    private $consumerAccount;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Gedmo\Versioned
     */
    private $consumerBic;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Gedmo\Versioned
     */
    private $consumerName;

    /**
     * @ORM\ManyToOne(targetEntity=Person::class, inversedBy="bankAccounts")
     */
    private $person;

    /**
     * @ORM\ManyToOne(targetEntity=Organization::class, inversedBy="bankAccounts")
     */
    private $organization;

    /**
     * @ORM\OneToMany(targetEntity=Donation::class, mappedBy="bankAccount")
     */
    private $donations;

    public function __construct()
    {
        $this->donations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getConsumerAccount(): ?string
    {
        return $this->consumerAccount;
    }

    public function setConsumerAccount(string $consumerAccount): self
    {
        $this->consumerAccount = $consumerAccount;

        return $this;
    }

    public function getConsumerBic(): ?string
    {
        return $this->consumerBic;
    }

    public function setConsumerBic(?string $consumerBic): self
    {
        $this->consumerBic = $consumerBic;

        return $this;
    }

    public function getConsumerName(): ?string
    {
        return $this->consumerName;
    }

    public function setConsumerName(?string $consumerName): self
    {
        $this->consumerName = $consumerName;

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

    /**
     * @return Collection|Donation[]
     */
    public function getDonations(): Collection
    {
        return $this->donations;
    }

    public function addDonation(Donation $donation): self
    {
        if (!$this->donations->contains($donation)) {
            $this->donations[] = $donation;
            $donation->setBankAccount($this);
        }

        return $this;
    }

    public function removeDonation(Donation $donation): self
    {
        if ($this->donations->removeElement($donation)) {
            // set the owning side to null (unless already changed)
            if ($donation->getBankAccount() === $this) {
                $donation->setBankAccount(null);
            }
        }

        return $this;
    }
}
