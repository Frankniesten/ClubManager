<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\BankAccountRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=BankAccountRepository::class)
 */
class BankAccount
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $consumerAccount;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $consumerBic;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
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
}
